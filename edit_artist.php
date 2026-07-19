<?php

include 'db_connect.php';
include 'validation.php';

if (!isset($_GET['id']) || !validateID($_GET['id'])) {

    echo "<script>

    alert('Invalid artist ID');

    window.location='view_artists.php';

    </script>";

    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare(

    "SELECT * FROM artists WHERE Artist_ID=?"

);

$stmt->bind_param(

    "i",

    $id

);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {

    echo "<script>

    alert('Artist not found');

    window.location='view_artists.php';

    </script>";

    exit();
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $specialization = trim($_POST['specialization']);
    $experience_years = $_POST['experience_years'];

    if (!validateName($name)) {

        echo "<script>alert('Invalid name');</script>";

    }

    elseif (!validatePhone($phone)) {

        echo "<script>alert('Phone number must contain exactly 11 digits');</script>";

    }

    elseif (!validateEmail($email)) {

        echo "<script>alert('Invalid email');</script>";

    }

    elseif (!validateExperience($experience_years)) {

        echo "<script>alert('Invalid experience');</script>";

    }

    else {

        $check = $conn->prepare(

            "SELECT Artist_ID
             FROM artists
             WHERE (Email=? OR Phone=?)
             AND Artist_ID != ?"

        );

        $check->bind_param(

            "ssi",

            $email,
            $phone,
            $id

        );

        $check->execute();

        $existing = $check->get_result();

        if ($existing->num_rows > 0) {

            echo "<script>alert('Email or phone already exists');</script>";

        }

        else {

            $update = $conn->prepare(

                "UPDATE artists
                 SET Name=?,
                     Phone=?,
                     Email=?,
                     Address=?,
                     Specialization=?,
                     Experience_Years=?
                 WHERE Artist_ID=?"

            );

            $update->bind_param(

                "sssssii",

                $name,
                $phone,
                $email,
                $address,
                $specialization,
                $experience_years,
                $id

            );

            if ($update->execute()) {

                header("Location: view_artists.php");
                exit();

            }

            else {

                echo "Error updating artist";

            }

        }

    }

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Edit Artist</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">

    <h1 class="text-3xl font-bold text-amber-900 mb-6">

        Edit Artist

    </h1>

    <form method="POST" class="space-y-4">

        <input
            type="text"
            name="name"
            value="<?php echo htmlspecialchars($row['Name']); ?>"
            required
            class="w-full border p-3 rounded">

        <input
            type="text"
            name="phone"
            value="<?php echo htmlspecialchars($row['Phone']); ?>"
            pattern="[0-9]{11}"
            maxlength="11"
            required
            class="w-full border p-3 rounded">

        <input
            type="email"
            name="email"
            value="<?php echo htmlspecialchars($row['Email']); ?>"
            required
            class="w-full border p-3 rounded">

        <textarea
    name="address"
    rows="3"
    required
    class="w-full border p-3 rounded"><?php echo htmlspecialchars($row['Address']); ?></textarea>

        <input
            type="text"
            name="specialization"
            value="<?php echo htmlspecialchars($row['Specialization']); ?>"
            required
            class="w-full border p-3 rounded">

        <input
            type="number"
            name="experience_years"
            value="<?php echo htmlspecialchars($row['Experience_Years']); ?>"
            min="0"
            required
            class="w-full border p-3 rounded">

        <button
            type="submit"
            name="update"
            class="bg-amber-700 text-white px-5 py-3 rounded">

            Update Artist

        </button>

    </form>

</div>

</body>

</html>
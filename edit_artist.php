<?php

include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM artists WHERE Artist_ID = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $specialization = $_POST['specialization'];
    $experience_years = $_POST['experience_years'];

    $update = "UPDATE artists
               SET Name='$name',
                   Phone='$phone',
                   Email='$email',
                   Address='$address',
                   Specialization='$specialization',
                   Experience_Years='$experience_years'
               WHERE Artist_ID=$id";

    if (mysqli_query($conn, $update)) {

        header("Location: view_artists.php");

    } else {

        echo "Error: " . mysqli_error($conn);

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

        <input type="text"
               name="name"
               value="<?php echo $row['Name']; ?>"
               class="w-full border p-3 rounded">

        <input type="text"
               name="phone"
               value="<?php echo $row['Phone']; ?>"
               class="w-full border p-3 rounded">

        <input type="email"
               name="email"
               value="<?php echo $row['Email']; ?>"
               class="w-full border p-3 rounded">

        <textarea
            name="address"
            class="w-full border p-3 rounded"><?php echo $row['Address']; ?></textarea>

        <input type="text"
               name="specialization"
               value="<?php echo $row['Specialization']; ?>"
               class="w-full border p-3 rounded">

        <input type="number"
               name="experience_years"
               value="<?php echo $row['Experience_Years']; ?>"
               class="w-full border p-3 rounded">

        <button type="submit"
                name="update"
                class="bg-amber-700 text-white px-5 py-3 rounded">

            Update Artist

        </button>

    </form>

</div>

</body>

</html>
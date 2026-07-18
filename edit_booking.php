<?php

include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM bookings WHERE Booking_ID = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $customer_id = $_POST['customer_id'];
    $artist_id = $_POST['artist_id'];
    $design_id = $_POST['design_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];

    $update = "UPDATE bookings
               SET Customer_ID='$customer_id',
                   Artist_ID='$artist_id',
                   Design_ID='$design_id',
                   Booking_Date='$booking_date',
                   Booking_Time='$booking_time'
               WHERE Booking_ID=$id";

    if (mysqli_query($conn, $update)) {

        header("Location: view_bookings.php");

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Edit Booking</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">

    <h1 class="text-3xl font-bold text-amber-900 mb-6">

        Edit Booking

    </h1>

    <form method="POST" class="space-y-4">

        <input type="number"
               name="customer_id"
               value="<?php echo $row['Customer_ID']; ?>"
               class="w-full border p-3 rounded">

        <input type="number"
               name="artist_id"
               value="<?php echo $row['Artist_ID']; ?>"
               class="w-full border p-3 rounded">

        <input type="number"
               name="design_id"
               value="<?php echo $row['Design_ID']; ?>"
               class="w-full border p-3 rounded">

        <input type="date"
               name="booking_date"
               value="<?php echo $row['Booking_Date']; ?>"
               class="w-full border p-3 rounded">

        <input type="time"
               name="booking_time"
               value="<?php echo $row['Booking_Time']; ?>"
               class="w-full border p-3 rounded">

        <button type="submit"
                name="update"
                class="bg-amber-700 text-white px-5 py-3 rounded">

            Update Booking

        </button>

    </form>

</div>

</body>

</html>
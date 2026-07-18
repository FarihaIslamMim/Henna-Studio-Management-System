<?php

include 'db_connect.php';

$id = $_GET['id'];

try {

    $sql = "DELETE FROM bookings WHERE Booking_ID = $id";

    mysqli_query($conn, $sql);

    header("Location: view_bookings.php");

} catch (mysqli_sql_exception $e) {

    echo "<script>

            alert('This booking cannot be deleted because it already has payment records.');

            window.location.href = 'view_bookings.php';

          </script>";
}

?>
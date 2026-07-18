<?php

include 'db_connect.php';

$id = $_GET['id'];

try {

    $sql = "DELETE FROM artists WHERE Artist_ID = $id";

    mysqli_query($conn, $sql);

    header("Location: view_artists.php");

} catch (mysqli_sql_exception $e) {

    echo "<script>

            alert('This artist cannot be deleted because they already have bookings.');

            window.location.href = 'view_artists.php';

          </script>";
}

?>
<?php

include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM payments WHERE Payment_ID = $id";

if (mysqli_query($conn, $sql)) {

    header("Location: view_payments.php");

} else {

    echo "Error deleting payment: " . mysqli_error($conn);

}

?>
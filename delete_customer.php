<?php

include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM customers WHERE Customer_ID = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: view_customers.php");
} else {
    echo "Error deleting customer: " . mysqli_error($conn);
}

?>
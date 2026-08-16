<?php

include 'db_connect.php';

$id=$_GET['id'];

$stmt=$conn->prepare(
"UPDATE customers
SET Status='Active'
WHERE Customer_ID=?"
);

$stmt->bind_param("i",$id);

$stmt->execute();

header("Location: view_customers.php");

exit();

?>
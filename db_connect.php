<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "henna studio management & booking system"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully";

?>
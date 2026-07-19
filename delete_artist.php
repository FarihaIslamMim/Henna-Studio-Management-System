<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}

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



// Check artist exists

$check = $conn->prepare(

    "SELECT Artist_ID FROM artists WHERE Artist_ID=?"

);

$check->bind_param(

    "i",

    $id

);

$check->execute();

$result = $check->get_result();



if ($result->num_rows == 0) {

    echo "<script>
    alert('Artist not found');
    window.location='view_artists.php';
    </script>";

    exit();

}



// Delete artist

$delete = $conn->prepare(

    "DELETE FROM artists WHERE Artist_ID=?"

);


$delete->bind_param(

    "i",

    $id

);



if ($delete->execute()) {


    echo "<script>

    alert('Artist deleted successfully');

    window.location='view_artists.php';

    </script>";


}

else {


    echo "<script>

    alert('Cannot delete artist. This artist may have related bookings.');

    window.location='view_artists.php';

    </script>";


}


?>
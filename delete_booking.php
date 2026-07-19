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

    alert('Invalid booking ID');

    window.location='view_bookings.php';

    </script>";

    exit();

}



$id = (int) $_GET['id'];




// Check booking exists

$check = $conn->prepare(

    "SELECT Booking_ID FROM bookings WHERE Booking_ID=?"

);


$check->bind_param(

    "i",

    $id

);


$check->execute();


$result = $check->get_result();



if($result->num_rows == 0){


    echo "<script>

    alert('Booking not found');

    window.location='view_bookings.php';

    </script>";

    exit();

}




// Check related records before delete

$related = $conn->prepare(

    "SELECT 
        (SELECT COUNT(*) FROM payments WHERE Booking_ID=?) AS payment_count,
        (SELECT COUNT(*) FROM reviews WHERE Booking_ID=?) AS review_count"

);


$related->bind_param(

    "ii",

    $id,
    $id

);


$related->execute();


$data = $related->get_result()->fetch_assoc();



if($data['payment_count'] > 0 || $data['review_count'] > 0){


    echo "<script>

    alert('This booking cannot be deleted because it has payment or review records.');

    window.location='view_bookings.php';

    </script>";

    exit();

}




// Delete booking

$delete = $conn->prepare(

    "DELETE FROM bookings WHERE Booking_ID=?"

);


$delete->bind_param(

    "i",

    $id

);



if($delete->execute()){


    echo "<script>

    alert('Booking deleted successfully');

    window.location='view_bookings.php';

    </script>";

}


else{


    echo "<script>

    alert('Booking deletion failed');

    window.location='view_bookings.php';

    </script>";

}



?>
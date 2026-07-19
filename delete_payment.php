<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';
include 'validation.php';



// Validate ID

if (!isset($_GET['id']) || !validateID($_GET['id'])) {


    echo "<script>

    alert('Invalid payment ID');

    window.location='view_payments.php';

    </script>";

    exit();

}



$id = (int) $_GET['id'];




// Check payment exists

$check = $conn->prepare(

    "SELECT Payment_ID FROM payments WHERE Payment_ID=?"

);


$check->bind_param(

    "i",

    $id

);


$check->execute();


$result = $check->get_result();



if($result->num_rows == 0){


    echo "<script>

    alert('Payment not found');

    window.location='view_payments.php';

    </script>";

    exit();

}




// Delete payment

$delete = $conn->prepare(

    "DELETE FROM payments WHERE Payment_ID=?"

);


$delete->bind_param(

    "i",

    $id

);



if($delete->execute()){


    echo "<script>

    alert('Payment deleted successfully');

    window.location='view_payments.php';

    </script>";

}


else{


    echo "<script>

    alert('Payment deletion failed');

    window.location='view_payments.php';

    </script>";

}



?>
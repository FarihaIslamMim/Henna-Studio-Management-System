<?php

session_start();


if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}



include 'db_connect.php';
include 'validation.php';





if(!isset($_GET['id']) || !validateID($_GET['id'])){


    echo "<script>

    alert('Invalid customer ID');

    window.location='view_customers.php';

    </script>";

    exit();

}



$id = $_GET['id'];




// Check customer exists before deleting

$check = $conn->prepare(

    "SELECT Customer_ID FROM customers WHERE Customer_ID=?"

);


$check->bind_param(

    "i",

    $id

);


$check->execute();


$result = $check->get_result();




if($result->num_rows == 0){


    echo "<script>

    alert('Customer not found');

    window.location='view_customers.php';

    </script>";

    exit();


}


// Check if customer has any bookings

$bookingCheck = $conn->prepare(

"SELECT Booking_ID
FROM bookings
WHERE Customer_ID=?"

);

$bookingCheck->bind_param(

"i",

$id

);

$bookingCheck->execute();

$bookingResult = $bookingCheck->get_result();

if($bookingResult->num_rows > 0){

    echo "<script>

    alert('Cannot delete this customer because they have booking records.');

    window.location='view_customers.php';

    </script>";

    exit();

}

// Delete customer

$delete = $conn->prepare(

    "DELETE FROM customers WHERE Customer_ID=?"

);


$delete->bind_param(

    "i",

    $id

);





if($delete->execute()){


    echo "<script>

    alert('Customer deleted successfully');

    window.location='view_customers.php';

    </script>";


}

else{


    echo "<script>

    alert('Cannot delete customer. This customer may have related bookings.');

    window.location='view_customers.php';

    </script>";


}



?>
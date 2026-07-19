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

    alert('Invalid design ID');

    window.location='view_designs.php';

    </script>";

    exit();

}



$id = $_GET['id'];




// Check design exists

$check = $conn->prepare(

    "SELECT Design_ID FROM designs WHERE Design_ID=?"

);


$check->bind_param(

    "i",

    $id

);


$check->execute();


$result = $check->get_result();



if($result->num_rows == 0){


    echo "<script>

    alert('Design not found');

    window.location='view_designs.php';

    </script>";

    exit();

}




// Delete design

$delete = $conn->prepare(

    "DELETE FROM designs WHERE Design_ID=?"

);


$delete->bind_param(

    "i",

    $id

);



try{


    if($delete->execute()){


        echo "<script>

        alert('Design deleted successfully');

        window.location='view_designs.php';

        </script>";


    }


}


catch(mysqli_sql_exception $e){


    echo "<script>

    alert('This design cannot be deleted because it is already used in bookings.');

    window.location='view_designs.php';

    </script>";


}


?>
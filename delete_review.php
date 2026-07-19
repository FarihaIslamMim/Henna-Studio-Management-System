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

    alert('Invalid review ID');

    window.location='view_reviews.php';

    </script>";

    exit();

}



$id = (int) $_GET['id'];



// Check review exists

$check = $conn->prepare(

    "SELECT Review_ID FROM reviews WHERE Review_ID=?"

);


$check->bind_param(

    "i",

    id

);


$check->execute();


$result = $check->get_result();



if ($result->num_rows == 0) {


    echo "<script>

    alert('Review not found');

    window.location='view_reviews.php';

    </script>";

    exit();

}




try {


    $delete = $conn->prepare(

        "DELETE FROM reviews WHERE Review_ID=?"

    );


    $delete->bind_param(

        "i",

        $id

    );


    if ($delete->execute()) {


        echo "<script>

        alert('Review deleted successfully');

        window.location='view_reviews.php';

        </script>";

    }


}


catch (mysqli_sql_exception $e) {


    echo "<script>

    alert('This review cannot be deleted because it is connected with other records.');

    window.location='view_reviews.php';

    </script>";

}


?>
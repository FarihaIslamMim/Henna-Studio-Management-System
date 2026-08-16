<?php

include 'db_connect.php';


$id = $_GET['id'];

$stmt = $conn->prepare(

"UPDATE customers
SET Status='Inactive'
WHERE Customer_ID=?"

);


$stmt->bind_param("i",$id);


if($stmt->execute()){

    echo "<script>

    alert('Customer moved to inactive list');

    window.location='view_customers.php';

    </script>";

}

else{

    echo "<script>

    alert('Delete failed');

    window.location='view_customers.php';

    </script>";

}


?>
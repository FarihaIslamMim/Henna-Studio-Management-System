<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';



$search = "";



if(isset($_GET['search']) && $_GET['search'] != ""){


    $search = trim($_GET['search']);



    $stmt = $conn->prepare(

        "SELECT
            payments.*,
            customers.Name AS Customer_Name,
            designs.Design_Name

        FROM payments

        LEFT JOIN bookings
        ON payments.Booking_ID = bookings.Booking_ID

        LEFT JOIN customers
        ON bookings.Customer_ID = customers.Customer_ID

        LEFT JOIN designs
        ON bookings.Design_ID = designs.Design_ID

        WHERE customers.Name LIKE ?
        OR payments.Booking_ID LIKE ?
        OR payments.Payment_Method LIKE ?
        OR payments.Payment_Status LIKE ?"

    );



    $keyword = "%".$search."%";



    $stmt->bind_param(

        "ssss",

        $keyword,
        $keyword,
        $keyword,
        $keyword

    );


}

else{


    $stmt = $conn->prepare(

        "SELECT
            payments.*,
            customers.Name AS Customer_Name,
            designs.Design_Name

        FROM payments

        LEFT JOIN bookings
        ON payments.Booking_ID = bookings.Booking_ID

        LEFT JOIN customers
        ON bookings.Customer_ID = customers.Customer_ID

        LEFT JOIN designs
        ON bookings.Design_ID = designs.Design_ID"

    );


}



$stmt->execute();

$result = $stmt->get_result();


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Payment Management</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>



<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">


<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Payment Management

</h1>



<a href="admin_dashboard.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Dashboard

</a>


</div>


</nav>





<div class="max-w-7xl mx-auto mt-10 px-6">



<h1 class="text-4xl font-bold text-amber-900 mb-6">

Payment List

</h1>





<form method="GET" class="mb-6 flex gap-3">


<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

placeholder="Search customer, booking ID, method or status"

class="border p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-5 rounded-lg">

Search

</button>


</form>






<div class="overflow-x-auto">


<table class="w-full bg-white shadow-xl rounded-lg">



<tr class="bg-amber-800 text-white">


<th class="p-4">Payment ID</th>

<th class="p-4">Booking ID</th>

<th class="p-4">Customer</th>

<th class="p-4">Design</th>

<th class="p-4">Amount</th>

<th class="p-4">Method</th>

<th class="p-4">Date</th>

<th class="p-4">Status</th>

<th class="p-4">Action</th>


</tr>




<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr class="border text-center hover:bg-orange-50">



<td class="p-4">

<?php echo htmlspecialchars($row['Payment_ID']); ?>

</td>



<td class="p-4">

<?php echo htmlspecialchars($row['Booking_ID']); ?>

</td>



<td class="p-4">

<?php echo htmlspecialchars($row['Customer_Name']); ?>

</td>



<td class="p-4">

<?php echo htmlspecialchars($row['Design_Name']); ?>

</td>



<td class="p-4">

৳<?php echo htmlspecialchars($row['Amount']); ?>

</td>



<td class="p-4">

<?php echo htmlspecialchars($row['Payment_Method']); ?>

</td>



<td class="p-4">

<?php echo htmlspecialchars($row['Payment_Date']); ?>

</td>



<td class="p-4 font-bold">


<?php


if($row['Payment_Status']=="Paid"){


echo "<span class='text-green-600'>Paid</span>";


}

elseif($row['Payment_Status']=="Refunded"){


echo "<span class='text-blue-600'>Refunded</span>";


}

else{


echo "<span class='text-red-600'>Unpaid</span>";


}


?>


</td>




<td class="p-4">


<a href="edit_payment.php?id=<?php echo $row['Payment_ID']; ?>"

class="text-blue-600 font-semibold">

Edit

</a>




<a href="delete_payment.php?id=<?php echo $row['Payment_ID']; ?>"

onclick="return confirm('Delete this payment?')"

class="text-red-600 font-semibold ml-4">

Delete

</a>


</td>


</tr>


<?php } ?>



</table>


</div>





<div class="mt-8">


<a href="payments.php"

class="bg-amber-700 text-white px-6 py-3 rounded-lg">

Add New Payment

</a>


</div>



</div>


</body>

</html>
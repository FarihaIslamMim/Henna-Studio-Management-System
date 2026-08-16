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

        "SELECT * FROM customers
         WHERE Status='Active'
         AND (Name LIKE ? OR Phone LIKE ? OR Email LIKE ?)"

    );


    $like = "%".$search."%";


    $stmt->bind_param(

        "sss",

        $like,
        $like,
        $like

    );


    $stmt->execute();


    $result = $stmt->get_result();


}

else{


    $result = mysqli_query(

        $conn,

        "SELECT * FROM customers 
         WHERE Status='Active'
         ORDER BY Customer_ID ASC"

    );


}



$count_result = mysqli_query(

    $conn,

    "SELECT COUNT(*) AS total 
     FROM customers
     WHERE Status='Active'"

);


$count = mysqli_fetch_assoc($count_result);


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Customer List</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">
Customer Management
</h1>


<div class="flex gap-4 ml-auto">


<a href="inactive_customers.php"

class="bg-white text-amber-800 px-5 py-2 rounded-lg">

View Inactive Customers

</a>


<a href="admin_dashboard.php"

class="bg-white text-amber-800 px-5 py-2 rounded-lg">

← Back to Dashboard

</a>


</div>


</div>

</nav>



<div class="max-w-7xl mx-auto mt-10 px-6">



<div class="flex justify-between items-center mb-6">


<h1 class="text-4xl font-bold text-amber-900">

Customer List

</h1>



<div class="bg-white shadow px-5 py-3 rounded-lg">

Total Customers:

<span class="font-bold text-amber-800">

<?php echo $count['total']; ?>

</span>


</div>


</div>





<form method="GET" class="mb-6 flex gap-3">


<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

placeholder="Search by name, phone or email"

class="border border-gray-300 p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-5 rounded-lg hover:bg-amber-900">

Search

</button>


</form>





<div class="overflow-x-auto">


<table class="w-full bg-white shadow-xl rounded-lg overflow-hidden">


<tr class="bg-amber-800 text-white">


<th class="p-4">ID</th>

<th class="p-4">Name</th>

<th class="p-4">Phone</th>

<th class="p-4">Email</th>

<th class="p-4">Address</th>

<th class="p-4">Registration Date</th>

<th class="p-4">Action</th>


</tr>




<?php while($row = mysqli_fetch_assoc($result)){ ?>


<tr class="border text-center hover:bg-orange-50">


<td class="p-4">

<?php echo $row['Customer_ID']; ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Name']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Phone']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Email']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Address']); ?>

</td>


<td class="p-4">

<?php echo $row['Registration_Date']; ?>

</td>



<td class="p-4">


<a href="edit_customer.php?id=<?php echo $row['Customer_ID']; ?>"

class="text-blue-600 font-semibold">

Edit

</a>




<a 
href="delete_customer.php?id=<?php echo $row['Customer_ID']; ?>"
onclick="return confirm('Are you sure you want to delete this customer?');"
class="text-red-600">

Delete

</a>


</td>


</tr>


<?php } ?>


</table>


</div>





<div class="mt-8">


<a href="customers.php"

class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

Add New Customer

</a>


</div>




</div>


</body>

</html>
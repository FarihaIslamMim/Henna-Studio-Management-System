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

        "SELECT * FROM designs

        WHERE Design_Name LIKE ?
        OR Category LIKE ?
        OR Availability LIKE ?"

    );


    $keyword = "%".$search."%";


    $stmt->bind_param(

        "sss",

        $keyword,
        $keyword,
        $keyword

    );


    $stmt->execute();


    $result = $stmt->get_result();


}
else{


    $result = mysqli_query(

        $conn,

        "SELECT * FROM designs"

    );


}



$count_result = mysqli_query(

    $conn,

    "SELECT COUNT(*) AS total FROM designs"

);


$count = mysqli_fetch_assoc($count_result);


?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>View Designs</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">


<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Design Management

</h1>



<a href="admin_dashboard.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Dashboard

</a>


</div>


</nav>





<div class="max-w-7xl mx-auto mt-10 px-6">


<div class="flex justify-between items-center mb-6">


<h1 class="text-4xl font-bold text-amber-900">

All Henna Designs

</h1>



<div class="bg-white shadow px-5 py-3 rounded-lg">


Total Designs:

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

placeholder="Search design, category or status"

class="border p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-5 rounded-lg">

Search

</button>



<a href="view_designs.php"

class="bg-gray-500 text-white px-5 py-3 rounded-lg">

Reset

</a>


</form>






<div class="overflow-x-auto">


<table class="w-full bg-white shadow-xl rounded-lg">


<tr class="bg-amber-800 text-white">


<th class="p-4">ID</th>

<th class="p-4">Name</th>

<th class="p-4">Category</th>

<th class="p-4">Price</th>

<th class="p-4">Availability</th>

<th class="p-4">Description</th>

<th class="p-4">Action</th>


</tr>




<?php if(mysqli_num_rows($result) > 0){ ?>


<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr class="border text-center hover:bg-orange-50">


<td class="p-4">

<?php echo htmlspecialchars($row['Design_ID']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Design_Name']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Category']); ?>

</td>


<td class="p-4">

৳<?php echo htmlspecialchars($row['Price']); ?>

</td>


<td class="p-4">


<span class="<?php echo ($row['Availability']=="Available") ? 'text-green-600 font-bold':'text-red-600 font-bold'; ?>">


<?php echo htmlspecialchars($row['Availability']); ?>


</span>


</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Description']); ?>

</td>



<td class="p-4">


<a href="edit_design.php?id=<?php echo $row['Design_ID']; ?>"

class="text-blue-600 font-semibold">

Edit

</a>



<a href="delete_design.php?id=<?php echo $row['Design_ID']; ?>"

onclick="return confirm('Delete this design?')"

class="text-red-600 font-semibold ml-4">

Delete

</a>


</td>


</tr>


<?php } ?>


<?php } else { ?>


<tr>

<td colspan="7" class="p-6 text-center text-gray-600">

No designs found.

</td>

</tr>


<?php } ?>


</table>


</div>





<div class="mt-8">


<a href="add_design.php"

class="bg-amber-700 text-white px-6 py-3 rounded-lg">

Add New Design

</a>


</div>



</div>


</body>

</html>
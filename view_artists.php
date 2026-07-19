<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';



$search = "";



if(isset($_GET['search']) && $_GET['search'] != ""){


    $search = trim($_GET['search']);


    $stmt = $conn->prepare(

        "SELECT * FROM artists
         WHERE Name LIKE ?
         OR Phone LIKE ?
         OR Email LIKE ?
         OR Specialization LIKE ?"

    );


    $keyword = "%".$search."%";


    $stmt->bind_param(

        "ssss",

        $keyword,
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

        "SELECT * FROM artists ORDER BY Artist_ID DESC"

    );


}




$count_query = mysqli_query(

    $conn,

    "SELECT COUNT(*) AS total FROM artists"

);


$count = mysqli_fetch_assoc($count_query);



?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Artist Management</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Artist Management

</h1>


<a href="admin_dashboard.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-gray-200">

Dashboard

</a>


</div>

</nav>




<div class="max-w-7xl mx-auto mt-10 px-6">



<div class="flex justify-between items-center mb-6">


<h1 class="text-4xl font-bold text-amber-900">

Artist List

</h1>



<div class="bg-white shadow px-5 py-3 rounded-lg">

Total Artists:

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

placeholder="Search by name, phone, email or specialization"

class="border border-gray-300 p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-5 rounded-lg hover:bg-amber-900">

Search

</button>



<a href="view_artists.php"

class="bg-gray-500 text-white px-5 py-3 rounded-lg">

Reset

</a>


</form>






<div class="overflow-x-auto">


<table class="w-full bg-white shadow-xl rounded-lg overflow-hidden">


<tr class="bg-amber-800 text-white">


<th class="p-4">ID</th>

<th class="p-4">Name</th>

<th class="p-4">Phone</th>

<th class="p-4">Email</th>

<th class="p-4">Specialization</th>

<th class="p-4">Experience</th>

<th class="p-4">Joining Date</th>

<th class="p-4">Status</th>

<th class="p-4">Action</th>


</tr>





<?php if(mysqli_num_rows($result) > 0){ ?>


<?php while($row = mysqli_fetch_assoc($result)){ ?>


<tr class="border text-center hover:bg-orange-50">


<td class="p-4">

<?php echo htmlspecialchars($row['Artist_ID']); ?>

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

<?php echo htmlspecialchars($row['Specialization']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Experience_Years']); ?> years

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Joining_Date']); ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Status']); ?>

</td>




<td class="p-4">


<a href="edit_artist.php?id=<?php echo $row['Artist_ID']; ?>"

class="text-blue-600 font-semibold">

Edit

</a>




<a href="delete_artist.php?id=<?php echo $row['Artist_ID']; ?>"

onclick="return confirm('Delete this artist?')"

class="text-red-600 font-semibold ml-4">

Delete

</a>


</td>


</tr>


<?php } ?>


<?php } else { ?>


<tr>

<td colspan="9" class="p-6 text-center text-gray-600">

No artists found.

</td>

</tr>


<?php } ?>



</table>


</div>





<div class="mt-8">


<a href="artists.php"

class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

Add New Artist

</a>


</div>




</div>


</body>

</html>
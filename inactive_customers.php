<?php

include 'db_connect.php';

$result = mysqli_query($conn,

"SELECT *
 FROM customers
 WHERE Status='Inactive'
 ORDER BY Customer_ID ASC"

);

?>


<!DOCTYPE html>
<html>

<head>

<title>Inactive Customers</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 p-5 flex justify-between items-center shadow-lg">


<h1 class="text-white text-2xl font-bold">
Inactive Customers
</h1>


<a href="view_customers.php"

class="bg-white text-amber-800 px-5 py-2 rounded-lg">

← Back to Customer List

</a>


</nav>



<div class="max-w-6xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">


<h1 class="text-3xl font-bold text-amber-900 mb-6">

Inactive Customer List

</h1>



<table class="w-full border">


<tr class="bg-amber-700 text-white">


<th class="p-3 border">ID</th>

<th class="p-3 border">Name</th>

<th class="p-3 border">Phone</th>

<th class="p-3 border">Email</th>

<th class="p-3 border">Action</th>


</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr class="text-center">


<td class="p-3 border">

<?php echo $row['Customer_ID']; ?>

</td>



<td class="p-3 border">

<?php echo htmlspecialchars($row['Name']); ?>

</td>



<td class="p-3 border">

<?php echo htmlspecialchars($row['Phone']); ?>

</td>



<td class="p-3 border">

<?php echo htmlspecialchars($row['Email']); ?>

</td>



<td class="p-3 border">


<a 
href="restore_customer.php?id=<?php echo $row['Customer_ID']; ?>"

class="bg-green-600 text-white px-4 py-2 rounded-lg">

Restore

</a>


</td>


</tr>


<?php } ?>


</table>


</div>


</body>

</html>
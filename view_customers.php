<?php
include 'db_connect.php';

$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-orange-50">

<div class="max-w-6xl mx-auto mt-10">

<h1 class="text-3xl font-bold text-amber-900 mb-6">
Customer List
</h1>

<table class="w-full bg-white shadow-lg rounded-lg">

<tr class="bg-amber-800 text-white">
    <th class="p-3">ID</th>
    <th class="p-3">Name</th>
    <th class="p-3">Phone</th>
    <th class="p-3">Email</th>
    <th class="p-3">Address</th>
    <th class="p-3">Date</th>
    <th class="p-3">Action</th>
</tr>


<?php

while($row = mysqli_fetch_assoc($result)){

?>

<tr class="border text-center">

<td class="p-3">
<?php echo $row['Customer_ID']; ?>
</td>

<td class="p-3">
<?php echo $row['Name']; ?>
</td>

<td class="p-3">
<?php echo $row['Phone']; ?>
</td>

<td class="p-3">
<?php echo $row['Email']; ?>
</td>

<td class="p-3">
<?php echo $row['Address']; ?>
</td>

<td class="p-3">
<?php echo $row['Registration_Date']; ?>
</td>

<td class="p-3">
    <a href="edit_customer.php?id=<?php echo $row['Customer_ID']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
    <a href="delete_customer.php?id=<?php echo $row['Customer_ID']; ?>" class="text-red-500 hover:text-red-700 ml-2">Delete</a>
</td>

</tr>

<?php

}

?>

</table>

</div>

</body>
</html>
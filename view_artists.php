<?php

include 'db_connect.php';

$sql = "SELECT * FROM artists";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Artist List</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-7xl mx-auto mt-10">

<h1 class="text-3xl font-bold text-amber-900 mb-6">

Artist List

</h1>

<table class="w-full bg-white shadow-lg rounded-lg">

<tr class="bg-amber-800 text-white">

    <th class="p-3">ID</th>
    <th class="p-3">Name</th>
    <th class="p-3">Phone</th>
    <th class="p-3">Email</th>
    <th class="p-3">Specialization</th>
    <th class="p-3">Experience</th>
    <th class="p-3">Action</th>

</tr>

<?php

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr class="border text-center">

    <td class="p-3"><?php echo $row['Artist_ID']; ?></td>

    <td class="p-3"><?php echo $row['Name']; ?></td>

    <td class="p-3"><?php echo $row['Phone']; ?></td>

    <td class="p-3"><?php echo $row['Email']; ?></td>

    <td class="p-3"><?php echo $row['Specialization']; ?></td>

    <td class="p-3"><?php echo $row['Experience_Years']; ?></td>

    <td class="p-3">

        <a href="edit_artist.php?id=<?php echo $row['Artist_ID']; ?>" class="text-blue-500">
            Edit
        </a>

        <a href="delete_artist.php?id=<?php echo $row['Artist_ID']; ?>" class="text-red-500 ml-3">
            Delete
        </a>

    </td>

</tr>

<?php

}

?>

</table>

</div>

</body>

</html>
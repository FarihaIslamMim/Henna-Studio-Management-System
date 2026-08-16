<?php
include 'db_connect.php';

$result = null;

if(isset($_POST['search'])){

    $phone = "+880".trim($_POST['phone']);

    $stmt = $conn->prepare(

    "SELECT
    bookings.*,
    designs.Design_Code,
    artists.Name AS Artist_Name

    FROM bookings

    JOIN customers
    ON bookings.Customer_ID = customers.Customer_ID

    LEFT JOIN designs
    ON bookings.Design_ID = designs.Design_ID

    JOIN artists
    ON bookings.Artist_ID = artists.Artist_ID

    WHERE customers.Phone=?

    ORDER BY bookings.Booking_Date ASC"

    );

    $stmt->bind_param("s",$phone);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Booking History</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50 min-h-screen">

<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-white text-2xl font-bold">
Henna Studio
</h1>

<a href="index.php"
class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Home

</a>

</div>

</nav>


<div class="max-w-6xl mx-auto mt-10">

<h1 class="text-4xl font-bold text-center text-amber-800 mb-8">

Booking History

</h1>


<form method="POST" class="bg-white p-6 rounded-xl shadow-lg max-w-lg mx-auto">

<label class="font-semibold">
Enter Mobile Number
</label>

<div class="flex mt-2">

<span class="bg-gray-100 border border-r-0 rounded-l-lg px-4 py-3">

+880

</span>

<input
type="text"
name="phone"
maxlength="10"
required
placeholder="1712345678"
class="border rounded-r-lg w-full p-3">

</div>

<button
name="search"
class="bg-amber-700 hover:bg-amber-800 text-white mt-5 px-6 py-3 rounded-lg w-full">

View My Bookings

</button>

</form>


<?php if($result){ ?>

<div class="mt-10 bg-white rounded-xl shadow-lg overflow-hidden">

<table class="w-full">

<thead class="bg-amber-800 text-white">

<tr>

<th class="p-4">Booking ID</th>

<th class="p-4">Design</th>

<th class="p-4">Artist</th>

<th class="p-4">Date</th>

<th class="p-4">Time</th>

<th class="p-4">Status</th>

</tr>

</thead>

<tbody>

<?php
while($row = $result->fetch_assoc()){
?>

<tr class="text-center border-b hover:bg-orange-50">

<td class="p-4">

<?php echo $row['Booking_ID']; ?>

</td>

<td class="p-4">

<?php echo htmlspecialchars($row['Design_Code'] ?? 'Custom Design'); ?>

</td>

<td class="p-4">

<?php echo htmlspecialchars($row['Artist_Name']); ?>

</td>

<td class="p-4">

<?php echo $row['Booking_Date']; ?>

</td>

<td class="p-4">

<?php echo date("h:i A",strtotime($row['Booking_Time'])); ?>

</td>

<td class="p-4">

<?php
$status = strtoupper($row['Status']);

if($status=="CONFIRMED"){
    echo "<span class='bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold'>Confirmed</span>";
}
elseif($status=="PENDING"){
    echo "<span class='bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-semibold'>Pending</span>";
}
elseif($status=="CANCELLED"){
    echo "<span class='bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold'>Cancelled</span>";
}
else{
    echo "<span class='bg-gray-100 text-gray-700 px-3 py-1 rounded-full font-semibold'>Unknown</span>";
}
?>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

<?php } ?>

</div>

</body>

</html>
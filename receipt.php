<?php

include 'db_connect.php';

if(!isset($_GET['id'])){
    die("Invalid Payment");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare(

"SELECT

payments.*,

customers.Name,
customers.Phone,
customers.Email,

designs.Design_Code,

bookings.Booking_Date,
bookings.Booking_Time

FROM payments

JOIN bookings
ON payments.Booking_ID = bookings.Booking_ID

JOIN customers
ON bookings.Customer_ID = customers.Customer_ID

JOIN designs
ON bookings.Design_ID = designs.Design_ID

WHERE payments.Payment_ID=?"

);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows==0){

die("Receipt not found");

}

$row=$result->fetch_assoc();

?>
<!DOCTYPE html>

<html>

<head>

<title>Payment Receipt</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-xl mx-auto bg-white shadow-xl mt-10 p-8 rounded-xl">

<h1 class="text-3xl font-bold text-center text-amber-800">

Henna Studio Receipt

</h1>

<hr class="my-6">

<p><b>Receipt ID:</b> <?php echo $row['Payment_ID']; ?></p>

<p><b>Booking ID:</b> <?php echo $row['Booking_ID']; ?></p>

<p><b>Customer:</b> <?php echo $row['Name']; ?></p>

<p><b>Phone:</b> <?php echo $row['Phone']; ?></p>

<p><b>Email:</b> <?php echo $row['Email']; ?></p>

<p><b>Design:</b> <?php echo $row['Design_Code']; ?></p>

<p><b>Date:</b> <?php echo $row['Booking_Date']; ?></p>

<p><b>Time:</b> <?php echo $row['Booking_Time']; ?></p>

<p><b>Amount:</b> ৳<?php echo $row['Amount']; ?></p>

<p><b>Method:</b> <?php echo $row['Payment_Method']; ?></p>

<p><b>Status:</b> <?php echo $row['Payment_Status']; ?></p>

<p><b>Payment Date:</b> <?php echo $row['Payment_Date']; ?></p>

<div class="mt-8 flex gap-4">

<button
onclick="window.print()"
class="bg-green-600 text-white px-5 py-2 rounded">

Print Receipt

</button>

<a href="view_payments.php"
class="bg-amber-700 text-white px-5 py-2 rounded">

Back

</a>

</div>

</div>

</body>

</html>
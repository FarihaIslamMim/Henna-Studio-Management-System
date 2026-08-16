<?php

include 'db_connect.php';

if(!isset($_GET['booking_id'])){

    die("Invalid Booking");

}

$booking_id = intval($_GET['booking_id']);
$stmt=$conn->prepare(

"SELECT 
bookings.Booking_ID,
designs.Price,
designs.Design_Code

FROM bookings

LEFT JOIN designs
ON bookings.Design_ID = designs.Design_ID

WHERE bookings.Booking_ID=?"

);


$stmt->bind_param("i",$booking_id);

$stmt->execute();

$result=$stmt->get_result();

$booking=$result->fetch_assoc();


if(!$booking){

die("Booking not found");

}

if($booking['Price']==null){

    die("Custom design payment must be done after service.");

}

if(isset($_POST['submit'])){


$method = $_POST['payment_method'];

$date = date('Y-m-d');

$status = "Paid";

$amount = $booking['Price'];



$stmt=$conn->prepare(

"SELECT Booking_ID, Status
FROM bookings
WHERE Booking_ID=?"

);


$stmt->bind_param("i",$booking_id);

$stmt->execute();


$result=$stmt->get_result();



if($result->num_rows==0){

echo "<script>alert('Booking not found');</script>";

}

else{


$insert=$conn->prepare(

"INSERT INTO payments

(Booking_ID,Amount,Payment_Method,Payment_Date,Payment_Status)

VALUES(?,?,?,?,?)"

);


$insert->bind_param(

"idsss",

$booking_id,
$amount,
$method,
$date,
$status

);



if($insert->execute()){


echo "<script>

alert('Payment successful');

window.location='receipt.php?id=".$conn->insert_id."&from=customer';

</script>";


}


}


}

?>

<!DOCTYPE html>

<html>

<head>

<title>Customer Payment</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">


<h1 class="text-3xl font-bold text-amber-900 mb-6">

Make Payment

</h1>



<form method="POST" class="space-y-5">


<div class="bg-yellow-50 p-4 rounded-lg">

<p class="font-bold text-amber-900">

Booking ID:

<?php echo $booking['Booking_ID']; ?>

</p>

<p class="font-bold text-amber-900">

Design:

<?php echo $booking['Design_Code'] ?? 'Custom Design'; ?>

</p>

<p class="font-bold text-amber-900">

Amount:

৳<?php echo $booking['Price']; ?>

</p>

</div>

<select
name="payment_method"
class="w-full border p-3 rounded">

<option value="Bkash">Bkash</option>

<option value="Nagad">Nagad</option>

</select>

<button

name="submit"

class="bg-green-600 text-white px-6 py-3 rounded">

Pay Now

</button>

<a href="booking_history.php"

class="bg-gray-500 text-white px-6 py-3 rounded">

Cancel

</a>

</form>


</div>


</body>

</html>
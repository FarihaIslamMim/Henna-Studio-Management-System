<?php

include 'db_connect.php';


if(isset($_POST['submit'])){


$customer_id = intval($_POST['customer_id']);
$artist_id = intval($_POST['artist_id']);
$design_id = intval($_POST['design_id']);

$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];

$status = $_POST['status'];

$allowed_status = ["CONFIRMED","PENDING","CANCELLED"];



if($customer_id <=0 || $artist_id<=0 || $design_id<=0){

echo "<script>alert('Invalid ID information');</script>";

}


elseif(!in_array($status,$allowed_status)){

echo "<script>alert('Invalid booking status');</script>";

}



elseif($booking_date < date('Y-m-d')){

echo "<script>alert('Booking date cannot be in the past');</script>";

}



elseif($booking_time < "09:00" || $booking_time > "21:00"){

echo "<script>alert('Booking time must be between 9 AM and 9 PM');</script>";

}



else{


// Check customer

$stmt=$conn->prepare(

"SELECT Customer_ID FROM customers WHERE Customer_ID=?"

);

$stmt->bind_param("i",$customer_id);

$stmt->execute();

$customer=$stmt->get_result();



// Check artist active

$stmt=$conn->prepare(

"SELECT Artist_ID FROM artists 
 WHERE Artist_ID=? AND Status='Active'"

);

$stmt->bind_param("i",$artist_id);

$stmt->execute();

$artist=$stmt->get_result();



// Check design available

$stmt=$conn->prepare(

"SELECT Design_ID FROM designs
 WHERE Design_ID=? AND Availability='Available'"

);

$stmt->bind_param("i",$design_id);

$stmt->execute();

$design=$stmt->get_result();



if($customer->num_rows==0){

echo "<script>alert('Customer does not exist');</script>";

}

elseif($artist->num_rows==0){

echo "<script>alert('Artist does not exist or inactive');</script>";

}

elseif($design->num_rows==0){

echo "<script>alert('Design unavailable');</script>";

}


else{


// duplicate booking check


$stmt=$conn->prepare(

"SELECT Booking_ID 
FROM bookings
WHERE Artist_ID=?
AND Booking_Date=?
AND Booking_Time=?"

);


$stmt->bind_param(

"iss",

$artist_id,
$booking_date,
$booking_time

);


$stmt->execute();


$duplicate=$stmt->get_result();



if($duplicate->num_rows>0){


echo "<script>alert('Artist already booked at this time');</script>";


}


else{


$stmt=$conn->prepare(

"INSERT INTO bookings

(Customer_ID,Artist_ID,Design_ID,Booking_Date,Booking_Time,Status)

VALUES(?,?,?,?,?,?)"

);


$stmt->bind_param(

"iiisss",

$customer_id,
$artist_id,
$design_id,
$booking_date,
$booking_time,
$status

);



if($stmt->execute()){


echo "<script>

alert('Booking added successfully');

window.location='view_bookings.php';

</script>";


}

else{

echo "<script>alert('Booking failed');</script>";

}


}



}



}



}


?>



<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Booking</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">

<h1 class="text-white text-2xl font-bold">
Henna Studio
</h1>


<a href="admin_login.php"
class="text-white">

Admin

</a>


</div>

</nav>



<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-xl">


<h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

Booking Form

</h1>



<form method="POST" class="space-y-5">



<input type="number"
name="customer_id"
placeholder="Customer ID"
min="1"
required
class="w-full border p-3 rounded-lg">



<input type="number"
name="artist_id"
placeholder="Artist ID"
min="1"
required
class="w-full border p-3 rounded-lg">



<input type="number"
name="design_id"
placeholder="Design ID"
min="1"
required
class="w-full border p-3 rounded-lg">



<input type="date"
name="booking_date"
min="<?php echo date('Y-m-d');?>"
required
class="w-full border p-3 rounded-lg">



<input type="time"
name="booking_time"
required
class="w-full border p-3 rounded-lg">



<select name="status"
class="w-full border p-3 rounded-lg">


<option value="PENDING">
PENDING
</option>


<option value="CONFIRMED">
CONFIRMED
</option>


<option value="CANCELLED">
CANCELLED
</option>


</select>



<button name="submit"
class="bg-amber-700 text-white px-6 py-3 rounded-lg">

Save Booking

</button>



</form>


</div>


</body>

</html>
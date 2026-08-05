<?php

session_start();


if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';



// Dashboard counts

$customer_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM customers")
);


$artist_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM artists")
);


$booking_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM bookings")
);


$payment_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM payments")
);


$review_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM reviews")
);


$design_count = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM designs")
);

$pending_count = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM bookings
     WHERE Status='PENDING'")
);

$confirmed_count = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM bookings
     WHERE Status='CONFIRMED'")
);

$cancelled_count = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total
     FROM bookings
     WHERE Status='CANCELLED'")
);

$revenue = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT SUM(Amount) AS total
     FROM payments
     WHERE Payment_Status='Paid'")
);

$revenue['total'] = $revenue['total'] ?? 0;

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">


<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Henna Studio Admin Dashboard

</h1>



<div class="flex gap-4 items-center">


<span class="text-white">

Welcome, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>

</span>



<a href="logout.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Logout

</a>


</div>


</div>


</nav>






<div class="max-w-7xl mx-auto mt-10 px-6">



<h1 class="text-4xl font-bold text-center text-amber-900 mb-10">

Dashboard Overview

</h1>





<div class="grid md:grid-cols-3 gap-8">



<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Customers

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $customer_count['total']; ?>

</p>

<a href="view_customers.php"

class="text-blue-600 mt-4 inline-block">

Manage Customers

</a>

</div>





<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Artists

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $artist_count['total']; ?>

</p>

<a href="view_artists.php"

class="text-blue-600 mt-4 inline-block">

Manage Artists

</a>

</div>





<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Designs

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $design_count['total']; ?>

</p>

<a href="view_designs.php"

class="text-blue-600 mt-4 inline-block">

Manage Designs

</a>

</div>






<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Bookings

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $booking_count['total']; ?>

</p>

<a href="view_bookings.php"

class="text-blue-600 mt-4 inline-block">

Manage Bookings

</a>

</div>






<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Payments

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $payment_count['total']; ?>

</p>

<a href="view_payments.php"

class="text-blue-600 mt-4 inline-block">

Manage Payments

</a>

</div>






<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-gray-700">

Reviews

</h2>

<p class="text-4xl font-bold text-amber-800 mt-4">

<?php echo $review_count['total']; ?>

</p>

<a href="view_reviews.php"

class="text-blue-600 mt-4 inline-block">

Manage Reviews

</a>

</div>

<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-yellow-700">
Pending Bookings
</h2>

<p class="text-4xl font-bold text-yellow-600 mt-4">
<?php echo $pending_count['total']; ?>
</p>

<a href="view_bookings.php?status=PENDING"
class="text-blue-600 mt-4 inline-block">

Manage Pending

</a>

</div>

<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-green-700">
Confirmed Bookings
</h2>

<p class="text-4xl font-bold text-green-600 mt-4">
<?php echo $confirmed_count['total']; ?>
</p>

<a href="view_bookings.php?status=CONFIRMED"
class="text-blue-600 mt-4 inline-block">

Manage Confirmed

</a>

</div>
<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-red-700">
Cancelled Bookings
</h2>

<p class="text-4xl font-bold text-red-600 mt-4">
<?php echo $cancelled_count['total']; ?>
</p>

<a href="view_bookings.php?status=CANCELLED"
class="text-blue-600 mt-4 inline-block">

Manage Cancelled

</a>

</div>
<div class="bg-white shadow-xl rounded-2xl p-8 text-center">

<h2 class="text-xl font-bold text-emerald-700">
Total Revenue
</h2>

<p class="text-4xl font-bold text-emerald-600 mt-4">
৳<?php echo number_format($revenue['total'],2); ?>
</p>

<a href="view_payments.php?status=Paid"
class="text-blue-600 mt-4 inline-block">

Manage Payments

</a>

</div>

</div>


</div>



</body>

</html>
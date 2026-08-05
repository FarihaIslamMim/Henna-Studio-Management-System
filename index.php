<?php

include 'db_connect.php';

$count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM designs");
$artist_count = mysqli_query($conn,"SELECT COUNT(*) AS total FROM artists WHERE Status='Active'");
$artist_total = mysqli_fetch_assoc($artist_count);
$total = mysqli_fetch_assoc($count);

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Henna Studio Management & Booking System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<style>
body{
    font-family:'Poppins',sans-serif;
}
</style>

</head>

<body class="bg-[#F5EFE6] min-h-screen">

    <!-- Navbar -->

    <nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">

<h1 class="text-2xl font-bold text-white">
🌿 Henna Studio
</h1>

<div class="flex gap-8 text-white font-semibold">

<a href="index.php" class="hover:text-yellow-200 transition">
Home
</a>

<a href="designs.php" class="hover:text-yellow-200 transition">
Designs
</a>

<a href="bookings.php" class="hover:text-yellow-200 transition">
Book Appointment
</a>

<a href="admin_login.php" class="hover:text-yellow-200 transition">
Admin Login
</a>

</div>

</div>

</nav>

  <!-- Hero Section -->

<section class="relative mt-10">

<div class="h-[550px] rounded-3xl overflow-hidden mx-6 bg-[#D8C3A5]">


<div class="h-full bg-[#D8C3A5]/75 backdrop-blur-sm flex items-center justify-center text-center">


<div class="text-amber-900 max-w-4xl px-6">


<h1 class="text-5xl md:text-6xl font-bold leading-tight">

Elegant Henna Art For Your Special Moments

</h1>


<p class="text-xl mt-6 text-gray-700">

Professional henna artists, beautiful designs, and easy online booking.

</p>


<div class="mt-8 flex justify-center gap-5">


<a href="bookings.php"

class="border border-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-[#FFFDF9] hover:text-amber-800">

Book Appointment

</a>



<a href="designs.php"

class="border border-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-[#FFFDF9] hover:text-amber-800">

Explore Designs

</a>


</div>


</div>


</div>


</div>


</section>

    <!-- Statistics -->

    <section class="max-w-7xl mx-auto mt-10 px-6">

        <div class="grid md:grid-cols-3 gap-8 mt-12 px-6">


<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition">

<div class="flex justify-center mb-5">

<i data-lucide="palette" 
class="w-12 h-12 text-amber-700">
</i>

</div>

<h2 class="text-4xl font-bold text-amber-800">
<?php echo $total['total']; ?>+
</h2>

<p class="text-lg text-gray-700 mt-2">
Beautiful Henna Designs
</p>

</div>




<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition">

<div class="flex justify-center mb-5">

<i data-lucide="user-round-check"
class="w-12 h-12 text-amber-700">
</i>

</div>

<h2 class="text-4xl font-bold text-amber-800">
<?php echo $artist_total['total']; ?>+
</h2>

<p class="text-lg text-gray-700 mt-2">
Professional Artists
</p>

</div>




<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition">

<div class="flex justify-center mb-5">

<i data-lucide="calendar-check"
class="w-12 h-12 text-amber-700">
</i>

</div>

<h2 class="text-4xl font-bold text-amber-800">
Easy
</h2>

<p class="text-lg text-gray-700 mt-2">
Online Booking
</p>

</div>


</div>

    </section>

<!-- Services -->

<section class="max-w-7xl mx-auto mt-16 px-6">

<h2 class="text-4xl font-bold text-center text-amber-900 mb-10">
Our Services
</h2>


<div class="grid md:grid-cols-3 gap-8">


<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

<i data-lucide="sparkles" class="w-10 h-10 text-amber-700 mb-5"></i>

<h3 class="text-2xl font-bold text-amber-800 mb-3">
Custom Henna Designs
</h3>

<p class="text-gray-600">
Choose from our Bridal, Arabic, Floral, Modern and Stylish henna collections or request your own customized design.
</p>

</div>



<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

<i data-lucide="home" class="w-10 h-10 text-amber-700 mb-5"></i>

<h3 class="text-2xl font-bold text-amber-800 mb-3">
Home Service
</h3>

<p class="text-gray-600">
Enjoy professional henna services at your preferred location with skilled artists.
</p>

</div>



<div class="bg-[#FFFDF9] rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

<i data-lucide="calendar-check" class="w-10 h-10 text-amber-700 mb-5"></i>

<h3 class="text-2xl font-bold text-amber-800 mb-3">
Easy Booking
</h3>

<p class="text-gray-600">
Book your appointment online, select your favorite design and artist easily.
</p>

</div>


</div>

</section>

   <section class="max-w-6xl mx-auto mt-16 px-6">

<div class="bg-[#FFFDF9] rounded-3xl shadow-xl p-10">


<h2 class="text-4xl font-bold text-center text-amber-900 mb-10">
Why Choose Us?
</h2>


<div class="grid md:grid-cols-4 gap-6 text-center">


<div>
<i data-lucide="badge-check" class="mx-auto w-10 h-10"></i>
<p class="mt-3 text-gray-700 font-semibold">
Professional Artists
</p>
</div>


<div>
<i data-lucide="gem" class="mx-auto w-10 h-10"></i>
<p class="mt-3 text-gray-700 font-semibold">
Premium Designs
</p>
</div>


<div>
<i data-lucide="calendar-check" class="mx-auto w-10 h-10"></i>
<p class="mt-3 text-gray-700 font-semibold">
Easy Booking
</p>
</div>


<div>
<i data-lucide="smile" class="mx-auto w-10 h-10"></i>
<p class="mt-3 text-gray-700 font-semibold">
Happy Customer    
</p>
</div>


</div>

</div>

</section>

    <!-- Footer -->

    <footer class="mt-12 bg-[#4B2E1F] text-white text-center py-5">

        <p>

            © 2026 Henna Studio Management & Booking System

        </p>

    </footer>

    <script>
lucide.createIcons();
</script>

</body>

</html>
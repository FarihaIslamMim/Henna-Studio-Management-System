<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Booking Successful</title>

<script src="https://cdn.tailwindcss.com"></script>

<script src="https://unpkg.com/lucide@latest"></script>

</head>


<body class="bg-[#efe3d2] min-h-screen flex items-center justify-center">


<div class="max-w-xl w-full mx-6 bg-white rounded-3xl shadow-xl p-10 text-center border border-[#e4cdb0]">


<!-- Success Icon -->

<div class="flex justify-center mb-6">

<div class="bg-green-100 rounded-full p-5">

<i data-lucide="check"
class="w-14 h-14 text-green-700">
</i>

</div>

</div>



<h1 class="text-4xl font-bold text-[#6b3f1d] mb-5">

Booking Submitted Successfully

</h1>



<p class="text-gray-700 text-lg leading-8 mb-8">

Thank you for choosing <b>Henna Studio</b>.

<br>

Your appointment request has been received successfully.

<br>

Our team will review and confirm your booking soon.

</p>




<div class="flex flex-col sm:flex-row justify-center gap-4">


<div class="flex flex-col sm:flex-row justify-center gap-4">


<a href="customer_payment.php"
class="bg-green-600 hover:bg-green-700 text-white px-7 py-3 rounded-full font-semibold">

Pay Now

</a>


<a href="booking_history.php"
class="bg-[#8b5e34] hover:bg-[#6b3f1d] text-white px-7 py-3 rounded-full font-semibold">

View My Bookings

</a>


<a href="index.php"
class="border border-[#8b5e34] text-[#6b3f1d] px-7 py-3 rounded-full font-semibold">

Back to Home

</a>


</div>


</div>



</div>



<script>

lucide.createIcons();

</script>


</body>

</html>
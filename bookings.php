<?php

include 'db_connect.php';

if (isset($_POST['submit'])) {

    $customer_id = $_POST['customer_id'];
    $artist_id = $_POST['artist_id'];
    $design_id = $_POST['design_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];

    $sql = "INSERT INTO bookings
            (Customer_ID, Artist_ID, Design_ID, Booking_Date, Booking_Time)

            VALUES

            ('$customer_id', '$artist_id', '$design_id', '$booking_date', '$booking_time')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('Booking created successfully');</script>";

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Appointment</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50 min-h-screen">

    <nav class="bg-amber-800 shadow-lg">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex flex-wrap justify-center gap-6 text-white font-medium">

                <a href="index.html" class="hover:text-yellow-200">Home</a>

                <a href="customers.php" class="hover:text-yellow-200">Customers</a>

                <a href="artists.php" class="hover:text-yellow-200">Artists</a>

                <a href="designs.html" class="hover:text-yellow-200">Designs</a>

                <a href="bookings.php" class="hover:text-yellow-200">Bookings</a>

                <a href="view_bookings.php" class="hover:text-yellow-200">View Bookings</a>

                <a href="payments.php" class="hover:text-yellow-200">Payments</a>

                <a href="reviews.html" class="hover:text-yellow-200">Reviews</a>

            </div>

        </div>

    </nav>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

            Book an Appointment

        </h1>

        <hr class="mb-8">

        <form method="POST" class="space-y-5">

            <div>

                <label class="block text-lg font-medium mb-2">

                    Customer ID:

                </label>

                <input type="number"
                    name="customer_id"
                    placeholder="Enter customer ID"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Artist ID:

                </label>

                <input type="number"
                    name="artist_id"
                    placeholder="Enter artist ID"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Design ID:

                </label>

                <input type="number"
                    name="design_id"
                    placeholder="Enter design ID"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Booking Date:

                </label>

                <input type="date"
                    name="booking_date"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Booking Time:

                </label>

                <input type="time"
                    name="booking_time"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div class="flex gap-4">

                <button type="submit"
                    name="submit"
                    class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

                    Book Now

                </button>

                <button type="reset"
                    class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-700">

                    Clear

                </button>

            </div>

        </form>

        <div class="mt-8">

            <a href="index.html">

                <button class="bg-amber-800 text-white px-6 py-3 rounded-lg hover:bg-amber-950">

                    Back to Home

                </button>

            </a>

        </div>

    </div>

</body>

</html>
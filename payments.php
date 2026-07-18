<?php

include 'db_connect.php';

if (isset($_POST['submit'])) {

    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];

    $sql = "INSERT INTO payments
            (Booking_ID, Amount, Payment_Method, Payment_Date, Payment_Status)

            VALUES

            ('$booking_id', '$amount', '$payment_method', '$payment_date', '$payment_status')";

    if (mysqli_query($conn, $sql)) {

        echo "<script>alert('Payment added successfully');</script>";

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

    <title>Payments</title>

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

                <a href="payments.php" class="hover:text-yellow-200">Payments</a>

                <a href="reviews.html" class="hover:text-yellow-200">Reviews</a>

                <a href="view_payments.php" class="hover:text-yellow-200">View Payments</a>

            </div>

        </div>

    </nav>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

            Payment Form

        </h1>

        <hr class="mb-8">

        <form method="POST" class="space-y-5">

            <div>

                <label class="block text-lg font-medium mb-2">

                    Booking ID:

                </label>

                <input type="number"
                       name="booking_id"
                       required
                       class="w-full border border-gray-300 rounded-lg p-3">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Amount:

                </label>

                <input type="number"
                       step="0.01"
                       name="amount"
                       required
                       class="w-full border border-gray-300 rounded-lg p-3">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Payment Method:

                </label>

                <select name="payment_method"
                        class="w-full border border-gray-300 rounded-lg p-3">

                    <option value="Cash">Cash</option>
                    <option value="Bkash">Bkash</option>
                    <option value="Nagad">Nagad</option>

                </select>

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Payment Date:

                </label>

                <input type="date"
                       name="payment_date"
                       required
                       class="w-full border border-gray-300 rounded-lg p-3">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Payment Status:

                </label>

                <select name="payment_status"
                        class="w-full border border-gray-300 rounded-lg p-3">

                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>

                </select>

            </div>

            <div class="flex gap-4">

                <button type="submit"
                        name="submit"
                        class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

                    Save Payment

                </button>

                <button type="reset"
                        class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-700">

                    Clear

                </button>

            </div>

        </form>

    </div>

</body>

</html>
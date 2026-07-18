<?php

include 'db_connect.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $specialization = $_POST['specialization'];
    $experience_years = $_POST['experience_years'];

    $sql = "INSERT INTO artists (Name, Phone, Email, User_Password, Address, Specialization, Experience_Years)
            VALUES ('$name', '$phone', '$email', '$password', '$address', '$specialization', '$experience_years')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Artist registered successfully');</script>";
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

    <title>Artist Registration</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50 min-h-screen">

    <nav class="bg-amber-800 shadow-lg">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex flex-wrap justify-center gap-6 text-white font-medium">

                <a href="index.html" class="hover:text-yellow-200">Home</a>

                <a href="customers.php" class="hover:text-yellow-200">Customers</a>

                <a href="artists.php" class="hover:text-yellow-200">Artists</a>

                <a href="view_artists.php" class="hover:text-yellow-200">View Artists</a>

                <a href="designs.html" class="hover:text-yellow-200">Designs</a>

                <a href="bookings.php" class="hover:text-yellow-200">Bookings</a>

                <a href="payments.html" class="hover:text-yellow-200">Payments</a>

                <a href="reviews.html" class="hover:text-yellow-200">Reviews</a>

            </div>

        </div>

    </nav>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

            Artist Registration

        </h1>

        <hr class="mb-8">

        <form method="POST" class="space-y-5">

            <div>

                <label class="block text-lg font-medium mb-2">

                    Full Name:

                </label>

                <input type="text"
                    name="name"
                    placeholder="Enter your name"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Phone Number:

                </label>

                <input type="text"
                    name="phone"
                    placeholder="Enter phone number"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Email:

                </label>

                <input type="email"
                    name="email"
                    placeholder="Enter email"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Password:

                </label>

                <input type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Address:

                </label>

                <textarea
                    name="address"
                    rows="4"
                    placeholder="Enter address"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600"></textarea>

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Specialization:

                </label>

                <input type="text"
                    name="specialization"
                    placeholder="Arabic / Bridal / Modern"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div>

                <label class="block text-lg font-medium mb-2">

                    Experience (Years):

                </label>

                <input type="number"
                    name="experience_years"
                    placeholder="Enter experience"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-600">

            </div>

            <div class="flex gap-4">

                <button type="submit"
                    name="submit"
                    class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

                    Register

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
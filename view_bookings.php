<?php

include 'db_connect.php';

$sql = "SELECT * FROM bookings";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Booking List</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-7xl mx-auto mt-10">

    <h1 class="text-3xl font-bold text-amber-900 mb-6">

        Booking List

    </h1>

    <table class="w-full bg-white shadow-lg rounded-lg">

        <tr class="bg-amber-800 text-white">

            <th class="p-3">Booking ID</th>
            <th class="p-3">Customer ID</th>
            <th class="p-3">Artist ID</th>
            <th class="p-3">Design ID</th>
            <th class="p-3">Date</th>
            <th class="p-3">Time</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>

        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr class="border text-center">

            <td class="p-3"><?php echo $row['Booking_ID']; ?></td>

            <td class="p-3"><?php echo $row['Customer_ID']; ?></td>

            <td class="p-3"><?php echo $row['Artist_ID']; ?></td>

            <td class="p-3"><?php echo $row['Design_ID']; ?></td>

            <td class="p-3"><?php echo $row['Booking_Date']; ?></td>

            <td class="p-3"><?php echo $row['Booking_Time']; ?></td>

            <td class="p-3"><?php echo $row['Status']; ?></td>

            <td class="p-3">

                <a href="edit_booking.php?id=<?php echo $row['Booking_ID']; ?>" class="text-blue-500">

                    Edit

                </a>

                <a href="delete_booking.php?id=<?php echo $row['Booking_ID']; ?>" class="text-red-500 ml-3">

                    Delete

                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>
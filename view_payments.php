<?php

include 'db_connect.php';

$sql = "SELECT * FROM payments";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Payment List</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-7xl mx-auto mt-10">

    <h1 class="text-3xl font-bold text-amber-900 mb-6">

        Payment List

    </h1>

    <table class="w-full bg-white shadow-lg rounded-lg">

        <tr class="bg-amber-800 text-white">

            <th class="p-3">Payment ID</th>
            <th class="p-3">Booking ID</th>
            <th class="p-3">Amount</th>
            <th class="p-3">Method</th>
            <th class="p-3">Date</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>

        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr class="border text-center">

            <td class="p-3"><?php echo $row['Payment_ID']; ?></td>

            <td class="p-3"><?php echo $row['Booking_ID']; ?></td>

            <td class="p-3"><?php echo $row['Amount']; ?></td>

            <td class="p-3"><?php echo $row['Payment_Method']; ?></td>

            <td class="p-3"><?php echo $row['Payment_Date']; ?></td>

            <td class="p-3"><?php echo $row['Payment_Status']; ?></td>

            <td class="p-3">

                <a href="edit_payment.php?id=<?php echo $row['Payment_ID']; ?>"
                   class="text-blue-500">

                    Edit

                </a>

                <a href="delete_payment.php?id=<?php echo $row['Payment_ID']; ?>"
                   class="text-red-500 ml-3">

                    Delete

                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>

</html>
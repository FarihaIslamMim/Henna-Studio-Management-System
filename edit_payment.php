<?php

include 'db_connect.php';

$id = $_GET['id'];

$sql = "SELECT * FROM payments WHERE Payment_ID = $id";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];

    $update = "UPDATE payments SET
               Booking_ID = '$booking_id',
               Amount = '$amount',
               Payment_Method = '$payment_method',
               Payment_Date = '$payment_date',
               Payment_Status = '$payment_status'
               WHERE Payment_ID = $id";

    if (mysqli_query($conn, $update)) {

        header("Location: view_payments.php");

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Edit Payment</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50">

<div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">

    <h1 class="text-3xl font-bold text-amber-900 mb-6">

        Edit Payment

    </h1>

    <form method="POST" class="space-y-5">

        <div>

            <label class="block mb-2">Booking ID:</label>

            <input type="number"
                   name="booking_id"
                   value="<?php echo $row['Booking_ID']; ?>"
                   class="w-full border p-3 rounded">

        </div>

        <div>

            <label class="block mb-2">Amount:</label>

            <input type="number"
                   step="0.01"
                   name="amount"
                   value="<?php echo $row['Amount']; ?>"
                   class="w-full border p-3 rounded">

        </div>

        <div>

            <label class="block mb-2">Payment Method:</label>

            <select name="payment_method" class="w-full border p-3 rounded">

                <option value="Cash" <?php if ($row['Payment_Method'] == 'Cash') echo 'selected'; ?>>Cash</option>

                <option value="Bkash" <?php if ($row['Payment_Method'] == 'Bkash') echo 'selected'; ?>>Bkash</option>

                <option value="Nagad" <?php if ($row['Payment_Method'] == 'Nagad') echo 'selected'; ?>>Nagad</option>

            </select>

        </div>

        <div>

            <label class="block mb-2">Payment Date:</label>

            <input type="date"
                   name="payment_date"
                   value="<?php echo $row['Payment_Date']; ?>"
                   class="w-full border p-3 rounded">

        </div>

        <div>

            <label class="block mb-2">Payment Status:</label>

            <select name="payment_status" class="w-full border p-3 rounded">

                <option value="Paid" <?php if ($row['Payment_Status'] == 'Paid') echo 'selected'; ?>>Paid</option>

                <option value="Unpaid" <?php if ($row['Payment_Status'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>

            </select>

        </div>

        <button type="submit"
                name="update"
                class="bg-amber-700 text-white px-5 py-3 rounded">

            Update Payment

        </button>

    </form>

</div>

</body>

</html>
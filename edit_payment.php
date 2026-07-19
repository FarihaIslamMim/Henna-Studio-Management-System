<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}

include 'db_connect.php';
include 'validation.php';



if (!isset($_GET['id']) || !validateID($_GET['id'])) {

    header("Location: view_payments.php");
    exit();

}


$id = (int) $_GET['id'];



// Fetch payment data

$stmt = $conn->prepare(

    "SELECT * FROM payments WHERE Payment_ID=?"

);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();



if($result->num_rows == 0){

    echo "<script>

    alert('Payment not found');

    window.location='view_payments.php';

    </script>";

    exit();

}


$row = $result->fetch_assoc();





if(isset($_POST['update'])){


    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];



    // Check booking exists

    $booking_check = $conn->prepare(

        "SELECT Booking_ID FROM bookings WHERE Booking_ID=?"

    );


    $booking_check->bind_param(

        "i",

        $booking_id

    );


    $booking_check->execute();



    if($booking_check->get_result()->num_rows == 0){


        echo "<script>alert('Invalid booking ID');</script>";

    }


    elseif($amount <= 0){


        echo "<script>alert('Amount must be greater than 0');</script>";

    }


    elseif(!in_array($payment_method,["Cash","Bkash","Nagad"])){


        echo "<script>alert('Invalid payment method');</script>";

    }


    elseif(!in_array($payment_status,["Paid","Unpaid"])){


        echo "<script>alert('Invalid payment status');</script>";

    }


    elseif($payment_date > date('Y-m-d')){


        echo "<script>alert('Payment date cannot be in the future');</script>";

    }


    else{


        // Check duplicate payment for same booking

        $duplicate = $conn->prepare(

            "SELECT Payment_ID
             FROM payments
             WHERE Booking_ID=?
             AND Payment_ID!=?"

        );


        $duplicate->bind_param(

            "ii",

            $booking_id,
            $id

        );


        $duplicate->execute();



        if($duplicate->get_result()->num_rows > 0){


            echo "<script>

            alert('Another payment already exists for this booking');

            </script>";

        }


        else{


            $update = $conn->prepare(

                "UPDATE payments

                 SET Booking_ID=?,
                     Amount=?,
                     Payment_Method=?,
                     Payment_Date=?,
                     Payment_Status=?

                 WHERE Payment_ID=?"

            );



            $update->bind_param(

                "idsssi",

                $booking_id,
                $amount,
                $payment_method,
                $payment_date,
                $payment_status,
                $id

            );



            if($update->execute()){


                echo "<script>

                alert('Payment updated successfully');

                window.location='view_payments.php';

                </script>";

            }


            else{


                echo "<script>

                alert('Update failed');

                </script>";

            }


        }


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

<label class="block mb-2 font-medium">

Booking ID

</label>


<input

type="number"

name="booking_id"

value="<?php echo htmlspecialchars($row['Booking_ID']); ?>"

min="1"

required

class="w-full border p-3 rounded">


</div>




<div>

<label class="block mb-2 font-medium">

Amount

</label>


<input

type="number"

step="0.01"

min="1"

name="amount"

value="<?php echo htmlspecialchars($row['Amount']); ?>"

required

class="w-full border p-3 rounded">


</div>




<div>

<label class="block mb-2 font-medium">

Payment Method

</label>


<select name="payment_method" class="w-full border p-3 rounded">


<option value="Cash" <?php if($row['Payment_Method']=="Cash") echo "selected"; ?>>

Cash

</option>


<option value="Bkash" <?php if($row['Payment_Method']=="Bkash") echo "selected"; ?>>

Bkash

</option>


<option value="Nagad" <?php if($row['Payment_Method']=="Nagad") echo "selected"; ?>>

Nagad

</option>


</select>


</div>




<div>

<label class="block mb-2 font-medium">

Payment Date

</label>


<input

type="date"

name="payment_date"

value="<?php echo htmlspecialchars($row['Payment_Date']); ?>"

max="<?php echo date('Y-m-d'); ?>"

required

class="w-full border p-3 rounded">


</div>




<div>

<label class="block mb-2 font-medium">

Payment Status

</label>


<select name="payment_status" class="w-full border p-3 rounded">


<option value="Paid" <?php if($row['Payment_Status']=="Paid") echo "selected"; ?>>

Paid

</option>


<option value="Unpaid" <?php if($row['Payment_Status']=="Unpaid") echo "selected"; ?>>

Unpaid

</option>


</select>


</div>




<button

type="submit"

name="update"

class="bg-amber-700 text-white px-5 py-3 rounded hover:bg-amber-900">


Update Payment


</button>



</form>


</div>


</body>

</html>
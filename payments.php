<?php

include 'db_connect.php';

if(isset($_POST['submit'])){


    $booking_id = intval($_POST['booking_id']);

    $amount = floatval($_POST['amount']);

    $payment_method = trim($_POST['payment_method']);

    $payment_date = $_POST['payment_date'];

    $payment_status = trim($_POST['payment_status']);



    $allowed_methods = [
        "Cash",
        "Bkash",
        "Nagad"
    ];


    $allowed_status = [
        "Paid",
        "Unpaid"
    ];



    if($booking_id <= 0){


        echo "<script>alert('Invalid Booking ID');</script>";

    }


    elseif($amount <= 0){


        echo "<script>alert('Amount must be greater than 0');</script>";

    }


    elseif($amount > 99999999.99){


        echo "<script>alert('Amount is too large');</script>";

    }


    elseif(!in_array($payment_method,$allowed_methods)){


        echo "<script>alert('Invalid payment method');</script>";

    }


    elseif(!in_array($payment_status,$allowed_status)){


        echo "<script>alert('Invalid payment status');</script>";

    }


    elseif($payment_date > date('Y-m-d')){


        echo "<script>alert('Payment date cannot be in the future');</script>";

    }


    else{


        // Check booking exists

        $stmt = $conn->prepare(

            "SELECT Booking_ID, Status 
             FROM bookings 
             WHERE Booking_ID=?"

        );


        $stmt->bind_param(
            "i",
            $booking_id
        );


        $stmt->execute();


        $booking_result = $stmt->get_result();



        if($booking_result->num_rows == 0){


            echo "<script>alert('Booking does not exist');</script>";

        }


        else{


            $booking = $booking_result->fetch_assoc();



            if($booking['Status']=="CANCELLED"){


                echo "<script>alert('Cannot add payment for cancelled booking');</script>";

            }


            else{


                // Check duplicate payment


                $check = $conn->prepare(

                    "SELECT Payment_ID 
                     FROM payments 
                     WHERE Booking_ID=?"

                );


                $check->bind_param(
                    "i",
                    $booking_id
                );


                $check->execute();


                $existing = $check->get_result();



                if($existing->num_rows > 0){


                    echo "<script>alert('Payment already exists for this booking');</script>";

                }


                else{


                    $insert = $conn->prepare(

                        "INSERT INTO payments

                        (
                        Booking_ID,
                        Amount,
                        Payment_Method,
                        Payment_Date,
                        Payment_Status
                        )

                        VALUES(?,?,?,?,?)"

                    );


                    $insert->bind_param(

                        "idsss",

                        $booking_id,
                        $amount,
                        $payment_method,
                        $payment_date,
                        $payment_status

                    );



                    if($insert->execute()){


                        echo "<script>

                        alert('Payment added successfully');

                        window.location='view_payments.php';

                        </script>";

                    }


                    else{


                        echo "<script>

                        alert('Payment failed');

                        </script>";

                    }


                }


            }


        }


    }


}

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Payment Form</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-white text-2xl font-bold">
Henna Studio
</h1>

<a href="admin_login.php" class="text-white hover:text-yellow-200">
Admin
</a>

</div>

</nav>



<div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">


<h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

Payment Form

</h1>



<form method="POST" class="space-y-5">


<div>

<label class="font-medium">
Booking
</label>

<select
id="bookingSelect"
name="booking_id"
required
class="w-full border p-3 rounded-lg">

<option value="">Select Booking</option>

<?php

$bookings = mysqli_query($conn,

SELECT
bookings.Booking_ID,
customers.Name,
customers.Phone,
designs.Design_Code,
designs.Price

FROM bookings

JOIN customers
ON bookings.Customer_ID = customers.Customer_ID
JOIN designs
ON bookings.Design_ID = designs.Design_ID

WHERE bookings.Status='CONFIRMED'

AND bookings.Booking_ID NOT IN
(
SELECT Booking_ID FROM payments
)

ORDER BY bookings.Booking_ID ASC");

while($booking = mysqli_fetch_assoc($bookings)){

?>

<option
value="<?php echo $booking['Booking_ID']; ?>"
data-price="<?php echo $booking['Price']; ?>">

Booking #<?php echo $booking['Booking_ID']; ?>

-

<?php echo htmlspecialchars($booking['Name']); ?>

-

<?php echo htmlspecialchars($booking['Design_Code']); ?>

-

(<?php echo htmlspecialchars($booking['Phone']); ?>)

</option>

<?php } ?>

</select>

</div>



<div>

<label class="font-medium">
Amount
</label>

<input
type="number"
id="amount"
name="amount"
step="0.01"
min="1"
required
class="w-full border p-3 rounded-lg">

</div>



<div>

<label class="font-medium">
Payment Method
</label>


<select
name="payment_method"
class="w-full border p-3 rounded-lg">


<option value="Cash">Cash</option>

<option value="Bkash">Bkash</option>

<option value="Nagad">Nagad</option>


</select>


</div>



<div>

<label class="font-medium">
Payment Date
</label>


<input
type="date"
name="payment_date"
max="<?php echo date('Y-m-d'); ?>"
required
class="w-full border p-3 rounded-lg">


</div>



<div>

<label class="font-medium">
Payment Status
</label>


<select
name="payment_status"
class="w-full border p-3 rounded-lg">


<option value="Paid">
Paid
</option>


<option value="Unpaid">
Unpaid
</option>


</select>


</div>



<button
type="submit"
name="submit"
class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

Save Payment

</button>



</form>


</div>

<script>

const booking = document.getElementById("bookingSelect");

booking.addEventListener("change",function(){

let price =
this.options[this.selectedIndex].dataset.price;

document.getElementById("amount").value = price;

});

</script>

</body>

</html>
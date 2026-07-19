<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}

include 'db_connect.php';
include 'validation.php';


if (!isset($_GET['id']) || !validateID($_GET['id'])) {

    header("Location: view_bookings.php");
    exit();

}


$id = (int) $_GET['id'];



// Fetch booking

$stmt = $conn->prepare(

    "SELECT * FROM bookings WHERE Booking_ID=?"

);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();



if($result->num_rows == 0){

    echo "<script>
    alert('Booking not found');
    window.location='view_bookings.php';
    </script>";

    exit();

}


$row = $result->fetch_assoc();





if(isset($_POST['update'])){


    $customer_id = $_POST['customer_id'];
    $artist_id = $_POST['artist_id'];
    $design_id = $_POST['design_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];



    if($booking_date < date('Y-m-d')){


        echo "<script>alert('Booking date cannot be in the past');</script>";

    }


    else{


        // Check customer

        $customer = $conn->prepare(

            "SELECT Customer_ID FROM customers WHERE Customer_ID=?"

        );

        $customer->bind_param("i",$customer_id);

        $customer->execute();



        // Check artist

        $artist = $conn->prepare(

            "SELECT Artist_ID FROM artists WHERE Artist_ID=?"

        );

        $artist->bind_param("i",$artist_id);

        $artist->execute();



        // Check design

        $design = $conn->prepare(

            "SELECT Design_ID FROM designs WHERE Design_ID=?"

        );

        $design->bind_param("i",$design_id);

        $design->execute();



        if($customer->get_result()->num_rows == 0){


            echo "<script>alert('Invalid customer ID');</script>";

        }

        elseif($artist->get_result()->num_rows == 0){


            echo "<script>alert('Invalid artist ID');</script>";

        }

        elseif($design->get_result()->num_rows == 0){


            echo "<script>alert('Invalid design ID');</script>";

        }


        else{


            // Duplicate artist schedule check

            $check = $conn->prepare(

                "SELECT Booking_ID
                 FROM bookings
                 WHERE Artist_ID=?
                 AND Booking_Date=?
                 AND Booking_Time=?
                 AND Booking_ID!=?"

            );


            $check->bind_param(

                "issi",

                $artist_id,
                $booking_date,
                $booking_time,
                $id

            );


            $check->execute();


            if($check->get_result()->num_rows > 0){


                echo "<script>
                alert('Artist already has another booking at this time');
                </script>";

            }


            else{


                $update = $conn->prepare(

                    "UPDATE bookings
                     SET Customer_ID=?,
                         Artist_ID=?,
                         Design_ID=?,
                         Booking_Date=?,
                         Booking_Time=?
                     WHERE Booking_ID=?"

                );


                $update->bind_param(

                    "iiissi",

                    $customer_id,
                    $artist_id,
                    $design_id,
                    $booking_date,
                    $booking_time,
                    $id

                );



                if($update->execute()){


                    echo "<script>

                    alert('Booking updated successfully');

                    window.location='view_bookings.php';

                    </script>";

                }

                else{


                    echo "<script>alert('Update failed');</script>";

                }


            }

        }

    }


}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Booking</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">


<h1 class="text-3xl font-bold text-amber-900 mb-6">

Edit Booking

</h1>


<form method="POST" class="space-y-4">


<input type="number"
name="customer_id"
value="<?php echo htmlspecialchars($row['Customer_ID']); ?>"
required
class="w-full border p-3 rounded">



<input type="number"
name="artist_id"
value="<?php echo htmlspecialchars($row['Artist_ID']); ?>"
required
class="w-full border p-3 rounded">



<input type="number"
name="design_id"
value="<?php echo htmlspecialchars($row['Design_ID']); ?>"
required
class="w-full border p-3 rounded">



<input type="date"
name="booking_date"
value="<?php echo $row['Booking_Date']; ?>"
min="<?php echo date('Y-m-d'); ?>"
required
class="w-full border p-3 rounded">



<input type="time"
name="booking_time"
value="<?php echo $row['Booking_Time']; ?>"
required
class="w-full border p-3 rounded">



<button
type="submit"
name="update"
class="bg-amber-700 text-white px-5 py-3 rounded">

Update Booking

</button>


</form>


</div>


</body>

</html>
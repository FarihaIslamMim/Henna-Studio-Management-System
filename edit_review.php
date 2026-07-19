<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';
include 'validation.php';



// Validate ID

if (!isset($_GET['id']) || !validateID($_GET['id'])) {

    echo "<script>

    alert('Invalid review ID');

    window.location='view_reviews.php';

    </script>";

    exit();

}


$id = (int) $_GET['id'];




// Fetch review data

$stmt = $conn->prepare(

    "SELECT * FROM reviews WHERE Review_ID=?"

);


$stmt->bind_param(

    "i",

    $id

);


$stmt->execute();


$result = $stmt->get_result();



if($result->num_rows == 0){

    echo "<script>

    alert('Review not found');

    window.location='view_reviews.php';

    </script>";

    exit();

}



$row = $result->fetch_assoc();





if(isset($_POST['update'])){


    $customer_id = $_POST['customer_id'];

    $booking_id = $_POST['booking_id'];

    $rating = $_POST['rating'];

    $comment = trim($_POST['comment']);

    $review_date = $_POST['review_date'];




    // Check customer exists

    $customer_check = $conn->prepare(

        "SELECT Customer_ID FROM customers WHERE Customer_ID=?"

    );


    $customer_check->bind_param(

        "i",

        $customer_id

    );


    $customer_check->execute();



    if($customer_check->get_result()->num_rows == 0){


        echo "<script>alert('Invalid customer ID');</script>";

    }


    else{


        // Check booking belongs to customer

        $booking_check = $conn->prepare(

            "SELECT Booking_ID
             FROM bookings
             WHERE Booking_ID=?
             AND Customer_ID=?"

        );


        $booking_check->bind_param(

            "ii",

            $booking_id,
            $customer_id

        );


        $booking_check->execute();



        if($booking_check->get_result()->num_rows == 0){


            echo "<script>alert('Invalid booking or booking does not belong to customer');</script>";

        }


        elseif($rating < 1 || $rating > 5){


            echo "<script>alert('Rating must be between 1 and 5');</script>";

        }


        elseif(strlen($comment) > 500){


            echo "<script>alert('Comment cannot exceed 500 characters');</script>";

        }


        elseif($review_date > date('Y-m-d')){


            echo "<script>alert('Review date cannot be in the future');</script>";

        }


        else{


            $update = $conn->prepare(

                "UPDATE reviews

                 SET Customer_ID=?,
                     Booking_ID=?,
                     Rating=?,
                     Comment=?,
                     Review_Date=?

                 WHERE Review_ID=?"

            );



            $update->bind_param(

                "iiissi",

                $customer_id,
                $booking_id,
                $rating,
                $comment,
                $review_date,
                $id

            );



            if($update->execute()){


                echo "<script>

                alert('Review updated successfully');

                window.location='view_reviews.php';

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

<title>Edit Review</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl">


<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Edit Review

</h1>



<form method="POST" class="space-y-5">



<div>

<label>Customer ID</label>

<input

type="number"

name="customer_id"

value="<?php echo htmlspecialchars($row['Customer_ID']); ?>"

min="1"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Booking ID</label>

<input

type="number"

name="booking_id"

value="<?php echo htmlspecialchars($row['Booking_ID']); ?>"

min="1"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Rating</label>

<input

type="number"

name="rating"

min="1"

max="5"

value="<?php echo htmlspecialchars($row['Rating']); ?>"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Comment</label>

<textarea

name="comment"

maxlength="500"

class="w-full border p-3 rounded"><?php echo htmlspecialchars($row['Comment']); ?></textarea>

</div>




<div>

<label>Review Date</label>

<input

type="date"

name="review_date"

value="<?php echo htmlspecialchars($row['Review_Date']); ?>"

max="<?php echo date('Y-m-d'); ?>"

required

class="w-full border p-3 rounded">

</div>




<button

type="submit"

name="update"

class="bg-amber-700 text-white px-6 py-3 rounded">

Update Review

</button>



</form>


</div>


</body>

</html>
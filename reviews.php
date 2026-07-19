<?php

include 'db_connect.php';


if(isset($_POST['submit'])){


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

    $customer_result = $customer_check->get_result();



    if($customer_result->num_rows == 0){


        echo "<script>alert('Invalid Customer ID');</script>";

    }


    else{


        // Check booking exists and belongs to customer

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


        $booking_result = $booking_check->get_result();



        if($booking_result->num_rows == 0){


            echo "<script>alert('Invalid booking or booking does not belong to customer');</script>";

        }


        elseif($rating < 1 || $rating > 5){


            echo "<script>alert('Rating must be between 1 and 5');</script>";

        }


        elseif(strlen($comment) > 500){


            echo "<script>alert('Comment is too long');</script>";

        }


        elseif($review_date > date('Y-m-d')){


            echo "<script>alert('Review date cannot be in the future');</script>";

        }


        else{


            // Duplicate review check

            $check = $conn->prepare(

                "SELECT Review_ID 
                 FROM reviews 
                 WHERE Booking_ID=?"

            );


            $check->bind_param(

                "i",

                $booking_id

            );


            $check->execute();


            $existing = $check->get_result();



            if($existing->num_rows > 0){


                echo "<script>alert('Review already submitted for this booking');</script>";

            }


            else{


                $stmt = $conn->prepare(

                    "INSERT INTO reviews

                    (
                    Customer_ID,
                    Booking_ID,
                    Rating,
                    Comment,
                    Review_Date
                    )

                    VALUES(?,?,?,?,?)"

                );



                $stmt->bind_param(

                    "iiiss",

                    $customer_id,
                    $booking_id,
                    $rating,
                    $comment,
                    $review_date

                );



                if($stmt->execute()){


                    echo "<script>

                    alert('Review submitted successfully');

                    window.location='view_reviews.php';

                    </script>";

                }


                else{


                    echo "<script>alert('Review submission failed');</script>";

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

<title>Customer Review</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Henna Studio

</h1>


<a href="admin_login.php"
class="text-white">

Admin

</a>


</div>

</nav>



<div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">


<h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

Customer Review

</h1>



<form method="POST" class="space-y-5">



<div>

<label class="font-medium">

Customer ID

</label>


<input

type="number"

name="customer_id"

min="1"

required

class="w-full border p-3 rounded-lg">


</div>




<div>

<label class="font-medium">

Booking ID

</label>


<input

type="number"

name="booking_id"

min="1"

required

class="w-full border p-3 rounded-lg">


</div>




<div>

<label class="font-medium">

Rating (1-5)

</label>


<input

type="number"

name="rating"

min="1"

max="5"

required

class="w-full border p-3 rounded-lg">


</div>




<div>

<label class="font-medium">

Comment

</label>


<textarea

name="comment"

maxlength="500"

rows="4"

class="w-full border p-3 rounded-lg"></textarea>


</div>




<div>

<label class="font-medium">

Review Date

</label>


<input

type="date"

name="review_date"

max="<?php echo date('Y-m-d'); ?>"

required

class="w-full border p-3 rounded-lg">


</div>




<button

type="submit"

name="submit"

class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">


Submit Review


</button>



</form>


</div>



</body>

</html>
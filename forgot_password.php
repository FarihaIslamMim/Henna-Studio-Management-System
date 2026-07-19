<?php

include 'db_connect.php';

$message = "";


if(isset($_POST['submit'])){


    $email = trim($_POST['email']);


    $stmt = $conn->prepare(
        "SELECT Admin_ID FROM admin WHERE Email=?"
    );


    $stmt->bind_param(
        "s",
        $email
    );


    $stmt->execute();


    $result = $stmt->get_result();



    if($result->num_rows == 1){


        $token = bin2hex(random_bytes(32));


        $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));



        $update = $conn->prepare(

            "UPDATE admin 
             SET reset_token=?, token_expiry=?
             WHERE Email=?"

        );



        $update->bind_param(

            "sss",

            $token,
            $expiry,
            $email

        );



        if($update->execute()){


            $reset_link = 
            "http://localhost/Henna_Studio_Management%20%26%20Booking_System/reset_password.php?token=".$token;



            $message =

            "Reset link generated:<br><br>
            <a href='$reset_link'>$reset_link</a>";


        }

        else{


            $message = "Failed to generate reset link";


        }



    }

    else{


        $message = "Email not found";


    }


}


?>



<!DOCTYPE html>

<html>

<head>

<title>Forgot Password</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">



<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded-xl shadow">


<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Forgot Password

</h1>



<form method="POST" class="space-y-5">



<input

type="email"

name="email"

placeholder="Enter admin email"

required

class="w-full border p-3 rounded">



<button

name="submit"

class="w-full bg-amber-700 text-white p-3 rounded">

Send Reset Link

</button>



</form>



<p class="mt-5 text-center text-red-600">

<?php echo $message; ?>

</p>



</div>



</body>

</html>
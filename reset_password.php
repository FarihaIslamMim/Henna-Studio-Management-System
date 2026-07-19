<?php

include 'db_connect.php';

$message = "";


if(isset($_GET['token'])){

    $token = $_GET['token'];


    $stmt = $conn->prepare(
        "SELECT Admin_ID FROM admin 
 WHERE reset_token=?"
    );


    $stmt->bind_param(
        "s",
        $token
    );


    $stmt->execute();


    $result = $stmt->get_result();



    if($result->num_rows == 0){

        die("Invalid or expired reset link.");

    }


}



if(isset($_POST['reset'])){


    $token = $_POST['token'];

    $password = trim($_POST['password']);



    if(

        strlen($password) < 8 ||
        !preg_match("/[A-Z]/",$password) ||
        !preg_match("/[a-z]/",$password) ||
        !preg_match("/[0-9]/",$password) ||
        !preg_match("/[\W]/",$password)

    ){

        $message = "Password must contain minimum 8 characters, uppercase, lowercase, number and special character.";

    }


    else{


        $hashed = password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        $update = $conn->prepare(

            "UPDATE admin
             SET Password=?,
             reset_token=NULL,
             token_expiry=NULL
             WHERE reset_token=?"

        );


        $update->bind_param(

            "ss",

            $hashed,
            $token

        );


        if($update->execute()){


            echo "<script>

            alert('Password reset successful');

            window.location='admin_login.php';

            </script>";


        }


    }


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Reset Password</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<div class="max-w-md mx-auto mt-20 bg-white p-8 rounded-xl shadow">


<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Reset Password

</h1>


<form method="POST" class="space-y-5">


<input type="hidden" name="token"
value="<?php echo htmlspecialchars($_GET['token']); ?>">



<input

type="password"

name="password"

placeholder="Enter new password"

required

class="w-full border p-3 rounded">


<button

name="reset"

class="w-full bg-amber-700 text-white p-3 rounded">

Reset Password

</button>


</form>


<p class="text-red-600 mt-4 text-center">

<?php echo $message; ?>

</p>


</div>


</body>

</html>
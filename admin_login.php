<?php

session_start();

include 'db_connect.php';


if(isset($_POST['login'])){


    $username = trim($_POST['username']);
    $password = trim($_POST['password']);



    $stmt = $conn->prepare(

    "SELECT Admin_ID, Username, Password
     FROM admin
     WHERE BINARY Username=?"

);

    $stmt->bind_param(

        "s",

        $username

    );


    $stmt->execute();


    $result = $stmt->get_result();



   if($result->num_rows == 1){

    $admin = $result->fetch_assoc();

    if($password == $admin['Password']){

        $_SESSION['admin'] = $admin['Admin_ID'];
        $_SESSION['admin_name'] = $admin['Username'];

        echo "<script>
        alert('Login successful');
        window.location='admin_dashboard.php';
        </script>";
        exit();

    }
    else{

        echo "<script>
        alert('Invalid password');
        </script>";

    }

}
else{

    echo "<script>
    alert('Admin account not found');
    </script>";

}



}


?>



<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-50 min-h-screen">

<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-white text-2xl font-bold">
Henna Studio Admin Panel
</h1>

<a href="index.php"
class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-gray-100">

← Back to Home

</a>

</div>

</nav>


<div class="max-w-md mx-auto mt-16 bg-white shadow-xl rounded-xl p-8">



<h2 class="text-3xl font-bold text-center text-amber-900 mb-6">

Admin Login

</h2>




<form method="POST" class="space-y-5" autocomplete="off">





<div>

<label class="font-medium">

Username

</label>


<input
type="text"
name="username"
autocomplete="off"
required
class="w-full border p-3 rounded-lg"
placeholder="Enter admin username">


</div>






<div>

<label class="font-medium">

Password

</label>


<input
type="password"
name="password"
autocomplete="new-password"
required
class="w-full border p-3 rounded-lg"
placeholder="Enter password">


</div>






<button

type="submit"

name="login"

class="w-full bg-amber-700 text-white py-3 rounded-lg hover:bg-amber-900">


Login


</button>

<a href="forgot_password.php"
class="text-blue-600 block text-center">
Forgot Password?
</a>


</form>




</div>



</body>

</html>
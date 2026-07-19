<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';


if(isset($_POST['submit'])){


    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);



    // Username validation

    if(strlen($username) < 3){


        echo "<script>
        alert('Username must contain minimum 3 characters');
        </script>";

    }



    // Email validation

    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){


        echo "<script>
        alert('Enter a valid email address');
        </script>";

    }



    // Password match

    elseif($password != $confirm_password){


        echo "<script>
        alert('Passwords do not match');
        </script>";

    }



    // Strong password

    elseif(

        strlen($password) < 8 ||
        !preg_match("/[A-Z]/",$password) ||
        !preg_match("/[a-z]/",$password) ||
        !preg_match("/[0-9]/",$password) ||
        !preg_match("/[\W]/",$password)

    ){


        echo "<script>

        alert('Password must contain minimum 8 characters, one uppercase letter, one lowercase letter, one number and one special character.');

        </script>";

    }



    else{


        // Check duplicate username/email

        $check = $conn->prepare(

            "SELECT Admin_ID FROM admin 
             WHERE Username=? OR Email=?"

        );


        $check->bind_param(

            "ss",

            $username,
            $email

        );


        $check->execute();


        $result = $check->get_result();



        if($result->num_rows > 0){


            echo "<script>
            alert('Username or Email already exists');
            </script>";

        }



        else{


            $hashed_password = password_hash(

                $password,

                PASSWORD_DEFAULT

            );



            $stmt = $conn->prepare(

                "INSERT INTO admin
                (Username, Email, Password)
                VALUES (?,?,?)"

            );



            $stmt->bind_param(

                "sss",

                $username,
                $email,
                $hashed_password

            );



            if($stmt->execute()){


                echo "<script>

                alert('Admin created successfully');

                window.location='admin_login.php';

                </script>";

            }


            else{


                echo "<script>

                alert('Failed to create admin');

                </script>";

            }



        }


    }



}


?>



<!DOCTYPE html>

<html>

<head>

<title>Add Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">



<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl">



<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Create Admin Account

</h1>




<form method="POST" class="space-y-5">



<div>

<label class="font-medium">
Username
</label>


<input

type="text"

name="username"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">
Email
</label>


<input

type="email"

name="email"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">
Password
</label>


<input

type="password"

name="password"

required

class="w-full border p-3 rounded-lg"

placeholder="Example: Admin@1234">

</div>




<div>

<label class="font-medium">
Confirm Password
</label>


<input

type="password"

name="confirm_password"

required

class="w-full border p-3 rounded-lg">

</div>




<p class="text-sm text-gray-600">

Password must have:

<br>
• Minimum 8 characters

<br>
• One uppercase letter

<br>
• One lowercase letter

<br>
• One number

<br>
• One special character

</p>




<button

type="submit"

name="submit"

class="w-full bg-amber-700 text-white py-3 rounded-lg">

Create Admin

</button>



</form>



</div>



</body>

</html>
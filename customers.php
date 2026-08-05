<?php

include 'db_connect.php';
include 'validation.php';


if(isset($_POST['submit'])){


    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $registration_date = $_POST['registration_date'];

if(!preg_match('/^(13|14|15|16|17|18|19)[0-9]{8}$/', $phone)){

    echo "<script>
    alert('Enter a valid Bangladeshi mobile number.');
    </script>";

    exit();

}
$phone = "+880".$phone;

    if(!validateName($name)){


        echo "<script>alert('Invalid name. Use only letters and spaces (minimum 3 characters).');</script>";

    }


    elseif(!validatePhone($phone)){


        echo "<script>alert('Phone number must be exactly 11 digits.');</script>";

    }


    elseif(!validateEmail($email)){


        echo "<script>alert('Enter a valid email address.');</script>";

    }


    elseif(!validatePassword($password)){


        echo "<script>alert('Password must contain minimum 8 characters, one uppercase letter, one lowercase letter, one number and one special character.');</script>";

    }


    elseif($registration_date > date('Y-m-d')){


        echo "<script>alert('Registration date cannot be in the future.');</script>";

    }


    elseif(strlen($address) < 5){


        echo "<script>alert('Address is too short.');</script>";

    }


    else{


        $check = $conn->prepare(

            "SELECT Customer_ID 
             FROM customers 
             WHERE Email=? OR Phone=?"

        );


        $check->bind_param(

            "ss",

            $email,
            $phone

        );


        $check->execute();


        $existing = $check->get_result();



        if($existing->num_rows > 0){


            echo "<script>alert('Email or phone number already exists.');</script>";

        }


        else{


            $hashed_password = password_hash($password, PASSWORD_DEFAULT);



            $stmt = $conn->prepare(

                "INSERT INTO customers
                (Name, Phone, Email, Password, Address, Registration_Date)

                VALUES(?,?,?,?,?,?)"

            );



            $stmt->bind_param(

                "ssssss",

                $name,
                $phone,
                $email,
                $hashed_password,
                $address,
                $registration_date

            );



            if($stmt->execute()){


                echo "<script>

                alert('Customer registered successfully');

                window.location='view_customers.php';

                </script>";

            }


            else{


                echo "<script>

                alert('Registration failed');

                </script>";

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

<title>Customer Registration</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Henna Studio

</h1>


<a href="admin_login.php"

class="text-white hover:text-yellow-200">

Admin Login

</a>


</div>

</nav>




<div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">


<h1 class="text-4xl font-bold text-center text-amber-900 mb-6">

Customer Registration

</h1>



<form method="POST" class="space-y-5" autocomplete="off">



<div>

<label class="font-medium">

Full Name

</label>


<input

type="text"

name="name"

pattern="[A-Za-z ]{3,}"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Phone Number

</label>


<input

type="text"

name="phone"

pattern="[0-9]{11}"

maxlength="11"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Email

</label>


<input type="email" name="email" autocomplete="off"

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Password

</label>


<input

type="password"

name="password"

autocomplete="new-password"

minlength="8"

required

class="w-full border p-3 rounded-lg">


<p class="text-sm text-gray-600 mt-2">

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


</div>



<div>

<label class="font-medium">

Address

</label>


<textarea

name="address"

maxlength="255"

required

class="w-full border p-3 rounded-lg"></textarea>

</div>




<div>

<label class="font-medium">

Registration Date

</label>


<input

type="date"

name="registration_date"

max="<?php echo date('Y-m-d'); ?>"

required

class="w-full border p-3 rounded-lg">

</div>




<div class="flex gap-4">


<button

type="submit"

name="submit"

class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">

Register

</button>



<button

type="reset"

class="bg-gray-500 text-white px-6 py-3 rounded-lg">

Clear

</button>


</div>


<form>


</div>


</body>

</html>
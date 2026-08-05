<?php

include 'db_connect.php';
include 'validation.php';


if(isset($_POST['submit'])){


    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $specialization = trim($_POST['specialization']);
    $experience_years = $_POST['experience_years'];
    $joining_date = $_POST['joining_date'];
    $status = $_POST['status'];
    if(!preg_match('/^(13|14|15|16|17|18|19)[0-9]{8}$/', $phone)){

    echo "<script>
    alert('Enter a valid Bangladeshi mobile number.');
    </script>";

    exit();

}

$phone = "+880".$phone;

    if(!validateName($name)){

        echo "<script>alert('Invalid name. Use only letters and minimum 3 characters.');</script>";

    }

    elseif(!validatePhone($phone)){

        echo "<script>alert('Phone number must be exactly 11 digits.');</script>";

    }

    elseif(!validateEmail($email)){

        echo "<script>alert('Enter a valid email address.');</script>";

    }

    elseif(!validatePassword($password)){

        echo "<script>alert('Password must contain minimum 6 characters.');</script>";

    }

    elseif(!validateExperience($experience_years)){

        echo "<script>alert('Experience cannot be negative.');</script>";

    }

    elseif($joining_date > date('Y-m-d')){

        echo "<script>alert('Joining date cannot be in the future.');</script>";

    }

    elseif(strlen($address) < 5){

        echo "<script>alert('Address is too short.');</script>";

    }

    else{


        $check = $conn->prepare(
            "SELECT Artist_ID FROM artists WHERE Email=? OR Phone=?"
        );


        $check->bind_param(
            "ss",
            $email,
            $phone
        );


        $check->execute();


        $result = $check->get_result();



        if($result->num_rows > 0){


            echo "<script>alert('Email or phone number already exists.');</script>";

        }

        else{


            $hashed_password = password_hash($password, PASSWORD_DEFAULT);



            $stmt = $conn->prepare(

                "INSERT INTO artists
                (
                Name,
                Phone,
                Email,
                User_Password,
                Address,
                Specialization,
                Experience_Years,
                Joining_Date,
                Status
                )

                VALUES(?,?,?,?,?,?,?,?,?)"

            );



            $stmt->bind_param(

                "ssssssiss",

                $name,
                $phone,
                $email,
                $hashed_password,
                $address,
                $specialization,
                $experience_years,
                $joining_date,
                $status

            );



            if($stmt->execute()){


                echo "<script>

                alert('Artist registered successfully');

                window.location='view_artists.php';

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

<title>Artist Registration</title>

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

Artist Registration

</h1>



<form method="POST" class="space-y-5">



<div>

<label class="font-medium">

Full Name

</label>


<input

type="text"

name="name"

pattern="[A-Za-z ]{3,}"

title="Only letters and spaces allowed"

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

inputmode="numeric"

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

minlength="6"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Address

</label>


<textarea

name="address"

rows="3"

minlength="5"

required

class="w-full border p-3 rounded-lg"></textarea>

</div>




<div>

<label class="font-medium">

Specialization

</label>


<select

name="specialization"

class="w-full border p-3 rounded-lg">


<option value="Bridal">Bridal</option>

<option value="Arabic">Arabic</option>

<option value="Modern">Modern</option>

<option value="Traditional">Traditional</option>


</select>

</div>




<div>

<label class="font-medium">

Experience Years

</label>


<input

type="number"

name="experience_years"

min="0"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Joining Date

</label>


<input

type="date"

name="joining_date"

max="<?php echo date('Y-m-d'); ?>"

required

class="w-full border p-3 rounded-lg">

</div>




<div>

<label class="font-medium">

Status

</label>


<select

name="status"

class="w-full border p-3 rounded-lg">


<option value="Active">Active</option>

<option value="Inactive">Inactive</option>


</select>

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



</form>


</div>


</body>

</html>
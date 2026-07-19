<?php

include 'db_connect.php';
include 'validation.php';



if(!isset($_GET['id']) || !validateID($_GET['id'])){

    header("Location: view_customers.php");
    exit();

}


$id = $_GET['id'];




// Fetch customer data

$stmt = $conn->prepare(

    "SELECT * FROM customers WHERE Customer_ID=?"

);

$stmt->bind_param("i",$id);

$stmt->execute();

$result = $stmt->get_result();



if($result->num_rows == 0){

    echo "<script>alert('Customer not found'); window.location='view_customers.php';</script>";
    exit();

}


$row = $result->fetch_assoc();






if(isset($_POST['update'])){


    $name = trim($_POST['name']);

    $phone = trim($_POST['phone']);

    $email = trim($_POST['email']);

    $address = trim($_POST['address']);




    if(!validateName($name)){


        echo "<script>alert('Invalid name. Use only letters and minimum 3 characters');</script>";


    }


    elseif(!validatePhone($phone)){


        echo "<script>alert('Phone number must be exactly 11 digits');</script>";


    }


    elseif(!validateEmail($email)){


        echo "<script>alert('Enter a valid email address');</script>";


    }


    else{



        // Check duplicate email or phone excluding current customer


        $check = $conn->prepare(

            "SELECT Customer_ID FROM customers
             WHERE (Email=? OR Phone=?)
             AND Customer_ID != ?"

        );



        $check->bind_param(

            "ssi",

            $email,
            $phone,
            $id

        );



        $check->execute();


        $duplicate = $check->get_result();




        if($duplicate->num_rows > 0){


            echo "<script>alert('Email or phone already belongs to another customer');</script>";


        }


        else{



            $update = $conn->prepare(

                "UPDATE customers

                SET Name=?,
                    Phone=?,
                    Email=?,
                    Address=?

                WHERE Customer_ID=?"

            );



            $update->bind_param(

                "ssssi",

                $name,
                $phone,
                $email,
                $address,
                $id

            );




            if($update->execute()){


                echo "<script>

                alert('Customer updated successfully');

                window.location='view_customers.php';

                </script>";


            }


            else{


                echo "<script>alert('Update failed');</script>";


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


<title>Edit Customer</title>


<script src="https://cdn.tailwindcss.com"></script>


</head>



<body class="bg-orange-50 min-h-screen">





<nav class="bg-amber-800 shadow-lg">


<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Customer Management

</h1>



<a href="view_customers.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Back

</a>



</div>

</nav>







<div class="max-w-2xl mx-auto mt-10 bg-white shadow-xl rounded-2xl p-8">



<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Edit Customer

</h1>





<form method="POST" class="space-y-5">





<div>

<label class="font-medium">

Name

</label>


<input

type="text"

name="name"

value="<?php echo htmlspecialchars($row['Name']); ?>"

required

class="w-full border p-3 rounded-lg">


</div>







<div>

<label class="font-medium">

Phone

</label>


<input

type="text"

name="phone"

value="<?php echo htmlspecialchars($row['Phone']); ?>"

pattern="[0-9]{11}"

maxlength="11"

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

value="<?php echo htmlspecialchars($row['Email']); ?>"

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

class="w-full border p-3 rounded-lg"><?php echo htmlspecialchars($row['Address']); ?></textarea>



</div>







<button

type="submit"

name="update"

class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-900">


Update Customer


</button>





</form>



</div>





</body>

</html>
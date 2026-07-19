<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';



if(isset($_POST['submit'])){


    $name = trim($_POST['design_name']);
    $category = trim($_POST['category']);
    $price = $_POST['price'];
    $availability = $_POST['availability'];
    $description = trim($_POST['description']);



    if(strlen($name) < 3){

        echo "<script>alert('Design name must contain minimum 3 characters');</script>";

    }

    elseif($price <= 0){

        echo "<script>alert('Price must be greater than 0');</script>";

    }

    elseif(!in_array($availability, ["Available","Unavailable"])){

        echo "<script>alert('Invalid availability status');</script>";

    }

    elseif(strlen($description) < 5){

        echo "<script>alert('Description is too short');</script>";

    }

    else{


        $check = $conn->prepare(

            "SELECT Design_ID 
             FROM designs
             WHERE Design_Name=?"

        );


        $check->bind_param(

            "s",

            $name

        );


        $check->execute();


        $existing = $check->get_result();



        if($existing->num_rows > 0){


            echo "<script>alert('Design already exists');</script>";

        }

        else{


            $stmt = $conn->prepare(

                "INSERT INTO designs

                (
                Design_Name,
                Category,
                Price,
                Availability,
                Description
                )

                VALUES(?,?,?,?,?)"

            );


            $stmt->bind_param(

                "ssdss",

                $name,
                $category,
                $price,
                $availability,
                $description

            );



            if($stmt->execute()){


                echo "<script>

                alert('Design added successfully');

                window.location='view_designs.php';

                </script>";

            }

            else{


                echo "<script>

                alert('Failed to add design');

                </script>";

            }


        }


    }


}


?>


<!DOCTYPE html>

<html>

<head>

<title>Add Design</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">


<h1 class="text-white text-2xl font-bold">

Henna Studio

</h1>


<a href="view_designs.php"

class="bg-white text-amber-800 px-4 py-2 rounded-lg">

Back

</a>


</div>

</nav>




<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl">


<h1 class="text-3xl font-bold text-amber-900 mb-6 text-center">

Add New Design

</h1>



<form method="POST" class="space-y-5">



<div>

<label>Design Name</label>

<input

type="text"

name="design_name"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Category</label>

<select

name="category"

class="w-full border p-3 rounded">


<option value="Bridal">Bridal</option>

<option value="Arabic">Arabic</option>

<option value="Modern">Modern</option>

<option value="Traditional">Traditional</option>


</select>

</div>




<div>

<label>Price</label>

<input

type="number"

name="price"

min="1"

required

class="w-full border p-3 rounded">

</div>





<div>

<label>Availability</label>


<select

name="availability"

class="w-full border p-3 rounded">


<option value="Available">

Available

</option>


<option value="Unavailable">

Unavailable

</option>


</select>


</div>





<div>

<label>Description</label>


<textarea

name="description"

required

class="w-full border p-3 rounded"></textarea>


</div>




<button

type="submit"

name="submit"

class="bg-amber-700 text-white px-6 py-3 rounded">


Add Design


</button>



</form>


</div>


</body>

</html>
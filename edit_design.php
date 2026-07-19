<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';
include 'validation.php';



if(!isset($_GET['id']) || !validateID($_GET['id'])){

    header("Location: view_designs.php");
    exit();

}



$id = $_GET['id'];



$stmt = $conn->prepare(

    "SELECT * FROM designs WHERE Design_ID=?"

);


$stmt->bind_param(

    "i",

    $id

);


$stmt->execute();


$result = $stmt->get_result();



if($result->num_rows == 0){

    echo "<script>

    alert('Design not found');

    window.location='view_designs.php';

    </script>";

    exit();

}



$row = $result->fetch_assoc();




if(isset($_POST['update'])){


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


    elseif(!in_array($availability,["Available","Unavailable"])){

        echo "<script>alert('Invalid availability');</script>";

    }


    elseif(strlen($description) < 5){

        echo "<script>alert('Description is too short');</script>";

    }


    else{


        $check = $conn->prepare(

            "SELECT Design_ID 
             FROM designs
             WHERE Design_Name=?
             AND Design_ID != ?"

        );


        $check->bind_param(

            "si",

            $name,
            $id

        );


        $check->execute();


        $duplicate = $check->get_result();



        if($duplicate->num_rows > 0){


            echo "<script>alert('Design name already exists');</script>";


        }

        else{


            $update = $conn->prepare(

                "UPDATE designs

                SET Design_Name=?,
                    Category=?,
                    Price=?,
                    Availability=?,
                    Description=?

                WHERE Design_ID=?"

            );



            $update->bind_param(

                "ssdssi",

                $name,
                $category,
                $price,
                $availability,
                $description,
                $id

            );



            if($update->execute()){


                echo "<script>

                alert('Design updated successfully');

                window.location='view_designs.php';

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

<html>

<head>

<title>Edit Design</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50">


<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl">


<h1 class="text-3xl font-bold text-center text-amber-900 mb-6">

Edit Design

</h1>




<form method="POST" class="space-y-5">



<div>

<label>Design Name</label>

<input

type="text"

name="design_name"

value="<?php echo htmlspecialchars($row['Design_Name']); ?>"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Category</label>


<select name="category"

class="w-full border p-3 rounded">


<option value="Bridal" <?php if($row['Category']=="Bridal") echo "selected"; ?>>

Bridal

</option>


<option value="Arabic" <?php if($row['Category']=="Arabic") echo "selected"; ?>>

Arabic

</option>


<option value="Modern" <?php if($row['Category']=="Modern") echo "selected"; ?>>

Modern

</option>


<option value="Traditional" <?php if($row['Category']=="Traditional") echo "selected"; ?>>

Traditional

</option>


</select>


</div>




<div>

<label>Price</label>

<input

type="number"

name="price"

min="1"

value="<?php echo htmlspecialchars($row['Price']); ?>"

required

class="w-full border p-3 rounded">

</div>




<div>

<label>Availability</label>


<select name="availability"

class="w-full border p-3 rounded">


<option value="Available"

<?php if($row['Availability']=="Available") echo "selected"; ?>>

Available

</option>



<option value="Unavailable"

<?php if($row['Availability']=="Unavailable") echo "selected"; ?>>

Unavailable

</option>


</select>


</div>




<div>

<label>Description</label>


<textarea

name="description"

required

class="w-full border p-3 rounded"><?php echo htmlspecialchars($row['Description']); ?></textarea>


</div>




<button

type="submit"

name="update"

class="bg-amber-700 text-white px-6 py-3 rounded">

Update Design

</button>


</form>


</div>


</body>

</html>
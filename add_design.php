<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: admin_login.php");
    exit();

}


include 'db_connect.php';



if(isset($_POST['submit'])){

    $category = trim($_POST['category']);
    switch($category){

    case "Bridal":
        $prefix = "BR";
        break;

    case "Arabic":
        $prefix = "AR";
        break;

    case "Front Hand":
        $prefix = "FH";
        break;

    case "Back Hand":
        $prefix = "BH";
        break;

    case "Floral":
    $prefix = "FL";
    break;

    case "Semi Bridal":
        $prefix = "SB";
        break;

    case "Royal":
        $prefix = "RO";
        break;

    case "Simple":
        $prefix = "SP";
        break;

    case "Gorgeous":
        $prefix = "GO";
        break;

    case "Modern":
        $prefix = "MD";
        break;

    case "Stylish":
        $prefix = "ST";
        break;

    default:
        $prefix = "DS";
}
$sql = "SELECT Design_Code
        FROM designs
        WHERE Design_Code LIKE '$prefix%'
        ORDER BY Design_Code ASC
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $number = intval(substr($row['Design_Code'], 2)) + 1;

}else{

    $number = 1;

}

$design_code = $prefix . str_pad($number, 3, "0", STR_PAD_LEFT);
    $price = $_POST['price'];
    $availability = $_POST['availability'];
   $originalName = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$size = $_FILES['image']['size'];

$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

$image = $design_code . "." . $extension;
$allowed = ["jpg", "jpeg", "png"];

if(!in_array($extension, $allowed)){

    echo "<script>alert('Only JPG, JPEG and PNG images are allowed.');</script>";
    exit();

}

if($size > 2 * 1024 * 1024){

    echo "<script>alert('Image size must be less than 2 MB.');</script>";
    exit();

}



    if(empty($design_code)){

        echo "<script>alert('Design code must contain minimum 3 characters');</script>";

    }

    elseif($price <= 0){

        echo "<script>alert('Price must be greater than 0');</script>";

    }

    elseif(!in_array($availability, ["Available","Unavailable"])){

        echo "<script>alert('Invalid availability status');</script>";

    }


    else{


        $check = $conn->prepare(

            "SELECT Design_ID 
             FROM designs
             WHERE Design_Code=?"

        );


       $check->bind_param(

"s",

$design_code

);


        $check->execute();


        $existing = $check->get_result();



        if($existing->num_rows > 0){


            echo "<script>alert('Design already exists');</script>";

        }

        else{

move_uploaded_file($tmp, "images/" . $image);

$stmt = $conn->prepare(

    "INSERT INTO designs
    (
    Design_Code,
    Category,
    Price,
    Availability,
    Image
    )
    VALUES(?,?,?,?,?)"

);


           $stmt->bind_param(

"ssdss",

$design_code,
$category,
$price,
$availability,
$image

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



<form method="POST" enctype="multipart/form-data" class="space-y-5">



<div>


</div>




<div>

<label>Category</label>

<select

name="category"

class="w-full border p-3 rounded">


<option value="Bridal">Bridal</option>
<option value="Semi Bridal">Semi Bridal</option>
<option value="Arabic">Arabic</option>
<option value="Front Hand">Front Hand</option>
<option value="Back Hand">Back Hand</option>
<option value="Floral">Floral</option>
<option value="Simple">Simple</option>
<option value="Royal">Royal</option>
<option value="Gorgeous">Gorgeous</option>
<option value="Modern">Modern</option>
<option value="Stylish">Stylish</option>

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



</div>
<div>

<label>Design Image</label>

<input

type="file"

name="image"

accept=".jpg,.jpeg,.png"

required

class="w-full border p-3 rounded">

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
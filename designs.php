<?php

include 'db_connect.php';


$search = "";


if(isset($_GET['search']) && $_GET['search'] != ""){


    $search = trim($_GET['search']);


    $stmt = $conn->prepare(

        "SELECT * FROM designs

        WHERE Design_Name LIKE ?
        OR Category LIKE ?
        OR Description LIKE ?"

    );


    $keyword = "%".$search."%";


    $stmt->bind_param(

        "sss",

        $keyword,
        $keyword,
        $keyword

    );


    $stmt->execute();


    $result = $stmt->get_result();



}
else{


    $result = mysqli_query(

        $conn,

        "SELECT * FROM designs"

    );


}



$count_result = mysqli_query(

    $conn,

    "SELECT COUNT(*) AS total FROM designs"

);


$count = mysqli_fetch_assoc($count_result);



?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Henna Designs</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">



<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4">


<div class="flex flex-wrap justify-center gap-6 text-white font-medium">


<a href="index.php" class="hover:text-yellow-200">

Home

</a>


<a href="designs.php" class="hover:text-yellow-200">

Designs

</a>


<a href="bookings.php" class="hover:text-yellow-200">

Book Appointment

</a>


<a href="admin_login.php" class="hover:text-yellow-200">

Admin Login

</a>


</div>


</div>

</nav>





<div class="max-w-7xl mx-auto mt-10 px-6">



<div class="text-center mb-8">


<h1 class="text-5xl font-bold text-amber-900">

Our Henna Collection

</h1>


<p class="text-gray-600 mt-3">

Choose from our beautiful henna designs or bring your own design inspiration.

</p>


<div class="mt-4 bg-white inline-block px-5 py-3 rounded-lg shadow">

Available Designs:

<span class="font-bold text-amber-800">

<?php echo $count['total']; ?>

</span>

</div>


</div>






<form method="GET" class="flex justify-center gap-3 mb-10">


<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

placeholder="Search design, category or description"

class="border p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-6 rounded-lg">

Search

</button>



<a href="designs.php"

class="bg-gray-500 text-white px-5 py-3 rounded-lg">

Reset

</a>


</form>







<div class="grid md:grid-cols-3 gap-8">





<?php if(mysqli_num_rows($result) > 0){ ?>



<?php while($row = mysqli_fetch_assoc($result)){ ?>



<div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">



<?php

$image = "images/Simple Henna.jpeg";


if(isset($row['Image']) && !empty($row['Image'])){

    $image = "images/".$row['Image'];

}


?>



<img

src="<?php echo htmlspecialchars($image); ?>"

class="w-full h-72 object-cover"

onerror="this.src='images/Simple Henna.jpeg';">





<div class="p-6">



<h2 class="text-2xl font-bold text-amber-800">

<?php echo htmlspecialchars($row['Design_Name']); ?>

</h2>





<p class="mt-3">

<strong>Category:</strong>

<?php echo htmlspecialchars($row['Category']); ?>

</p>





<p class="mt-2">

<strong>Price:</strong>

৳<?php echo htmlspecialchars($row['Price']); ?>

</p>





<p class="mt-2">

<strong>Status:</strong>


<span class="<?php echo ($row['Availability']=="Available") ? 'text-green-600 font-bold':'text-red-600 font-bold'; ?>">


<?php echo htmlspecialchars($row['Availability']); ?>


</span>


</p>






<p class="mt-4 text-gray-600">


<?php echo htmlspecialchars($row['Description']); ?>


</p>





<a href="bookings.php">


<button

class="mt-5 w-full bg-amber-700 text-white py-3 rounded-lg hover:bg-amber-900">


Book Now


</button>


</a>




</div>


</div>



<?php } ?>



<?php } else { ?>



<div class="col-span-3 text-center bg-white p-8 rounded-lg shadow">


<p class="text-gray-600 text-lg">

No designs found.

</p>


</div>



<?php } ?>





</div>




</div>



</body>

</html>
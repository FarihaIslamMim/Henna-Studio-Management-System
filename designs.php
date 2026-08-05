<?php

include 'db_connect.php';
$category = "";

if(isset($_GET['category'])){
    $category = $_GET['category'];
}


$search = "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}


if(isset($_GET['search']) && $_GET['search'] != ""){


    $search = trim($_GET['search']);


    $stmt = $conn->prepare(

        "SELECT * FROM designs

WHERE Design_Code LIKE ?
OR Category LIKE ?

ORDER BY Design_ID ASC"

    );


    $keyword = "%".$search."%";


    $stmt->bind_param(

        "ss",

        $keyword,
        $keyword

    );
    
    $stmt->execute();

    $result = $stmt->get_result();

}
else{


    $sql = "SELECT * FROM designs WHERE 1";


if($category != ""){
    $sql .= " AND Category='$category'";
}


if($search != ""){
    $sql .= " AND Design_Code LIKE '%$search%'";
}

$sql .= " ORDER BY Category ASC, Design_ID ASC";

$result = mysqli_query($conn,$sql);

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

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-white text-2xl font-bold">

Henna Studio Designs

</h1>

<a href="index.php"
class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-gray-100 font-semibold">

← Back to Home

</a>

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

placeholder="Search design code or category"

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



<?php if(mysqli_num_rows($result) > 0){ ?>

<div class="flex flex-wrap justify-center gap-3 mb-8">


<a href="designs.php"
class="bg-amber-700 text-white px-4 py-2 rounded">
All
</a>


<a href="designs.php?category=Bridal"
class="bg-amber-700 text-white px-4 py-2 rounded">
Bridal
</a>


<a href="designs.php?category=Arabic"
class="bg-amber-700 text-white px-4 py-2 rounded">
Arabic
</a>


<a href="designs.php?category=Modern"
class="bg-amber-700 text-white px-4 py-2 rounded">
Modern
</a>


<a href="designs.php?category=Stylish"
class="bg-amber-700 text-white px-4 py-2 rounded">
Stylish
</a>


<a href="designs.php?category=Floral"
class="bg-amber-700 text-white px-4 py-2 rounded">
Floral
</a>


</div>

<div class="grid md:grid-cols-3 gap-8">


<?php while($row = mysqli_fetch_assoc($result)){ ?>



<div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition">



<?php

$image = "images/Simple Henna.jpeg";

if(!empty($row['Image'])){
    $image = "images/" . $row['Image'];
}

?>



<img

src="<?php echo htmlspecialchars($image); ?>"

class="w-full h-72 object-cover cursor-pointer"

onclick="openImage('<?php echo htmlspecialchars($image); ?>')"

onerror="this.src='images/Simple Henna.jpeg';">





<div class="p-6">



<h2 class="text-2xl font-bold text-amber-800">

Design Code: <?php echo htmlspecialchars($row['Design_Code']); ?>

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


<a href="bookings.php?design_id=<?php echo $row['Design_ID']; ?>">


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

<div
id="imageModal"
class="hidden fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">

<span
onclick="closeImage()"
class="absolute top-5 right-8 text-white text-5xl cursor-pointer">

&times;

</span>

<img
id="popupImage"
class="max-w-[90%] max-h-[90%] rounded-xl shadow-2xl">

</div>

</body>
<script>

function openImage(src){

document.getElementById("popupImage").src = src;

document.getElementById("imageModal").classList.remove("hidden");

}

function closeImage(){

document.getElementById("imageModal").classList.add("hidden");

}

</script>

</html>
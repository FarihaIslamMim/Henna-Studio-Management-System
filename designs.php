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

<body class="bg-[#f5efe6] min-h-screen">

<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">


<h1 class="text-2xl font-bold text-white">
Henna Studio
</h1>


<div class="flex gap-8 text-white font-semibold">

<a href="index.php"
class="hover:text-yellow-200 transition">
Home
</a>


<a href="designs.php"
class="hover:text-yellow-200 transition">
Designs
</a>


<a href="bookings.php"
class="hover:text-yellow-200 transition">
Book Appointment
</a>


<a href="admin_login.php"
class="hover:text-yellow-200 transition">
Admin Login
</a>


</div>


</div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

<div class="text-center mb-12">


<h1 class="text-5xl font-bold text-amber-900">

Our Henna Collection

</h1>


<p class="text-gray-600 mt-4 text-lg">

Explore elegant bridal, Arabic, floral and modern henna designs.

</p>


<div class="mt-6 inline-flex bg-white shadow-md px-8 py-4 rounded-full">

<span class="text-gray-700">

Available Designs:

</span>

<span class="ml-2 font-bold text-amber-800">

<?php echo $count['total']; ?>

</span>

</div>


</div>

<form method="GET" class="flex justify-center gap-3 mb-12">


<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

placeholder="Search design code or category"

class="w-96 px-5 py-3 rounded-full border border-gray-300 shadow-sm focus:ring-2 focus:ring-amber-600 focus:outline-none">


<button

type="submit"

class="bg-amber-800 text-white px-8 rounded-full hover:bg-amber-900">

Search

</button>


<a href="designs.php"

class="bg-white border px-6 py-3 rounded-full hover:bg-gray-100">

Reset

</a>


</form>
<?php if(mysqli_num_rows($result) > 0){ ?>

<div class="flex flex-wrap justify-center gap-3 mb-8">


<a href="designs.php"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition>
All
</a>


<a href="designs.php?category=Bridal"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition">
Bridal
</a>


<a href="designs.php?category=Arabic"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition">
Arabic
</a>


<a href="designs.php?category=Modern"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition">
Modern
</a>


<a href="designs.php?category=Stylish"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition">
Stylish
</a>


<a href="designs.php?category=Floral"
class="bg-white text-amber-800 border border-amber-700 px-5 py-2 rounded-full hover:bg-amber-800 hover:text-white transition">
Floral
</a>


</div>

<div class="grid md:grid-cols-3 gap-8 items-start">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition">

<?php

$image = "";

if(!empty($row['Image'])){
    $image = "images/" . $row['Image'];
}

?>

<img

src="<?php echo htmlspecialchars($image); ?>"

class="w-full h-80 object-cover cursor-pointer"

onclick="openImage('<?php echo htmlspecialchars($image); ?>')"

onerror="this.style.display='none';">

<div class="p-6">

<h2 class="text-2xl font-bold text-amber-800">

Design Code: <?php echo htmlspecialchars($row['Design_Code']); ?>

</h2>





<p class="mt-3">

<strong>Category:</strong>

<?php echo htmlspecialchars($row['Category']); ?>

</p>





<p class="mt-3 text-lg font-semibold text-amber-900">

Price:
<span class="text-amber-700">
৳<?php echo htmlspecialchars($row['Price']); ?>
</span>

</p>





<p class="mt-2">

<strong>Status:</strong>


<span class="<?php echo ($row['Availability']=="Available") ? 'text-green-600 font-bold':'text-red-600 font-bold'; ?>">


<?php echo htmlspecialchars($row['Availability']); ?>


</span>


</p>


<a href="bookings.php?design_id=<?php echo $row['Design_ID']; ?>">


<button

class="mt-6 w-full bg-amber-800 text-white py-3 rounded-full hover:bg-amber-900 transition font-semibold">


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
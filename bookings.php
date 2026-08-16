<?php

include 'db_connect.php';

$artists = mysqli_query($conn,
"SELECT Artist_ID, Name FROM artists
WHERE Status='Active'
ORDER BY Name");

$designs = mysqli_query($conn,

"SELECT
Design_ID,
Design_Code,
Category,
Image,
Price
FROM designs

WHERE Availability='Available'

ORDER BY Category, Design_Code");

$selected_design = "";

if(isset($_POST['design_id'])){
    $selected_design = $_POST['design_id'];
}
elseif(isset($_GET['design_id'])){
    $selected_design = $_GET['design_id'];
}


if(isset($_POST['submit'])){


$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$artist_id = intval($_POST['artist_id']);
$selected_design = $_POST['design_id'];
$design_id = ($selected_design === "CUSTOM") ? null : intval($selected_design);
if($selected_design == ""){

    echo "<script>
    alert('Please select a design before booking');
    window.location='bookings.php';
    </script>";

    exit();

}

$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];

$status = "PENDING";
$payment_option = $_POST['payment_option'];

$allowed_status = ["CONFIRMED","PENDING","CANCELLED"];
if(!preg_match('/^1[3-9][0-9]{8}$/', $phone)){

    echo "<script>
    alert('Enter a valid Bangladeshi mobile number.');
    window.location='bookings.php';
    </script>";

    exit();

}

$phone = "+880".$phone;

if($artist_id<=0){

echo "<script>
alert('Please select an artist');
</script>";

exit();

}

elseif(!in_array($status,$allowed_status)){

echo "<script>alert('Invalid booking status');</script>";

}



elseif($booking_date < date('Y-m-d')){

echo "<script>alert('Booking date cannot be in the past');</script>";

}



elseif($booking_time < "09:00" || $booking_time > "21:00"){

echo "<script>alert('Booking time must be between 9 AM and 9 PM');</script>";

}



else{


// Check if customer already exists

$stmt = $conn->prepare(
"SELECT Customer_ID
FROM customers
WHERE Phone=?
AND Status='Active'"
);

$stmt->bind_param("s",$phone);

$stmt->execute();

$customer = $stmt->get_result();

if($customer->num_rows){

    $customer_id = $customer->fetch_assoc()['Customer_ID'];

}else{

    $stmt = $conn->prepare(

    "INSERT INTO customers
    (Name,Phone,Email,Address)

    VALUES(?,?,?,?)"

    );

    $stmt->bind_param(

    "ssss",

    $name,
    $phone,
    $email,
    $address

    );

    $stmt->execute();

    $customer_id = $conn->insert_id;

}



// Check artist active

$stmt=$conn->prepare(

"SELECT Artist_ID FROM artists 
 WHERE Artist_ID=? AND Status='Active'"

);

$stmt->bind_param("i",$artist_id);

$stmt->execute();

$artist=$stmt->get_result();


// Check design availability only if normal design selected

if($design_id !== null){

    $stmt=$conn->prepare(
    "SELECT Design_ID FROM designs
     WHERE Design_ID=? AND Availability='Available'"
    );

    $stmt->bind_param("i",$design_id);

    $stmt->execute();

    $design=$stmt->get_result();

}



if(!$artist->num_rows){

    echo "<script>alert('Artist does not exist or inactive');</script>";

}
elseif($design_id !== null && !$design->num_rows){

    echo "<script>alert('Design unavailable');</script>";

}

else{


// duplicate booking check


$stmt=$conn->prepare(

"SELECT Booking_ID 
FROM bookings
WHERE Artist_ID=?
AND Booking_Date=?
AND Booking_Time=?"

);


$stmt->bind_param(

"iss",

$artist_id,
$booking_date,
$booking_time

);


$stmt->execute();


$duplicate=$stmt->get_result();



if($duplicate->num_rows){

    echo "<script>alert('Artist already booked at this time');</script>";

}else{


$payment_option = $_POST['payment_option'];


if($design_id === null){

$stmt=$conn->prepare(

"INSERT INTO bookings
(Customer_ID,Artist_ID,Design_ID,Booking_Date,Booking_Time,Status,Payment_Option)

VALUES(?,?,NULL,?,?,?,?)"

);

$stmt->bind_param(

"iissss",

$customer_id,
$artist_id,
$booking_date,
$booking_time,
$status,
$payment_option

);

}
else{


    $stmt=$conn->prepare(

    "INSERT INTO bookings
    (Customer_ID,Artist_ID,Design_ID,Booking_Date,Booking_Time,Status,Payment_Option)

    VALUES(?,?,?,?,?,?,?)"

    );


    $stmt->bind_param(

    "iiissss",

    $customer_id,
    $artist_id,
    $design_id,
    $booking_date,
    $booking_time,
    $status,
    $payment_option

    );


}

if($stmt->execute()){

    $booking_id = $conn->insert_id;

    if($payment_option == "Now"){

        echo "<script>
        window.location='customer_payment.php?booking_id=$booking_id';
        </script>";

    }
    else{

        echo "<script>
        window.location='booking_success.php';
        </script>";

    }

}

else{

echo "<script>alert('Booking failed');</script>";

}


}



}



}



}


?>



<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Booking</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-[#efe3d2] min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<h1 class="text-white text-2xl font-bold">
Henna Studio Booking
</h1>

<div class="flex gap-3">

<a href="index.php"
class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-gray-100">

← Back to Home

</a>

</div>

</div>

</nav>



<div class="max-w-6xl mx-auto mt-12 bg-white rounded-3xl shadow-xl overflow-hidden border border-[#e8d6bd] p-8">


<div class="grid md:grid-cols-2 gap-10">


<!-- LEFT SIDE -->

<div class="bg-[#e8d6bd] p-10 rounded-3xl">

<h1 class="text-5xl font-bold text-[#7b451d] mb-4">

Book Your Henna Appointment

</h1>


<p class="text-gray-700 text-lg">

Choose your favourite design, artist and booking time.

</p>


<div class="mt-10 bg-white rounded-2xl p-8 shadow-lg border border-[#dcc3a3]">

<h3 class="text-3xl font-bold text-amber-900 mb-4">

Why Choose Us?

</h3>


<p class="text-gray-700 leading-8">

✓ Professional Henna Artists<br>

✓ Bridal & Custom Designs<br>

✓ Home Service Available<br>

✓ Easy Online Booking

</p>


</div>


</div>



<!-- RIGHT SIDE -->

<div class="p-10 bg-white rounded-3xl">


<h2 class="text-3xl font-bold text-center text-[#6btext-amber-9003f1d] mb-8">

Booking Form

</h2>

<form method="POST" class="space-y-5">



<label class="font-semibold text-gray-700 mb-1 block">

Name

</label>

<input
type="text"
name="name"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3]">

<label class="font-semibold text-gray-700 mb-1 block">

Phone Number

</label>

<div class="flex">

<span class="bg-gray-100 border border-r-0 rounded-l-lg px-4 py-3">
+880
</span>

<input
type="text"
name="phone"
placeholder="1712345678"
maxlength="10"
required
class="w-full border border-[#d8c2a8] rounded-r-lg p-3 bg-[#fffaf3] focus:ring-2 focus:ring-[#8b5e34]">

</div>

<label class="font-semibold text-gray-700 mb-1 block">

Email

</label>

<input
type="email"
name="email"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3]">

<label class="font-semibold text-gray-700 mb-1 block">

Address

</label>

<input
type="text"
name="address"
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3]">



<label class="font-semibold text-gray-700 mb-1 block">

Artist

</label>

<select
name="artist_id"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3]">

<option value="">Select Artist</option>

<?php while($artist=mysqli_fetch_assoc($artists)){ ?>

<option value="<?php echo $artist['Artist_ID']; ?>">

<?php echo $artist['Name']; ?>

</option>

<?php } ?>

</select>



<label class="font-semibold text-gray-700 mb-1 block">

Select Design

</label>

<select
name="design_id"
id="designSelect"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3]">

<option value="">
Select Design
</option>


<option
value="CUSTOM"
data-category="Custom Design"
data-code="CUSTOM"
data-image="">

Custom Design (Show reference to artist)

</option>


<?php while($d = mysqli_fetch_assoc($designs)){ ?>

<option
value="<?php echo $d['Design_ID']; ?>"
data-price="<?php echo $d['Price']; ?>"

<?php
if($selected_design == $d['Design_ID']){
    echo "selected";
}
?>

data-category="<?php echo htmlspecialchars($d['Category']); ?>"

data-code="<?php echo htmlspecialchars($d['Design_Code']); ?>"

data-image="<?php echo htmlspecialchars($d['Image']); ?>"

>

<?php echo htmlspecialchars($d['Category']); ?>

-

<?php echo htmlspecialchars($d['Design_Code']); ?>

</option>


<?php } ?>


</select>

<div class="mt-4 bg-yellow-50 p-4 rounded-lg">

<p class="font-bold text-amber-900">

Design Price:

<span id="designPrice">
Select a design
</span>

</p>

</div>

<div id="designPreview" class="hidden mt-5 bg-[#f6ead8] border border-[#dcc3a3] rounded-xl p-5">

<h3 class="font-bold text-lg text-[#6b3f1d]">

<span id="previewCategory"></span>

-

<span id="previewCode"></span>

</h3>


<img 
id="previewImage"
src=""
class="mt-4 w-72 h-72 object-cover rounded-xl shadow-lg hidden">

</div>

<input type="date"
name="booking_date"
min="<?php echo date('Y-m-d');?>"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3] mb-3">
<input type="time"
name="booking_time"
required
class="w-full border border-[#d8c2a8] p-3 rounded-xl focus:ring-2 focus:ring-[#8b5e34] focus:outline-none bg-[#fffaf3] mb-3">

<label class="font-semibold">
Payment Option
</label>


<select name="payment_option"
class="w-full border p-3 rounded-lg">

<option value="Later">
Pay after service
</option>

<option value="Now">
Pay now
</option>

</select>

<button
name="submit"
class="w-full bg-amber-700 hover:bg-amber-800 text-white text-lg font-semibold py-4 rounded-full transition duration-300 shadow-lg">

Save Booking

</button>



</form>

</div>

</div>

</div>

<script>

const designSelect = document.getElementById("designSelect");

const preview = document.getElementById("designPreview");

const previewCategory = document.getElementById("previewCategory");

const previewCode = document.getElementById("previewCode");

const previewImage = document.getElementById("previewImage");

function updatePreview(){

    let selected = designSelect.options[designSelect.selectedIndex];

    if(designSelect.value==""){

        preview.classList.add("hidden");
        return;

    }

    preview.classList.remove("hidden");

previewCategory.textContent = selected.dataset.category;

previewCode.textContent = selected.dataset.code;


if(selected.dataset.code == "CUSTOM"){

    previewCategory.textContent = "Custom Design";
    previewCode.textContent = "Bring your own reference";
    previewImage.classList.add("hidden");

}
else{

    previewImage.classList.remove("hidden");

    previewImage.style.display = selected.dataset.image ? "block" : "none";

if(selected.dataset.image){
    previewImage.src = "images/" + selected.dataset.image;
}

}

}

designSelect.addEventListener("change", updatePreview);
const paymentOption = document.querySelector("select[name='payment_option']");

designSelect.addEventListener("change",function(){

let selected = this.options[this.selectedIndex];

let price = selected.dataset.price;


if(price){

document.getElementById("designPrice").innerHTML =
"৳ " + price;

paymentOption.disabled = false;

}

else{

document.getElementById("designPrice").innerHTML =
"Custom Design (Pay after service only)";

paymentOption.value = "Later";

paymentOption.disabled = true;

}

});

// THIS IS THE IMPORTANT LINE
updatePreview();


</script>
</body>

</html>
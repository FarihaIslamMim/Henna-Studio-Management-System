<?php

session_start();

if (!isset($_SESSION['admin'])) {

    header("Location: admin_login.php");
    exit();

}

include 'db_connect.php';


$search = "";


if (isset($_GET['search']) && $_GET['search'] != "") {


    $search = trim($_GET['search']);


    $stmt = $conn->prepare(

        "SELECT
            reviews.*,
            customers.Name AS Customer_Name,
            designs.Design_Code

        FROM reviews

        LEFT JOIN customers
            ON reviews.Customer_ID = customers.Customer_ID

        LEFT JOIN bookings
            ON reviews.Booking_ID = bookings.Booking_ID

        LEFT JOIN designs
            ON bookings.Design_ID = designs.Design_ID

        WHERE customers.Name LIKE ?
        OR reviews.Booking_ID LIKE ?
        OR reviews.Rating LIKE ?"

    );


    $searchTerm = "%".$search."%";


    $stmt->bind_param(

        "sss",

        $searchTerm,
        $searchTerm,
        $searchTerm

    );


    $stmt->execute();


    $result = $stmt->get_result();


}

else {


    $result = mysqli_query(

        $conn,

        "SELECT
            reviews.*,
            customers.Name AS Customer_Name,
            designs.Design_Code

        FROM reviews

        LEFT JOIN customers
            ON reviews.Customer_ID = customers.Customer_ID

        LEFT JOIN bookings
            ON reviews.Booking_ID = bookings.Booking_ID

        LEFT JOIN designs
            ON bookings.Design_ID = designs.Design_ID"

    );


}



?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Reviews</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-orange-50 min-h-screen">


<nav class="bg-amber-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">


<h1 class="text-white text-2xl font-bold">

Review Management

</h1>


<div class="flex gap-3">

<a href="admin_dashboard.php"
class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-gray-100">

← Back to Dashboard

</a>

</div>


</div>

</nav>




<div class="max-w-7xl mx-auto mt-10 px-6">


<h1 class="text-4xl font-bold text-center text-amber-900 mb-8">

Customer Reviews

</h1>



<form method="GET" class="mb-6 flex gap-3">


<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

placeholder="Search customer, booking ID or rating"

class="border p-3 rounded-lg w-96">



<button

type="submit"

class="bg-amber-700 text-white px-5 rounded-lg">

Search

</button>


<a href="view_reviews.php"

class="bg-gray-500 text-white px-5 py-3 rounded-lg">

Reset

</a>


</form>





<div class="overflow-x-auto">


<table class="w-full bg-white shadow-xl rounded-lg">


<tr class="bg-amber-800 text-white">


<th class="p-4">Review ID</th>

<th class="p-4">Customer</th>

<th class="p-4">Booking ID</th>

<th class="p-4">Design</th>

<th class="p-4">Rating</th>

<th class="p-4">Comment</th>

<th class="p-4">Date</th>

<th class="p-4">Action</th>


</tr>




<?php while($row = mysqli_fetch_assoc($result)){ ?>


<tr class="border text-center hover:bg-orange-50">


<td class="p-4">

<?php echo $row['Review_ID']; ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Customer_Name']); ?>

</td>


<td class="p-4">

<?php echo $row['Booking_ID']; ?>

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Design_Code']); ?>

</td>


<td class="p-4 text-yellow-600 font-bold">

<?php echo $row['Rating']; ?> ⭐

</td>


<td class="p-4">

<?php echo htmlspecialchars($row['Comment']); ?>

</td>


<td class="p-4">

<?php echo $row['Review_Date']; ?>

</td>



<td class="p-4">


<a href="edit_review.php?id=<?php echo $row['Review_ID']; ?>"

class="text-blue-600 font-semibold">

Edit

</a>



<a href="delete_review.php?id=<?php echo $row['Review_ID']; ?>"

onclick="return confirm('Delete this review?')"

class="text-red-600 font-semibold ml-4">

Delete

</a>


</td>


</tr>


<?php } ?>


</table>


</div>




<div class="mt-8">


<a href="reviews.php"

class="bg-amber-700 text-white px-6 py-3 rounded-lg">

Add New Review

</a>


</div>


</div>


</body>

</html>
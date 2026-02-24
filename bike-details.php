<?php
include("PHP/config/db.php");

if(!isset($_GET['id'])){
    die("Bike not found.");
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM bikes WHERE id=$id");

if(mysqli_num_rows($result) == 0){
    die("Bike not found.");
}

$bike = mysqli_fetch_assoc($result);

/* ================== GET REVIEWS ================== */

$reviewQuery = mysqli_query($conn, "SELECT * FROM reviews WHERE bike_id=$id");
$totalReviews = mysqli_num_rows($reviewQuery);

$totalRating = 0;
$reviews = [];

while($row = mysqli_fetch_assoc($reviewQuery)){
    $totalRating += $row['rating'];
    $reviews[] = $row;
}

$avgRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;

?>
<?php
// Exclude current bike from latest section
$currentId = $bike['id'];

$latest = mysqli_query(
    $conn,
    "SELECT * FROM bikes WHERE id != $currentId ORDER BY id DESC LIMIT 6"
    
);
?>


<!DOCTYPE html>
<html>
<head>
<title><?php echo $bike['brand'] . " " . $bike['name']; ?></title>
      
<style>

body{
    margin:0;
    font-family:Segoe UI;
    background:#eef1f5;
    padding:20px;
}

/* Main Container Smaller */
.container{
    max-width:700px;
    margin:auto;
    background:white;
    border-radius:12px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
}

/* Image Smaller */
.bike-img{
    width:100%;
    max-height:400px;
    object-fit:contain;
    background:#fff;
    border-radius:10px;
} 

/* Title */
.title{
    font-size:20px;
    font-weight:600;
    margin-top:10px;
}

/* Price */
.price{
    font-size:16px;
    font-weight:600;
    color:#27ae60;
    margin:6px 0;
}

/* Specs Grid Compact */
.specs{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
    margin-top:15px;
}

.spec-box{
    background:#f7f8fa;
    padding:6px 8px;
    border-radius:6px;
    font-size:12px;
}

/* Rating Small */
.rating-box{
    margin-top:12px;
    font-size:13px;
    font-weight:500;
}

.stars{
    color:orange;
    font-size:14px;
}

/* Reviews Section Compact */
.reviews{
    margin-top:25px;
}

.reviews h2{
    font-size:16px;
    margin-bottom:10px;
}

.review-card{
    background:#f7f8fa;
    padding:8px;
    border-radius:6px;
    margin-bottom:8px;
    font-size:12px;
}

.review-user{
    font-weight:600;
    font-size:12px;
}

.review-comment{
    margin-top:4px;
    color:#444;
}

</style>
</head>
<body>

<div class="container">

<img class="bike-img" src="PHP/uploads/<?php echo $bike['image']; ?>">

<div class="title">
<?php echo $bike['brand']." ".$bike['name']; ?>
</div>

<div class="price">
Rs. <?php echo number_format($bike['price']); ?>
</div>

<!-- ================= AVERAGE RATING ================= -->
<div class="rating-box">
Average Rating:
<span class="stars">
<?php
for($i=1;$i<=5;$i++){
    if($i <= round($avgRating)){
        echo "★";
    }else{
        echo "☆";
    }
}
?>
</span>

(<?php echo $avgRating; ?> / 5 from <?php echo $totalReviews; ?> reviews)
</div>

<!-- ================= SPEC SECTION ================= -->
<div class="specs">

<div class="spec-box"><strong>CC:</strong> <?php echo $bike['cc']; ?></div>
<div class="spec-box"><strong>Engine:</strong> <?php echo $bike['engine']; ?></div>
<div class="spec-box"><strong>Mileage:</strong> <?php echo $bike['mileage']; ?></div>
<div class="spec-box"><strong>Fuel:</strong> <?php echo $bike['fuel_type']; ?></div>
<div class="spec-box"><strong>Top Speed:</strong> <?php echo $bike['top_speed']; ?></div>
<div class="spec-box"><strong>Launch:</strong> <?php echo $bike['launch_date']; ?></div>

</div>

<!-- ================= REVIEWS SECTION ================= -->

<div class="reviews">

<h2>User Reviews</h2>

<?php if($totalReviews > 0): ?>

<?php foreach($reviews as $r): ?>

<div class="review-card">
<div class="review-user">
<?php echo $r['user_name']; ?>
<span style="color:orange;">
<?php for($i=1;$i<=5;$i++){
    echo ($i <= $r['rating']) ? "★" : "☆";
} ?>
</span>
</div>

<div class="review-comment">
<?php echo $r['review']; ?>
</div>

</div>

<?php endforeach; ?>

<?php else: ?>

<p>No reviews yet.</p>

<?php endif; ?>

</div>

</div>
<div style="margin-top:40px;">
<h2>Latest Bikes</h2>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px;">

<?php while($row = mysqli_fetch_assoc($latest)) { ?>

<div onclick="loadBike(<?php echo $row['id']; ?>)"
style="cursor:pointer;background:#f7f8fa;padding:10px;border-radius:10px;text-align:center;">

<img src="PHP/uploads/<?php echo $row['image']; ?>"
style="width:100%;height:120px;object-fit:contain;border-radius:8px;">

<div style="font-size:13px;font-weight:600;margin-top:5px;">
<?php echo $row['brand']." ".$row['name']; ?>
</div>

<div style="font-size:12px;color:green;">
Rs. <?php echo number_format($row['price']); ?>
</div>

</div>

<?php } ?>

</div>
</div>
<script>

function loadBike(id){

fetch("get_bike.php?id="+id)
.then(response => response.text())
.then(data => {
    document.body.innerHTML = data;
    window.history.pushState({}, "", "?id="+id);
});

}

</script>
</body>
</html>
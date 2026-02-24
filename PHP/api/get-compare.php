<?php
include("../config/db.php");

$id1 = $_GET['id1'];
$id2 = $_GET['id2'];

$q1 = mysqli_query($conn, "SELECT * FROM bikes WHERE id='$id1'");
$q2 = mysqli_query($conn, "SELECT * FROM bikes WHERE id='$id2'");

$bike1 = mysqli_fetch_assoc($q1);
$bike2 = mysqli_fetch_assoc($q2);

/* ===== ADD AVG RATING FROM REVIEWS TABLE ===== */

$r1 = mysqli_query($conn, "SELECT IFNULL(AVG(rating),0) as avg_rating FROM reviews WHERE bike_id='$id1'");
$r2 = mysqli_query($conn, "SELECT IFNULL(AVG(rating),0) as avg_rating FROM reviews WHERE bike_id='$id2'");

$rating1 = mysqli_fetch_assoc($r1);
$rating2 = mysqli_fetch_assoc($r2);

/* Add avg_rating into bike arrays */
$bike1['avg_rating'] = round($rating1['avg_rating'],1);
$bike2['avg_rating'] = round($rating2['avg_rating'],1);

/* If power column exists already in bikes table it will automatically be included */
/* If not, make sure bikes table has a column named `power` */

echo json_encode([
  "bike1" => $bike1,
  "bike2" => $bike2
]);
?>

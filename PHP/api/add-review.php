<?php
$conn = new mysqli("localhost","root","","bikexo");

header("Content-Type: application/json");

$bike_id   = $_POST['bike_id'] ?? '';
$user_name = $_POST['user_name'] ?? '';
$rating    = $_POST['rating'] ?? '';
$review    = $_POST['review'] ?? '';

if($bike_id=="" || $user_name=="" || $rating=="" || $review==""){
    echo json_encode(["status"=>"error","msg"=>"Missing fields"]);
    exit;
}

$sql = "INSERT INTO reviews (bike_id, user_name, rating, review)
        VALUES ('$bike_id','$user_name','$rating','$review')";

if($conn->query($sql)){
    echo json_encode(["status"=>"success"]);
}else{
    echo json_encode(["status"=>"error"]);
}
?>

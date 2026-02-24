<?php
$conn = new mysqli("localhost","root","","bikexo");

if(!isset($_GET['bike_id'])){
    echo json_encode([]);
    exit;
}

$bike_id = intval($_GET['bike_id']);

$sql = "SELECT * FROM reviews WHERE bike_id=$bike_id ORDER BY id DESC";
$result = $conn->query($sql);

$reviews = [];

while($row = $result->fetch_assoc()){
    $reviews[] = $row;
}

echo json_encode($reviews);
?>

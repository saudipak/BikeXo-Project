<?php
include("../config/db.php");

$type = $_GET['type']; // bike or scooter

$result = mysqli_query($conn,"SELECT * FROM bikes WHERE category='$type' ORDER BY id DESC");

$data = [];

while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
?>

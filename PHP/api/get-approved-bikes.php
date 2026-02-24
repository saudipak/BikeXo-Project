<?php
include("../config/db.php"); // connect to your database

$result = mysqli_query($conn, "SELECT * FROM used_bikes WHERE status='approved' ORDER BY id DESC");

$bikes = [];
while($row = mysqli_fetch_assoc($result)){
    $bikes[] = $row;
}

echo json_encode($bikes);
?>

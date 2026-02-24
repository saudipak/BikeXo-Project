<?php
include("../config/db.php");

$q = mysqli_query($conn,"SELECT id,name FROM bikes");

$bikes = [];

while($row = mysqli_fetch_assoc($q)){
  $bikes[] = $row;
}

echo json_encode($bikes);
?>

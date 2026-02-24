<?php
$conn = new mysqli("localhost","root","","bikexo");

$type = $_GET['type'];

$sql = "SELECT id,name FROM bikes WHERE category='$type'";
$result = $conn->query($sql);

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>

<?php
$conn = new mysqli("localhost","root","","bikexo");

if(isset($_GET['query'])){
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT id, name, price, image FROM bikes WHERE name LIKE '%$search%' LIMIT 10";
    $result = $conn->query($sql);

    $data = [];
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>

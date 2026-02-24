<?php
include("../config/db.php");

$id = $_GET['id'];

// Get image name
$data = mysqli_query($conn,"SELECT image FROM bikes WHERE id=$id");
$row = mysqli_fetch_assoc($data);
$image = $row['image'];

// Delete image from folder
if(file_exists("../uploads/".$image)){
    unlink("../uploads/".$image);
}

// Delete from database
mysqli_query($conn,"DELETE FROM bikes WHERE id=$id");

header("Location: dashboard.php");
?>

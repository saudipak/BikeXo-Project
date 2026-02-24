<?php
include("../config/db.php");

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $query = "UPDATE used_bikes SET status='rejected' WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: pending-bikes.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Request";
}
?>
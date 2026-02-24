<?php
include("../config/db.php");

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];

    $sql = "UPDATE used_bikes SET status='approved' WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location:pending-bikes.php?approved=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid Request";
}
?>

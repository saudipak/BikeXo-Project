<?php
include("../config/db.php");

if(!isset($_GET['id'])){
    die("Bike not found");
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM bikes WHERE id=$id");
if(mysqli_num_rows($result) == 0){
    die("Bike not found");
}

$bike = mysqli_fetch_assoc($result);

/* ================== COPY YOUR FULL PAGE HTML HERE ================== */
/* COPY YOUR DETAIL PAGE HTML FROM <html> TO </html> */
/* REMOVE OLD PHP QUERY PART */
/* KEEP ONLY DESIGN */
/* USE $bike DATA */

/* OR I CAN GIVE YOU CLEAN READY FILE IF YOU WANT */
?>
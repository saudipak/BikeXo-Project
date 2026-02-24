<?php
include("../config/db.php");

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $delete = mysqli_query($conn, "DELETE FROM reviews WHERE id='$id'");

    if($delete){
        echo "success";
    }else{
        echo "error";
    }
}else{
    echo "no_id";
}
?>

<?php
include("../config/db.php");

$id = $_GET['id'];

$data = mysqli_query($conn,"SELECT * FROM bikes WHERE id=$id");
$bike = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Bike</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>

<form method="POST" enctype="multipart/form-data">

<h2>Edit Bike</h2>

<input type="text" name="name" value="<?php echo $bike['name']; ?>" required>
<input type="text" name="brand" value="<?php echo $bike['brand']; ?>" required>
<input type="number" name="price" value="<?php echo $bike['price']; ?>" required>
<input type="number" name="cc" value="<?php echo $bike['cc']; ?>" required>
<input type="text" name="mileage" value="<?php echo $bike['mileage']; ?>">
<input type="text" name="top_speed" value="<?php echo $bike['top_speed']; ?>">
<input type="text" name="engine" value="<?php echo $bike['engine']; ?>">
<input type="text" name="fuel_type" value="<?php echo $bike['fuel_type']; ?>">
<input type="date" name="launch_date" value="<?php echo $bike['launch_date']; ?>">
<input type="text" name="category" value="<?php echo $bike['category']; ?>">

<p>Current Image:</p>
<img src="../uploads/<?php echo $bike['image']; ?>" width="120">

<input type="file" name="image">

<button name="update">Update Bike</button>

</form>

</body>
</html>

<?php
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $cc = $_POST['cc'];
    $mileage = $_POST['mileage'];
    $top_speed = $_POST['top_speed'];
    $engine = $_POST['engine'];
    $fuel = $_POST['fuel_type'];
    $launch = $_POST['launch_date'];
    $category = $_POST['category'];

    if($_FILES['image']['name'] != ""){
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp,"../uploads/".$image);

        mysqli_query($conn,"UPDATE bikes SET image='$image' WHERE id=$id");
    }

    mysqli_query($conn,"UPDATE bikes SET 
        name='$name',
        brand='$brand',
        price='$price',
        cc='$cc',
        mileage='$mileage',
        top_speed='$top_speed',
        engine='$engine',
        fuel_type='$fuel',
        launch_date='$launch',
        category='$category'
        WHERE id=$id
    ");

    echo "<script>alert('Bike Updated'); window.location='dashboard.php';</script>";
}
?>

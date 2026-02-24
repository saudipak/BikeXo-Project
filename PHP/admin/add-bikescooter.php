<link rel="stylesheet" href="admin.css">
<h2>Add New Bike / Scooter</h2>

<form action="add-bikescooter.php" method="POST" enctype="multipart/form-data">

  <input type="text" name="name" placeholder="Vehicle Name" required>
  <input type="text" name="brand" placeholder="Brand" required>
  <input type="number" name="price" placeholder="Price" required>
  <input type="number" name="cc" placeholder="CC" required>
  <input type="text" name="mileage" placeholder="Mileage">
  <input type="text" name="top_speed" placeholder="Top Speed">
  <input type="text" name="engine" placeholder="Engine">
  <input type="text" name="fuel_type" placeholder="Fuel Type">

  <input type="date" name="launch_date">

  <!-- CATEGORY DROPDOWN -->
  <select name="category" required>
    <option value="">Select Type</option>
    <option value="bike">Bike</option>
    <option value="scooter">Scooter</option>
  </select>

  <input type="file" name="image" required>

  <button type="submit" name="add">Add Vehicle</button>
</form>

<?php
include("../config/db.php");

if(isset($_POST['add'])){

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

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/".$image);

    $sql = "INSERT INTO bikes 
    (name, brand, price, cc, mileage, top_speed, engine, fuel_type, image, launch_date, category)
    VALUES
    ('$name','$brand','$price','$cc','$mileage','$top_speed','$engine','$fuel','$image','$launch','$category')";

    if(mysqli_query($conn,$sql)){
        echo "<p class='success'>Added successfully</p>";
    } else {
        echo "<p class='error'>Error</p>";
    }
}
?>

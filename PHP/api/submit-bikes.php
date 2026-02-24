<?php
// Start session if needed
session_start();
header('Content-Type: application/json');

// Include DB connection
include("../config/db.php");

// Folder to store uploaded images
$uploadDir = "../uploads/";

// Create folder if it doesn't exist
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0777, true);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ------------------ Seller Info ------------------
    $seller_name = mysqli_real_escape_string($conn, $_POST['seller_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);

    // ------------------ Bike Details ------------------
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $year = (int)$_POST['year'];
    $engine_cc = (int)$_POST['engine_cc'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $km_driven = (int)$_POST['km_driven'];
    $bike_condition = mysqli_real_escape_string($conn, $_POST['bike_condition']);
    $previous_owners = (int)$_POST['previous_owners'];
    $accident_history = mysqli_real_escape_string($conn, $_POST['accident_history']);
    $service_record = mysqli_real_escape_string($conn, $_POST['service_record']);

    $bluebook_status = mysqli_real_escape_string($conn, $_POST['bluebook_status']);
    $tax_valid_until = (int)$_POST['tax_valid_until'];
    $insurance_valid = mysqli_real_escape_string($conn, $_POST['insurance_valid']);

    $price = (int)$_POST['price'];
    $negotiable = mysqli_real_escape_string($conn, $_POST['negotiable']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // ------------------ Handle Images ------------------
    $images = [];
    for($i=1; $i<=3; $i++){
        if(isset($_FILES['image'.$i]) && $_FILES['image'.$i]['error'] === 0){
            $ext = pathinfo($_FILES['image'.$i]['name'], PATHINFO_EXTENSION);
            $filename = uniqid('bike_', true) . '.' . $ext;
            $target = $uploadDir . $filename;
            
            if(move_uploaded_file($_FILES['image'.$i]['tmp_name'], $target)){
                // store relative path
                $images[] = "../uploads/" . $filename;
            } else {
                $images[] = "";
            }
        } else {
            $images[] = "";
        }
    }

    // ------------------ Insert into DB ------------------
    $sql = "INSERT INTO used_bikes 
    (seller_name, phone, email, district, city, brand, model, year, engine_cc, category, km_driven, bike_condition, previous_owners, accident_history, service_record, bluebook_status, tax_valid_until, insurance_valid, price, negotiable, description, image1, image2, image3, status)
    VALUES
    ('$seller_name', '$phone', '$email', '$district', '$city', '$brand', '$model', $year, $engine_cc, '$category', $km_driven, '$bike_condition', $previous_owners, '$accident_history', '$service_record', '$bluebook_status', $tax_valid_until, '$insurance_valid', $price, '$negotiable', '$description', '{$images[0]}', '{$images[1]}', '{$images[2]}', 'pending')";

    if(mysqli_query($conn, $sql)){
        // Success, redirect to a thank you page or back to form
        header("Location: sell-used-bikes.html?success=1");
  
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method.";
}
?>

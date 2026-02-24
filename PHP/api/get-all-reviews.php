
<?php
$conn = new mysqli("localhost","root","","bikexo");

$sql = "
SELECT reviews.id,
       reviews.user_name,
       reviews.rating,
       reviews.review,
       reviews.created_at,
       bikes.name AS bike_name,
       bikes.category
FROM reviews
JOIN bikes ON reviews.bike_id = bikes.id
ORDER BY reviews.id DESC
";

$result = $conn->query($sql);

$data=[];
while($row = $result->fetch_assoc()){
    $data[]=$row;
}

echo json_encode($data);
?> 
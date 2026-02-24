

<?php
include("../config/db.php");

$bikes = mysqli_query($conn,"SELECT * FROM bikes WHERE category='bike' ORDER BY id DESC");
$scooters = mysqli_query($conn,"SELECT * FROM bikes WHERE category='scooter' ORDER BY id DESC");
// $reviews = mysqli_query($conn,"SELECT * FROM reviews ORDER BY id DESC");
$reviews = mysqli_query($conn,"
    SELECT reviews.*, bikes.name AS bike_name, bikes.category 
    FROM reviews 
    JOIN bikes ON reviews.bike_id = bikes.id 
    ORDER BY reviews.id DESC
");

/* ===== AJAX REQUEST HANDLER ===== */

if(isset($_POST['request_action'])){

    if($_POST['request_action']=="fetch"){

        $filter = $_POST['filter'];

        if($filter=="all"){
            $query = "SELECT * FROM used_bikes ORDER BY id DESC";
        } else {
            $query = "SELECT * FROM used_bikes WHERE status='$filter' ORDER BY id DESC";
        }

        $result = mysqli_query($conn,$query);

       while($row=mysqli_fetch_assoc($result)){
?>


<tr id="req-<?php echo $row['id']; ?>">
    <td><?php echo $row['id']; ?></td>

    <td>
        <?php if(!empty($row['image1'])){ ?>
            <img src="../uploads/<?php echo $row['image1']; ?>" width="60" height="50" style="object-fit:cover; border-radius:6px;">
        <?php } else { ?>
            No Image
        <?php } ?>
    </td>

    <td><?php echo $row['brand']; ?></td>
    <td><?php echo $row['model']; ?></td>
    <td><?php echo $row['year']; ?></td>
    <td><?php echo $row['seller_name']; ?></td>
    <td>Rs <?php echo number_format($row['price']); ?></td>

    <td><?php echo ucfirst($row['status']); ?></td>

    <td>
        <?php if($row['status']=="pending"){ ?>
            <button onclick="updateRequest(<?php echo $row['id']; ?>,'approved')">Approve</button>
            <button onclick="updateRequest(<?php echo $row['id']; ?>,'rejected')">Reject</button>
            <button onclick="deleteRequest(<?php echo $row['id']; ?>)">Delete</button>
        <?php } else { ?>
            <button onclick="deleteRequest(<?php echo $row['id']; ?>)">Delete</button>
        <?php } ?>
    </td>
</tr>
<?php
}
        exit;
    }

    if($_POST['request_action']=="update"){
        $id=intval($_POST['id']);
        $status=$_POST['status'];
        mysqli_query($conn,"UPDATE used_bikes SET status='$status' WHERE id=$id");
        echo "updated";
        exit;
    }

    if($_POST['request_action']=="delete"){
        $id=intval($_POST['id']);
        mysqli_query($conn,"DELETE FROM used_bikes WHERE id=$id");
        echo "deleted";
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>BikeXo Admin Dashboard</title>
<link rel="stylesheet" href="admin.css">

<style>

.menu{
    margin:30px 0;
    display:flex;
    gap:20px;
}

.menu button{
    padding:12px 20px;
    border:none;
    background:#1f3a70;
    color:white;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
    width:auto;
}


.menu button:hover{
    background:#2f5bb5;
}

.section{
    display:none;
}

.section{
    display:none;
}

/* ===== Request Filters Inline ===== */

.request-filters{
    margin:15px 0;
    display:flex;
    gap:12px;
    align-items:center;
}

.request-filters button{
    padding:8px 16px;
    border:none;
    background:#1f3a70;
    color:white;
    font-size:14px;
    border-radius:6px;
    cursor:pointer;
    width:auto;   /* important */
}

.request-filters button:hover{
    background:#2f5bb5;
}

.request-filters button.active{
    background:#111;
}


</style>

</head>
<body>

<div class="dash-header">
  <h2>BikeXo Admin Dashboard</h2>
  <a href="add-bikescooter.php" class="add-btn">+ Add Bike / Scooter</a>
</div>

<!-- MENU BUTTONS -->
<div class="menu">
    <button onclick="showSection('bikes')">🚲 Bike List</button>
    <button onclick="showSection('scooters')">🛵 Scooter List</button>
    <button onclick="showSection('reviews')">⭐ Manage Rating & Review</button>
    <button onclick="showSection('requests')">📦 Manage Requests</button>
</div>

<!-- ================= BIKE SECTION ================= -->
<div id="bikes" class="section">

<h3>Bike List</h3>

<table>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Brand</th>
    <th>Price</th>
    <th>CC</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($bikes)) { ?>
<tr>
    <td><img src="../uploads/<?php echo $row['image']; ?>" width="70"></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['brand']; ?></td>
    <td>Rs <?php echo number_format($row['price']); ?></td>
    <td><?php echo $row['cc']; ?> cc</td>
    <td>
        <a class="edit" href="edit-bikes.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<!-- ================= SCOOTER SECTION ================= -->
<div id="scooters" class="section">

<h3>Scooter List</h3>

<table>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Brand</th>
    <th>Price</th>
    <th>CC</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($scooters)) { ?>
<tr>
    <td><img src="../uploads/<?php echo $row['image']; ?>" width="70"></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['brand']; ?></td>
    <td>Rs <?php echo number_format($row['price']); ?></td>
    <td><?php echo $row['cc']; ?> cc</td>
    <td>
        <a class="edit" href="edit-bikes.php?id=<?php echo $row['id']; ?>">Edit</a>
        <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<div id="reviews" class="section">


<h3>Manage Ratings & Reviews</h3>
<table border="1" width="100%">
  <thead>
    <tr>
      <th>User</th>
      <th>Bike</th>
      <th>Scooter</th>
      <th>Rating</th>
      <th>Review</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="reviewTable"></tbody>
</table>

</div>


<div id="requests" class="section">

<h3>Manage Used Bike Requests</h3>

<div class="request-filters">
    <button onclick="setActive(this); loadRequests('all')">All</button>
    <button onclick="setActive(this); loadRequests('pending')">Pending</button>
    <button onclick="setActive(this); loadRequests('approved')">Approved</button>
    <button onclick="setActive(this); loadRequests('rejected')">Rejected</button>
</div>

<table width="100%">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Brand</th>
    <th>Model</th>
    <th>Year</th>
    <th>Seller</th>
    <th>Price</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<tbody id="requestTable"></tbody>
</table>

</div>


<script>


function showSection(id){

    document.querySelectorAll(".section").forEach(sec=>{
        sec.style.display="none";
    });

    document.getElementById(id).style.display="block";
}

function loadReviews(){
 fetch("../api/get-all-reviews.php")
 .then(res=>res.json())
 .then(data=>{
   let html="";
   data.forEach(r=>{

     let bikeName = "-";
     let scooterName = "-";

     if(r.category === "bike"){
         bikeName = r.bike_name;
     }

     if(r.category === "scooter"){
         scooterName = r.bike_name;
     }

     html+=`
       <tr>
         <td>${r.user_name}</td>
         <td>${bikeName}</td>
         <td>${scooterName}</td>
         <td>${r.rating} ⭐</td>
         <td>${r.review}</td>
         <td>${r.created_at}</td>
         <td>
           <button onclick="deleteReview(${r.id})">❌ Delete</button>
         </td>
       </tr>
     `;
   });

   document.getElementById("reviewTable").innerHTML=html;
 });
}


function deleteReview(id){
 if(confirm("Delete this review?")){
   fetch("../api/delete-review.php",{
     method:"POST",
     headers:{"Content-Type":"application/x-www-form-urlencoded"},
     body:`id=${id}`
   })
   .then(res=>res.text())
   .then(res=>{
     if(res=="success"){
       loadReviews();
     }
   });


 }
}

loadReviews();
    

    


function toggleRequests(){
    let section = document.getElementById("requestSection");

    if(section.style.display === "none"){
        section.style.display = "block";
        loadRequests("all");
    } else {
        section.style.display = "none";
    }
}

function loadRequests(filter){
    fetch("dashboard.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"request_action=fetch&filter="+filter
    })
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("requestTable").innerHTML=data;
    });
}

function updateRequest(id,status){
    fetch("dashboard.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`request_action=update&id=${id}&status=${status}`
    })
    .then(()=>loadRequests("all"));
}

function deleteRequest(id){
    if(confirm("Delete this request?")){
        fetch("dashboard.php",{
            method:"POST",
            headers:{"Content-Type":"application/x-www-form-urlencoded"},
            body:`request_action=delete&id=${id}`
        })
        .then(()=>{
            document.getElementById("req-"+id).remove();
        });
    }
}
function setActive(btn){
    document.querySelectorAll('.request-filters button')
        .forEach(b => b.classList.remove('active'));

    btn.classList.add('active');
}

</script>

</body>
</html>

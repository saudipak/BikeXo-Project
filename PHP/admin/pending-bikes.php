<?php
session_start();
include("../config/db.php");

$result = mysqli_query($conn, "SELECT * FROM used_bikes WHERE status='pending' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Bikes</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            padding:20px;
        }
        h2{
            text-align:center;
            margin-bottom:30px;
        }
        table{
            width:100%;
            border-collapse: collapse;
            background:white;
        }
        th, td{
            padding:12px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }
        th{
            background:#222;
            color:white;
        }
        img{
            width:80px;
            height:60px;
            object-fit:cover;
        }
        .approve{
            background:green;
            color:white;
            padding:6px 12px;
            text-decoration:none;
            border-radius:4px;
        }
        .reject{
    background:red;
    color:white;
    padding:6px 12px;
    text-decoration:none;
    border-radius:4px;
    margin-left:5px;
}
    </style>
</head>
<body>

<h2>Pending Used Bikes</h2>

<?php if(mysqli_num_rows($result) > 0){ ?>
<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Year</th>
        <th>Price</th>
        <th>Seller</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>
            <?php if($row['image1']){ ?>
                <img src="/PHP/uploads/<?php echo $row['image1']; ?>">
            <?php } ?>
        </td>
        <td><?php echo $row['brand']; ?></td>
        <td><?php echo $row['model']; ?></td>
        <td><?php echo $row['year']; ?></td>
        <td>Rs. <?php echo number_format($row['price']); ?></td>
        <td><?php echo $row['seller_name']; ?></td>
      <td>
    <a class="approve" href="approve-bikes.php?id=<?php echo $row['id']; ?>">Approve</a>
    
    <a class="reject" href="reject-bike.php?id=<?php echo $row['id']; ?>" 
       onclick="return confirm('Are you sure you want to reject this bike?');">
       Reject
    </a>
</td>
    </tr>
    <?php } ?>
</table>

<?php } else { ?>
    <p style="text-align:center;">No pending bikes found.</p>
<?php } ?>

</body>
</html>

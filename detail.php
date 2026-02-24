<?php
include("PHP/config/db.php");

if(!isset($_GET['id'])){
    die("Invalid Bike");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM used_bikes WHERE id=$id AND status='approved'");

if(mysqli_num_rows($result) == 0){
    die("Bike not found");
}

$bike = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $bike['brand'] . " " . $bike['model']; ?></title>

    <style>
        body{
            font-family: 'Segoe UI', sans-serif;
            background:#f1f3f6;
            margin:0;
            padding:40px;
        }

        .container{
            max-width:900px;
            margin:auto;
            background:#fff;
            padding:25px;
            border-radius:12px;
            box-shadow:0 5px 20px rgba(0,0,0,0.08);
            display:flex;
            gap:30px;
        }

        .gallery{
            width:45%;
        }

        .main-img{
            width:100%;
            height:320px;
            object-fit:cover;
            border-radius:10px;
            margin-bottom:10px;
        }

        .thumbs{
            display:flex;
            gap:10px;
        }

        .thumbs img{
            width:90px;
            height:70px;
            object-fit:cover;
            border-radius:6px;
            cursor:pointer;
            border:2px solid transparent;
        }

        .thumbs img:hover{
            border:2px solid #222;
        }

        .details{
            width:55%;
        }

        h2{
            margin-top:0;
        }

        .price{
            font-size:22px;
            color:#0a8f3c;
            margin:10px 0 20px 0;
            font-weight:bold;
        }

        .info p{
            margin:6px 0;
        }

        .buttons{
            margin-top:20px;
            display:flex;
            gap:10px;
        }

        .btn{
            padding:10px 15px;
            border:none;
            border-radius:6px;
            text-decoration:none;
            color:white;
            font-weight:500;
        }

        .call{
            background:#007bff;
        }

        .whatsapp{
            background:#25D366;
        }

        .btn:hover{
            opacity:0.9;
        }

        .contact-box{
            margin-top:20px;
            background:#f7f7f7;
            padding:12px;
            border-radius:8px;
            font-size:14px;
        }

    </style>
</head>
<body>

<div class="container">

    <!-- IMAGE GALLERY -->
    <div class="gallery">

        <img id="mainImage" class="main-img" src="PHP/uploads/<?php echo $bike['image1']; ?>">

        <div class="thumbs">
            <?php if($bike['image1']){ ?>
                <img src="PHP/uploads/<?php echo $bike['image1']; ?>" onclick="changeImage(this.src)">
            <?php } ?>
            <?php if($bike['image2']){ ?>
                <img src="PHP/uploads/<?php echo $bike['image2']; ?>" onclick="changeImage(this.src)">
            <?php } ?>
            <?php if($bike['image3']){ ?>
                <img src="PHP/uploads/<?php echo $bike['image3']; ?>" onclick="changeImage(this.src)">
            <?php } ?>
        </div>

    </div>

    <!-- DETAILS -->
    <div class="details">

        <h2><?php echo $bike['brand'] . " " . $bike['model']; ?></h2>

        <div class="price">
            NPR <?php echo number_format($bike['price']); ?>
            <?php echo ($bike['negotiable'] == 'Yes') ? "(Negotiable)" : ""; ?>
        </div>

        <div class="info">
            <p><strong>Year:</strong> <?php echo $bike['year']; ?></p>
            <p><strong>Engine:</strong> <?php echo $bike['engine_cc']; ?> CC</p>
            <p><strong>KMs Driven:</strong> <?php echo $bike['km_driven']; ?></p>
            <p><strong>Condition:</strong> <?php echo $bike['bike_condition']; ?></p>
            <p><strong>Location:</strong> <?php echo $bike['city']; ?></p>
        </div>

        <div class="buttons">
            <a class="btn call" href="tel:<?php echo $bike['phone']; ?>">
                📞 Call Now
            </a>

            <a class="btn whatsapp" 
               href="https://wa.me/<?php echo $bike['phone']; ?>" 
               target="_blank">
                💬 WhatsApp
            </a>
        </div>

        <div class="contact-box">
            <p><strong>Seller:</strong> <?php echo $bike['seller_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $bike['email']; ?></p>
        </div>

    </div>

</div>

<script>
function changeImage(src){
    document.getElementById("mainImage").src = src;
}
</script>

</body>
</html>
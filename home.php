<?php
require_once "dbconfig.php";

$user_name = $_GET['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body{
            background-color:  #F5F5F7;
        }
    </style>
</head>
<body>
<div class="navbar">
     <div class="logo">
     <img src="css/LOGOpizza.png"alt="">
     </div>
     <div class="basket">
         <a class="btn btn-basket" href="basket.php?user_name=<?php echo $user_name; ?>">
             <i class="bi bi-basket3-fill"></i>
          </a>
     </div>
     <div class="nav-user">
        <a class="user-image" href="login.php">
            <i class="bi bi-person-circle"></i>
        </a>
        <a class="user-name" href="login.php"style="text-decoration: none;" >
           <h1>สวัสดี, <?php echo $user_name; ?>!</h1>
        </a>
     </div>
 </div>
 <div class="container-advert" style="margin-top: 1rem;">
    <div class="card-column">
             <a href=''>
                    <img src="https://cdn.1112delivery.com/1112one/public/images/banners/Sep23/Ham_Cheese_1440_TH.jpg"class='card-img-advert' alt="">
              </a>
    </div>
 </div>

    <div class="container-pizza">
        <div class="card-grid-pizza"style="margin-top: 5rem">
            <?php
            $sql_pizza = "SELECT pizza_id, pizza_image, pizza_name, detail, pizza_price
                          FROM Pizza";
            $result_pizza = $conn->query($sql_pizza);

            while ($pizzaData = $result_pizza->fetch_assoc()) {
                $pizza_id = $pizzaData['pizza_id'];
                $pizza_image = $pizzaData['pizza_image'];
                $pizza_name = $pizzaData['pizza_name'];
                $pizza_details = $pizzaData['detail'];
                $pizza_price = $pizzaData['pizza_price'];
                ?>
                <div class="card-column">
                        <a href=''>
                            <img src='<?php echo  $pizza_image; ?>' class='card-img-pizza' alt='Pizza Image' style="max-width: 100%; height: auto;">
                        </a>
                        <div class="card-body">
                             <h1><?php echo $pizza_name; ?></h1>
                             <h2><?php echo  $pizza_details; ?></h2>
                        </div>
                        <div class="price_and_btn">
                             <h3>฿<?php echo $pizza_price; ?>
                             <a class="btn btn-add-product" href="pizza_item.php?pizza_id=<?php echo $pizza_id; ?>&user_name=<?php echo $user_name; ?>" style="margin-right: 1rem; color: white; background-color: #67927A; border: none;">
                                <i class="bi bi-basket3-fill"></i> เพิ่มสินค้า
                            </a>
                            </h3>
                        </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>
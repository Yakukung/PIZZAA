<?php
require_once "dbconfig.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$position_name = isset($_GET['position_name']) ? $_GET['position_name'] : '';

if (isset($_GET['pizza_id'])) {
    $pizza_id = $_GET['pizza_id'];

    $sql = "SELECT * FROM Pizza WHERE pizza_id = $pizza_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pizza_name = $row['pizza_name'];
        $pizza_price = $row['pizza_price'];
        $pizza_details = $row['pizza_details'];
        $pizza_image = $row['pizza_image'];

    } else {
        echo "ไม่พบรายการพิซซ่าที่คุณต้องการ";
    }
} else {
    echo "กรุณาเลือกพิซซ่าที่คุณต้องการ";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Pizza Custom Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
     <div class="logo">
     <img src="css/LOGOpizza.png" alt="">
     </div>
        <div class="name-user">
            <h1>สวัสดี, <?php echo $user_name; ?>! <?php echo $position_name; ?></h1>
            <i class="bi bi-basket3-fill"> </i>
        </div>
        
 </div>
    <div class="container-pizza_custom">
        <div class="card-pizza-custom">
        <?php
        echo "<img src='$pizza_image' alt='$pizza_name' style='max-width: 100%; height: auto;' />";
        echo "<h1>$pizza_name</h1>";
        echo "<p>ราคา: ฿$pizza_price</p>";
        echo "<p>รายละเอียด: $pizza_details</p>";
        ?>
        </div>
        <h2>เลือกขนาดพิซซ่า:</h2>
        <form method="POST" action="order.php">
            <div class="pizza-sizes">
                <label>
                    <input type="radio" name="size_name" value="small">
                    Small
                </label>
                <label>
                    <input type="radio" name="size_name" value="medium">
                    Medium
                </label>
                <label>
                    <input type="radio" name="size_name" value="large">
                    Large
                </label>
            </div>
            <button type="submit" class="btn btn-primary">ยืนยัน</button>
            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
            <input type="hidden" name="position_name" value="<?php echo $position_name; ?>">
            <input type="hidden" name="pizza_id" value="<?php echo $pizza_id; ?>">
        </form>
    </div>
</body>
</html>

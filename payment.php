<?php
require_once "dbconfig.php";

if (isset($_GET["item_id"]) && isset($_GET["user_name"])) {
    $item_id = $_GET["item_id"];
    $user_name = $_GET['user_name'];

    // ทำคำสั่ง SQL สำหรับดึงข้อมูลสินค้าในตะกร้าของผู้ใช้
    $sql_payment = "SELECT Basket.amount, Item.*, Pizza.pizza_name, Size.size_name, Crust.crust_name
                    FROM Basket
                    INNER JOIN Item ON Basket.item_id = Item.item_id
                    INNER JOIN Pizza ON Item.pizza_id = Pizza.pizza_id
                    INNER JOIN Size ON Item.size_id = Size.size_id
                    INNER JOIN Crust ON Item.crust_id = Crust.crust_id
                    INNER JOIN `Order` ON Basket.order_id = `Order`.order_id
                    INNER JOIN User ON `Order`.user_id = User.user_id
                    WHERE User.user_name = ?
                    ORDER BY Basket.item_id ASC";

    // เตรียมคำสั่ง SQL
    $stmt_payment = $conn->prepare($sql_payment);
    $stmt_payment->bind_param("s", $user_name);

    // ประมวลผลคำสั่ง SQL
    if ($stmt_payment->execute()) {
        $result_payment = $stmt_payment->get_result();

        // คำนวณราคารวมทั้งหมดของรายการสินค้าที่อยู่ในตะกร้า
        $total_price = 0;
        while ($row = $result_payment->fetch_assoc()) {
            $item_price = $row["Price"];
            $item_amount = $row["amount"];
            $item_total_price = $item_price * $item_amount;
            $total_price += $item_total_price;
            // ... (แสดงข้อมูลรายการสินค้าที่นี่)
        }
    }
} else {
    // หากไม่พบรหัสสินค้าหรือชื่อผู้ใช้ให้แสดงข้อความแจ้งเตือน
    echo '<div class="alert alert-danger text-center" role="alert">ไม่พบรหัสสินค้าหรือชื่อผู้ใช้</div>';
    exit; // ออกจากสคริปต์
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_status = $_POST["payment_status"];

    // คำสั่ง SQL สำหรับอัปเดตค่า payment_status ในตาราง Order
    $sql_update_payment_status = "UPDATE `Order` SET payment_status = ? WHERE order_id = ?";
    $stmt_update_payment_status = $conn->prepare($sql_update_payment_status);
    $stmt_update_payment_status->bind_param("si", $payment_status, $item_id);

    // ทำการอัปเดตข้อมูลในตาราง Order สำหรับ payment_status
    if ($stmt_update_payment_status->execute()) {
        if ($payment_status == "จ่ายเงินแล้ว") {
            echo '<div class="alert alert-success text-center" role="alert">ชำระเงินเสร็จสิ้นแล้ว</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">ยังไม่ชำระเงิน</div>';
        }
    } else {
        // ไม่สามารถอัปเดตข้อมูลในตาราง Order สำหรับ payment_status ได้
        echo '<div class="alert alert-danger text-center" role="alert">ไม่สามารถอัปเดตข้อมูลการชำระเงินได้</div>';
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูลสำหรับ payment_status
    $stmt_update_payment_status->close();

    // คำสั่ง SQL สำหรับอัปเดตค่า total ในตาราง Order
    $total = $total_price; // ให้ $total เป็นค่าราคารวมทั้งหมด
    $sql_update_total = "UPDATE `Order` SET total = ? WHERE order_id = ?";
    $stmt_update_total = $conn->prepare($sql_update_total);
    $stmt_update_total->bind_param("di", $total, $item_id);

    // ทำการอัปเดตข้อมูลในตาราง Order สำหรับ total
    if ($stmt_update_total->execute()) {
        // อัปเดตข้อมูลในตาราง Order เสร็จสิ้น
    } else {
        // ไม่สามารถอัปเดตข้อมูลในตาราง Order สำหรับ total ได้
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูลสำหรับ total
    $stmt_update_total->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="navbar">
    <div class="logo">
        <a href="home.php?user_name=<?php echo $user_name; ?>">
            <img src="css/LOGOpizza.png" alt="">
        </a>
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
        <a class="user-name" href="login.php" style="text-decoration: none;">
            <h1>สวัสดี, <?php echo $user_name; ?></h1>
        </a>
    </div>
</div>
<div class="container mt-5">
    <h1>ชำระสินค้า</h1>
    <!-- แสดงรหัสสินค้าที่ถูกส่งมา -->
    <p>รหัสสินค้า: <?php echo $item_id; ?></p>

    <!-- แสดงราคารวมทั้งหมดของรายการสินค้าที่อยู่ในตะกร้า -->
    <?php
    $total_price = 0;
    while ($row = $result_payment->fetch_assoc()) {
        $item_price = $row["Price"];
        $item_amount = $row["amount"];
        $item_total_price = $item_price * $item_amount;
        $total_price += $item_total_price;
        ?>
        <p>รายการ: <?php echo $row["pizza_name"]; ?></p>
        <p>ราคาต่อชิ้น: <?php echo $item_price; ?> บาท</p>
        <p>จำนวน: <?php echo $item_amount; ?></p>
        <p>ราคารวม: <?php echo $item_total_price; ?> บาท</p>
        <hr>
    <?php } ?>

    <!-- แสดงราคารวมทั้งหมด -->
    <p>ราคารวมทั้งหมด: <?php echo $total_price; ?> บาท</p>

    <form method="post" action="">
        <div class="mb-3">
            <label for="payment_status" class="form-label">สถานะการชำระเงิน</label>
            <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="ยังไม่จ่ายเงิน" <?php if ($_POST["payment_status"] == "ยังไม่จ่ายเงิน") echo "selected"; ?>>ยังไม่จ่ายเงิน</option>
                <option value="จ่ายเงินแล้ว" <?php if ($_POST["payment_status"] == "จ่ายเงินแล้ว") echo "selected"; ?>>จ่ายเงินแล้ว</option>
            </select>
        </div>
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
</div>
<script>
    setTimeout(function() {
         document.querySelector(".alert").style.display = "none";
    }, 3000); // ซ่อนป๊อบอัพหลังจาก 3 วินาที
</script>
</body>
</html>

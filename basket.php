<?php
require_once "dbconfig.php";

if (isset($_GET['user_name'])) {
    $user_name = $_GET['user_name'];

    // ค้นหารายการสินค้าในตะกร้าของผู้ใช้
    $sql_basket = "SELECT Basket.amount, Item.*, Pizza.pizza_name, Size.size_name, Crust.crust_name
                    FROM Basket
                    INNER JOIN Item ON Basket.item_id = Item.item_id
                    INNER JOIN Pizza ON Item.pizza_id = Pizza.pizza_id
                    INNER JOIN Size ON Item.size_id = Size.size_id
                    INNER JOIN Crust ON Item.crust_id = Crust.crust_id
                    INNER JOIN `Order` ON Basket.order_id = `Order`.order_id
                    INNER JOIN User ON `Order`.user_id = User.user_id
                    WHERE User.user_name = ?
                    ORDER BY Basket.item_id ASC";

    $stmt_basket = $conn->prepare($sql_basket);
    $stmt_basket->bind_param("s", $user_name);
    $stmt_basket->execute();
    $result_basket = $stmt_basket->get_result();

    if (isset($_POST['item_id']) && isset($_POST['action'])) {
        $item_id = $_POST['item_id'];
        $action = $_POST['action'];

        // ดึงข้อมูลสินค้าจากตะกร้าของผู้ใช้
        $sql_select = "SELECT * FROM Basket WHERE item_id = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("i", $item_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();

        if ($result_select->num_rows > 0) {
            $row = $result_select->fetch_assoc(); // ดึงข้อมูลของสินค้า
            $current_amount = $row['amount'];

            // ตรวจสอบ action และดำเนินการอัปเดต amount ในฐานข้อมูลตามคำสั่งที่ต้องการ (increase หรือ decrease)
            if ($action === 'increase') {
                $new_amount = $current_amount + 1;
                $sql_update = "UPDATE Basket SET amount = ? WHERE item_id = ?";
            } elseif ($action === 'decrease') {
                if ($current_amount > 0) {
                    $new_amount = $current_amount - 1;

                    // ตรวจสอบว่าจำนวนใหม่ไม่น้อยกว่า 0
                    if ($new_amount > 0) {
                        $sql_update = "UPDATE Basket SET amount = ? WHERE item_id = ?";
                    } else {
                        // หากจำนวนเท่ากับ 0 ให้ลบสินค้าออก
                        $sql_delete = "DELETE Basket, Item FROM Basket
                                       INNER JOIN Item ON Basket.item_id = Item.item_id
                                       WHERE Basket.item_id = ?";
                        $stmt_delete = $conn->prepare($sql_delete);
                        $stmt_delete->bind_param("i", $item_id);
                        if ($stmt_delete->execute()) {
                            // สำเร็จในการลบสินค้า
                            header("Location: basket.php?user_name=" . $user_name);
                            exit;
                        } else {
                            // ไม่สามารถลบสินค้าได้
                            echo '<div class="alert alert-danger text-center" role="alert">ไม่สามารถลบสินค้าได้</div>';
                        }
                        $stmt_delete->close();
                    }
                }
            } elseif ($action === 'delete') {
                $sql_delete = "DELETE Basket, Item FROM Basket
                               INNER JOIN Item ON Basket.item_id = Item.item_id
                               WHERE Basket.item_id = ?";

                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $item_id);
                if ($stmt_delete->execute()) {
                    // สำเร็จในการลบสินค้า
                    header("Location: basket.php?user_name=" . $user_name);
                    exit;
                } else {
                    // ไม่สามารถลบสินค้าได้
                    echo '<div class="alert alert-danger text-center" role="alert">ไม่สามารถลบสินค้าได้</div>';
                }
                $stmt_delete->close();
            } elseif ($action === 'payment') {
                
                header("Location: payment.php?user_name=" . $user_name . "&item_id=" . $row['item_id']);
            }
            if (isset($sql_update)) {
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ii", $new_amount, $item_id);

                if ($stmt_update->execute()) {
                    // สำเร็จในการอัปเดตข้อมูล
                    header("Location: basket.php?user_name=" . $user_name); // รีเดิร์กหน้าหลังจากอัปเดต
                    exit;
                } else {
                    // ไม่สามารถอัปเดตข้อมูลได้
                    echo '<div class="alert alert-danger text-center" role="alert">ไม่สามารถอัปเดตจำนวนได้</div>';
                }

                // ปิดการเชื่อมต่อกับฐานข้อมูล
                $stmt_update->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- เพิ่มลิงก์ Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="navbar">
    <div class="logo">
         <a href="home.php?user_name=<?php echo $user_name; ?>">
        <img src="css/LOGOpizza.png" alt="">
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
    <div class="container" style="margin-top: 2rem;">
        <h1>ตะกร้าสินค้า</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>สินค้า</th>
                    <th>ขนาด</th>
                    <th>ขอบ</th>
                    <th>จำนวนชิ้น</th>
                    <th>ราคารวมทั้งหมด</th>
                    <th>ลบ</th>
                    <th>ชำระเงิน</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // นำข้อมูลสินค้าในตะกร้ามาแสดง
                while ($row = $result_basket->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['item_id'] . '</td>
                            <td>' . $row['pizza_name'] . '</td>
                            <td>' . $row['size_name'] . '</td>
                            <td>' . $row['crust_name'] . '</td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="item_id" value="' . $row['item_id'] . '">
                                    <button class="btn btn-sm btn-success" name="action" value="increase">+</button>
                                    <span>' . $row['amount'] . '</span>
                                    <button class="btn btn-sm btn-danger" name="action" value="decrease">-</button>
                                </form>
                            </td>
                            <td>' . ($row['Price'] * $row['amount']) . '</td>
                            <td>
                            <!-- ปุ่มลบ -->
                                <form method="post" action="">
                                   <input type="hidden" name="item_id" value="' . $row['item_id'] . '">
                                   <button class="btn btn-sm btn-danger" name="action" value="delete" onclick="return confirm(\'คุณแน่ใจหรือไม่ที่จะลบสินค้านี้ออกจากตะกร้า?\')">ลบ</button>
                                </form>                        
                            </td>
                            <td>
                                <!-- ปุ่มชำระเงิน -->
                                <form method="post" action="">
                                    <input type="hidden" name="item_id" value="' . $row['item_id'] . '">
                                    <button type="submit" class="btn btn-primary" name="action" value="payment">ชำระเงิน</button>
                                </form>
                            </td>
                          </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

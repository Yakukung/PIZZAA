<?php
session_start();

require_once "dbconfig.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM `Order` WHERE user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>รายการการสั่งซื้อ</title>
</head>
<body>
    <div class="container">
        <h1>รายการการสั่งซื้อของคุณ</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>วันที่สั่ง</th>
                    <th>ชื่อลูกค้า</th>
                    <th>เบอร์โทร</th>
                    <th>ที่อยู่</th>
                    <th>สถานะ</th>
                    <th>สถานะการชำระเงิน</th>
                    <th>รวมราคา</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['order_id'] . '</td>';
                        echo '<td>' . $row['order_date'] . '</td>';
                        echo '<td>' . $row['order_name'] . '</td>';
                        echo '<td>' . $row['order_phone'] . '</td>';
                        echo '<td>' . $row['order_address'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td>' . $row['payment_status'] . '</td>';
                        echo '<td>' . $row['total'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="8">ไม่มีรายการการสั่งซื้อ</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

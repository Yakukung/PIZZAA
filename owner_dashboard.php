<?php
require_once "dbconfig.php";

$user_name = $_GET['user_name'];

$sql = "SELECT User.user_id, User.user_name, Position.position_name
        FROM User
        LEFT JOIN Position ON User.position_id = Position.position_id
        WHERE User.position_id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $position_name = $row['position_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - <?php echo $position_name; ?></title>
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
         <a class="btn btn-basket" href="">
             <i class="bi bi-basket3-fill"></i>
          </a>
     </div>
     <div class="nav-user">
        <a class="user-image" href="login.php">
            <i class="bi bi-person-circle"></i>
        </a>
        <a class="user-name" href="login.php"style="text-decoration: none;" >
           <h1>สวัสดี, <?php echo $user_name; ?>! <?php echo $position_name; ?></h1>
        </a>
     </div>
 </div>
        <div class="container-owner">
            <div class="row-owner justify-content-center">
                 <div class="col-12"> <!-- เปลี่ยนขนาดคอลัมน์ตามความต้องการ -->
                    <table class="table">
                      <thead>
                        <tr>
                          <!-- ชื่อตาราง -->
                          <th>ลำดับ</th>  
                          <th>ชื่อลูกค้า</th>
                          <th>ชื่อเมนู</th>
                          <th>ขนาดพิซซ่า</th>
                          <th>ขอบพิซซ่า</th>
                          <th>วันที่สั่ง</th>
                          <th>ยอดรวมทั้งหมด</th>
                          <th>สถานะการจัดส่ง</th>
                          <th>สถานะการชำระเงิน</th>
                        </tr>
                      </thead >
                      <tbody>
              
                          <?php
                            while ($val = $result->fetch_assoc()) {?>
                            <tr>
                              <td><?php echo $val['id'] ?></td>
                              <td><img src="<?php echo $val['image']; ?>" class="rounded" alt="Cinque Terre" width="150px" height="150px"></td>
                              <td><?php echo $val['firstName'] ?></td>
                              <td><?php echo $val['lastName'] ?></td>
                              <td><?php echo $val['nickName'] ?></td>
                              <btnall method="post">
                                 
                                    <td>
                                        <a class="btn btn-primary" href="show_details.php?id=<?php echo $val['id']; ?>">
                                                <i class="bi bi-eye-slash"></i> ข้อมูลเพิ่มเติม
                                        </a>

                                        <a class="btn btn-warning" href="edit_form.php?id=<?php echo $val['id']; ?>">
                                                  <i class="bi bi-pencil-square" ></i> แก้ไข
                                        </a>

                                        <a class="btn btn-danger" href="delete_conn.php?id=<?php echo $val['id']; ?>"
                                            onclick="return confirm('ยืนยันการลบข้อมูล <?php echo $val['id']; ?>')">
                                                <i class="bi bi-trash3"></i> ลบ
                                        </a>
                                    </td>
                                </btnall>
                            </tr>
                            <?php }?>
                       </tbody>
                   </table>
                   </div>
                </div>
             </div>
</body>
</html>

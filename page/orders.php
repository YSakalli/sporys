<?php
session_start();
include("../backend/connect.php");
$id = $_SESSION['id'];
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/orders.css">
    <title>Document</title>
</head>

<body>
    <section>
        <div class="containerinfo">
            <div class="info">

                <hr class="hr1">
                <hr class="hr2">
                <div style="background-color:rgb(0,180,0);" class="c1">
                    <i class="fa-solid fa-box"></i>
                    <h3>Hazırlanıyor</h3>
                </div>
                <div class="c2">
                    <i class="fa-solid fa-check"></i>
                    <h3>Kargoya Verildi</h3>
                </div>
                <div class="c3">
                    <i class="fa-solid fa-truck"></i>
                    <h3>Teslim Edildi</h3>

                </div>

            </div>
        </div>
        <div class="orders">
            <div class="ordersinfo">
                <p>Sipariş No</p>
                <p>Tarih</p>
                <p>Ürünler</p>
                <p>Toplam fiyat</p>
            </div>

            <?php
            $query = "SELECT * FROM orders WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = $row['product_id'];


                $query = "SELECT * FROM product WHERE id=?";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "i", $product_id);
                    mysqli_stmt_execute($stmt);
                    $resultproduct = mysqli_stmt_get_result($stmt);
                }
                $rowproduct = mysqli_fetch_assoc($resultproduct);
                echo ' 
                <div class="ordersbox">
                <p>' . $row['id'] . '</p>
                <p>' . $row['order_date'] . '</p>
                <p>' . $rowproduct['name'] . '</p>
                <p>' . $row['total_amount'] . '$</p>
            </div>
                ';
            }

            ?>

        </div>
    </section>
</body>

</html>
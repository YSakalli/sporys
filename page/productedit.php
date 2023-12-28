<?php
ob_start();
session_start();
include('../backend/connect.php');
if ($_SESSION['role'] != 'admin') {
    die('admin girisi gerkli');

}
$id = @$_SESSION['productid'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/productedit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <a href="admin.php">
        <i class="fa-solid fa-arrow-left"></i>
        <h1>Geri</h1>
    </a>

    <section>
        <?php
        $queryproduct = "SELECT *FROM product WHERE id='$id'";
        $result = mysqli_query($conn, $queryproduct);
        $row = mysqli_fetch_assoc($result);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $name = $_POST['name'];
            $text = $_POST['text'];
            $resim = $_POST['resim'];
            $price = $_POST['price'];
            $query = "UPDATE product SET name ='$name' ,text='$text',resim='$resim',price='$price' WHERE id='$id'";
            $result = mysqli_query($conn, $query);
            header('location: productedit.php');
        }
        ?>

        <form class="productadd" action="" method="post">

            <label for="name">Ürün Adı</label>
            <input type="text" name="name" placeholder="Ürün Adı" value="<?php echo $row['name']; ?>">
            <label for="name">Açıklama</label>
            <input type="text" name="text" placeholder="Açıklama" value="<?php echo $row['text']; ?>">
            <label for=" name">Resim Url</label>
            <input type="text" name="resim" placeholder="Resim Url" value="<?php echo $row['resim']; ?>">

            <label for=" name">Fiyatı</label>
            <input type="text" name="price" placeholder="Fiyatı" value="<?php echo $row['price']; ?>">

            <button name=" submit">Güncelle</button>

        </form>

    </section>
    <?php

    ?>
    <div class="store">
        <div class="product">
            <div class="imgbox">
                <img src="<?php echo $row['resim']; ?>" alt="">
                <div class="popup">
                </div>
            </div>
            <h3>
                <?php echo $row['name']; ?>
            </h3>
            <p>
                <?php echo $row['text']; ?>
            </p>
            <p class="price">
                <?php echo $row['price'];
                ob_end_flush();
                ?>$
            </p>
            <form action="" method="">
                <button type="submit" name="submit">Sepete Ekle</button>
            </form>
        </div>
    </div>

</body>

</html>
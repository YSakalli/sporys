<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}
include("../backend/connect.php");

$id = $_SESSION['id'];


if (isset($_POST['free'])) {
    $upd = "UPDATE users SET role='' WHERE $id";
    mysqli_query($conn, $upd);
    header('Location: ../backend/exit.php');

} elseif (isset($_POST['sub1'])) {
    $upd = "UPDATE users SET role='1. Pre' WHERE $id";
    mysqli_query($conn, $upd);
    header('Location: ../backend/exit.php');

} elseif (isset($_POST['sub2'])) {
    $upd = "UPDATE users SET role='2. Pre' WHERE $id";
    mysqli_query($conn, $upd);
    header('Location: ../backend/exit.php');
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/store.css">
</head>

<body>

    <nav>
        <a class="navlink" href="../profile.php">Anasayfa</a>
        <a class="navlink" href="#store">Magaza</a>

        <?php
        include('../backend/connect.php');
        $piece = 0;
        $selectAllProducts = "SELECT * FROM cart";
        $resultAllProducts = mysqli_query($conn, $selectAllProducts);

        while ($row = mysqli_fetch_assoc($resultAllProducts)) {
            $piece += $row['quantity'];
        }
        echo '
    <div class="cart">
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping">
                    <p>' . $piece . '</p>
                </i>
            </a>
        </div>
    ';
        ?>

    </nav>

    <div class="freemium">
        <form action="" method='POST'>
            <div class="plan">
                <img src="../img/1sub.webp" alt="">
                <span>
                    <h1>Free</h1>
                </span>
                <ul>
                    <li>icerikeri okuma</li>
                    <li>antrenman programlari</li>
                </ul>
                <input type="submit" name="free" value="Satın Al" onclick="confirmEminMisin()">
            </div>

            <div class="plan">
                <img src="../img/2sub.webp" alt="">
                <span>
                    <h1>10$</h1>
                    <p>/monthly</p>
                </span>

                <ul>
                    <li>icerikeri okuma</li>
                    <li>antrenman programlari</li>
                    <li>ozel antrenman programi</li>
                    <li>yorum yapabilme</li>
                </ul>
                <input type="submit" name="sub1" value="Satın Al" onclick="confirmEminMisin()">


            </div>
            <div class="plan">
                <img src="../img/3sub.webp" alt="">
                <span>
                    <h1>25$</h1>
                    <p>/monthly</p>
                </span>
                <ul>
                    <li>icerikeri okuma</li>
                    <li>antrenman programlari</li>
                    <li>ozel antrenman programi</li>
                    <li>yorum yapabilme</li>
                    <li>koc yardimi</li>
                    <li>7/24 soru cevap</li>
                </ul>
                <input type="submit" name="sub2" value="Satın Al" onclick="confirmEminMisin()">


            </div>
        </form>
        <h1>Store</h1>

        <?php
        include('../backend/connect.php');

        $query = "SELECT * FROM product";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row['price'];
                echo '
                    <div id="store" class="store">
                        <div class="product">
                            <div class="imgbox">
                                <img src="' . $row['resim'] . '" alt="">
                                <div class="popup">
                                </div>
                            </div>
                            <h3>' . $row['name'] . '</h3>
                            <p>' . $row['text'] . '</p>
                            <p class="price">' . $row['price'] . '$</p>
                            <form action="" method="POST">
                                <input type="hidden" name="product_id" value="' . $row['id'] . '">
                                <button type="submit" name="submit">Sepete Ekle</button>
                            </form>
                        </div>
                    </div>';
            }
        }
        if (isset($_POST['submit'])) {
            $product_id = $_POST['product_id'];

            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];

                $checkQuery = "SELECT * FROM cart WHERE user_id = '$id' AND product_id = '$product_id'";
                $checkResult = mysqli_query($conn, $checkQuery);

                if (mysqli_num_rows($checkResult) > 0) {
                    $row = mysqli_fetch_assoc($checkResult);
                    $quantity = $row["quantity"];
                    $newQuantity = $quantity + 1;
                    $newprice = $price * $newQuantity;

                    $updateQuery = "UPDATE cart SET quantity = '$newQuantity', total_amount = '$newprice' WHERE user_id = '$id' AND product_id = '$product_id'";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {
                        echo "Product quantity updated in the cart.";
                    } else {
                        echo "Error updating product quantity: " . mysqli_error($conn);
                    }
                } else {
                    $getProductQuery = "SELECT * FROM product WHERE id = '$product_id'";
                    $getProductResult = mysqli_query($conn, $getProductQuery);

                    if ($getProductResult && $productRow = mysqli_fetch_assoc($getProductResult)) {
                        $price = $productRow['price'];
                        $newprice = $price;
                        $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, total_amount) VALUES ('$id', '$product_id', '1', '$newprice')";
                        $insertResult = mysqli_query($conn, $insertQuery);

                        if ($insertResult) {
                            echo "Product added to the cart.";
                        } else {
                            echo "Error adding product to the cart: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error retrieving product information: " . mysqli_error($conn);
                    }
                }
            }
        }
        ?>


    </div>
    <script>
        function confirmEminMisin() {
            var eminMisin = confirm("Premium uyeligi aliniyor");
            return eminMisin;
        }
    </script>
</body>

</html>
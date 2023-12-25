<?php
ob_start();
session_start();
$id = @$_SESSION['id'];
$cookietotalprice = $sayac = 0;

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <nav>
        <a href="../profile.php">Anasayfa</a>
        <a href="store.php">Mağaza</a>

    </nav>

    <div class="container">
        <div class="info">
            <p>Ürüm</p>
            <p>Fiyat</p>
            <p>Miktar</p>
            <p>Toplam Fiyat</p>
        </div>

        <?php
        include("../backend/connect.php");



        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
            if (isset($_POST["submit"])) {
                $deleteid = $_POST["delete"];
                $querydelete = "DELETE FROM cart WHERE id='$deleteid'";
                $resultdelete = mysqli_query($conn, $querydelete);
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["up"])) {
            $updateid = $_POST["update"];
            $queryproduct = "UPDATE cart SET quantity = quantity + 1 WHERE id = '$updateid'";
            $queryproduct = mysqli_query($conn, $queryproduct);
            if ($queryproduct) {

                $selectquantity = "SELECT * FROM cart WHERE id = '$updateid'";
                $resultselectquantity = mysqli_query($conn, $selectquantity);

                if ($resultselectquantity) {
                    $row = mysqli_fetch_assoc($resultselectquantity);
                    $quantity = $row['quantity'];
                    $product_id = $row['product_id'];
                    $selectprice = "SELECT * FROM product WHERE id = '$product_id'";
                    $resultselectprice = mysqli_query($conn, $selectprice);
                    $row2 = mysqli_fetch_assoc($resultselectprice);
                    $price = $row2['price'];
                    $newprice = $quantity * $price;
                    $querytotal = "UPDATE cart SET total_amount = '$newprice'  WHERE id = '$updateid'";
                    $querytotal = mysqli_query($conn, $querytotal);
                }

            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["down"])) {
            $updateid = $_POST["update"];
            $down = $_POST['down'];
            $selectquantity = "SELECT * FROM cart WHERE id = '$updateid'";
            $resultselectquantity = mysqli_query($conn, $selectquantity);
            $row = mysqli_fetch_assoc($resultselectquantity);
            $quantity = $row["quantity"];

            if ($quantity > 1) {
                $queryproduct = "UPDATE cart SET quantity = quantity - 1 WHERE id = '$updateid'";
                $queryproduct = mysqli_query($conn, $queryproduct);

                if ($queryproduct) {

                    $product_id = $row['product_id'];
                    $selectprice = "SELECT * FROM product WHERE id = '$product_id'";
                    $resultselectprice = mysqli_query($conn, $selectprice);
                    $row2 = mysqli_fetch_assoc($resultselectprice);
                    $price = $row2['price'];
                    $newprice = ($quantity - 1) * $price;
                    $querytotal = "UPDATE cart SET total_amount = '$newprice'  WHERE id = '$updateid'";
                    $querytotal = mysqli_query($conn, $querytotal);
                }
            }
        }
        if (isset($_SESSION["id"])) {
            $query = "SELECT * FROM cart WHERE user_id = '$id'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row["product_id"];
                    $queryproduct = "SELECT * FROM product WHERE id = '$product_id'";
                    $resultproduct = mysqli_query($conn, $queryproduct);

                    while ($rowproduct = mysqli_fetch_assoc($resultproduct)) {
                        echo '
                    <div class="product">
                        <form class="markform" action="" method="post">
                            <input type="hidden" name="delete" value="' . $row['id'] . '">
                            <button name="submit" class="xmark">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                        <div class="imgbox">
                            <img src=" ' . $rowproduct['resim'] . '" alt="' . $rowproduct['name'] . '">
                            <div>
                                <h3>' . $rowproduct['name'] . '</h3>
                                <p>' . $rowproduct['text'] . '</p>
                            </div>
                        </div>
                        <p>' . $rowproduct['price'] . '$</p>

                        <form class="quantity" action="" method="POST">
                            <button type"submit" name="up">+</button>
                            <input type="hidden" name="update" value="' . $row['id'] . '">
                            <input type="text" value="' . $row['quantity'] . '" disabled>
                            <button type"submit" name="down">-</button >
                        </form>
                        <p>' . $row['total_amount'] . '$</p>
                    </div>';
                    }
                }
            }
        } else if (isset($_COOKIE['cart'])) {
            $existing_cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
            if (empty($existing_cart)) {
                echo '
            <div style="display:flex; flex-direction: column;" class="product">
                    <h1 style="color: rgb(40,40,40,0.5); align-self: center;">Ürün Bulunamadı</h1>
                    <a class="urungit" href="store.php">Ürün Ekle</a>
                </div>
            </div>
            ';
            } else {
                if (isset($_POST['delete'])) {
                    $deleteid = $_POST['deleteid'];
                    $index = array_search($deleteid, $existing_cart);
                    if ($index !== false) {
                        unset($existing_cart[$index]);
                    }
                    $existing_cart = array_values($existing_cart);

                    setcookie('cart', serialize($existing_cart), time() + 60 * 60 * 24, '/');
                    header('Location: cart.php');
                    exit();

                }
                if (!empty($existing_cart)) {
                    foreach ($existing_cart as $product_id) {
                        $queryproduct = "SELECT * FROM product WHERE id = '$product_id'";
                        $resultproduct = mysqli_query($conn, $queryproduct);
                        while ($rowproduct = mysqli_fetch_assoc($resultproduct)) {
                            $cookietotalprice = isset($cookietotalprice) ? $cookietotalprice + $rowproduct["price"] : $rowproduct["price"];
                            $sayac = isset($sayac) ? $sayac + 1 : 1;
                            echo '
                        <div class="product">
                            <form class="markform" action="" method="post">
                                <input type="hidden" name="deleteid" value="' . $rowproduct['id'] . '">
                                <button name="delete" class="xmark">
                                    <i class="fa-solid fa-xmark"></i>                               
                                </button>
                            </form>
                            <div class="imgbox">
                                <img src="' . $rowproduct['resim'] . '" alt="' . $rowproduct['name'] . '">
                                <div>
                                    <h3>' . $rowproduct['name'] . '</h3>
                                    <p>' . $rowproduct['text'] . '</p>
                                </div>
                            </div>
                            <p>' . $rowproduct["price"] . '$</p>
            
                            <form class="quantity" action="" method="POST">
                                <button type="submit" name="up">+</button>
                                <input type="hidden" name="update" value="">
                                <input type="text" value=""disabled>
                                <button type="submit" name="down">-</button>
                            </form>
                            <p>' . $rowproduct["price"] . '$</p>
                        </div>';

                        }
                    }
                }
            }

        } else {
            echo '
            <div style="display:flex; flex-direction: column;" class="product">
                    <h1 style="color: rgb(40,40,40,0.5); align-self: center;">Ürün Bulunamadı</h1>
                    <a class="urungit" href="store.php">Ürün Ekle</a>
                </div>
            </div>
            ';
        }
        ?>

    </div>

    <!-- Aside -->
    <aside>
        <div class="cart">
            <?php
            $totalprice = 0;
            $piece = 0;
            $selectAllProducts = "SELECT * FROM cart";
            $resultAllProducts = mysqli_query($conn, $selectAllProducts);
            if (isset($_POST["login"])) {
                header("../login.php");
                exit();
            }

            if (isset($_COOKIE["cart"])) {
                echo '
                <div class="total">
                    <h1>Ara toplam <span style="color:red;">(' . @$sayac . ' adet)</span></h1>
                    <p>' . @$cookietotalprice . '$</p>
                    <hr>
                </div>
                <div class="totalfinal">
                    <span>
                        <h1>Toplam </h1>
                        <p>(KDV dahil)</p>
                    </span>

                    <h3>' . @$cookietotalprice . '$</h3>
                </div>
                <form action="" method="post">
                    <button name="login" type="submit">Sepete Onayla</button>
                </form>
                ';
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart'])) {
                    $queryuser = "SELECT *FROM users WHERE id=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt, $queryuser)) {
                        mysqli_stmt_bind_param($stmt, "s", $id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $rowuser = mysqli_fetch_assoc($result);
                        $username = $rowuser["username"];
                        $email = $rowuser["email"];
                    }
                    $query = "SELECT * FROM cart WHERE user_id='$id'";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $quantity = $row['quantity'];
                        $product_id = $row['product_id'];
                        $totalamount = $row['total_amount'];
                        $queryinsert = "INSERT INTO orders (product_id,'user_id',quantity,total_amount,customer_name,customer_email) 
                        VALUE ('$product_id','$id','$quantity','$totalamount','$username','$email')";
                        $execute = mysqli_query($conn, $queryinsert);
                        $querydelete = "DELETE FROM cart WHERE  ";
                    }
                }
                while ($row = mysqli_fetch_assoc($resultAllProducts)) {
                    $totalprice += $row['total_amount'];
                    $piece += $row['quantity'];
                }
                echo '
                <div class="total">
                    <h1>Ara toplam <span style="color:red;">(' . $piece . ' adet)</span></h1>
                    <p>' . $totalprice . '$</p>
                    <hr>
                </div>
                <div class="totalfinal">
                    <span>
                        <h1>Toplam </h1>
                        <p>(KDV dahil)</p>
                    </span>

                    <h3>' . $totalprice . '$</h3>
                </div>
                <form action="" method="post">
                    <button type="submit" name="cart">Sepete Onayla</button>
                </form>
                ';
            }

            ob_end_flush();
            ?>
        </div>
    </aside>
</body>

</html>
<?php
ob_start();
session_start();
include("backend/connect.php");

$emailErr = $passErr = $loginErr = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty($emailErr) && empty($passErr)) {
        $query = "SELECT id, username, email, pass, role, pp FROM users WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt->bind_result($id, $username, $email, $hashed_password, $role, $pp);

        if ($stmt->fetch()) {


            if (password_verify($password, $hashed_password)) {
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["role"] = $role;

                if (isset($_COOKIE['cart'])) {
                    $existing_cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
                    foreach ($existing_cart as $product_id) {
                        echo $product_id;
                        include("backend/connect.php");

                        $getProductQuery = "SELECT * FROM product WHERE id = '$product_id'";
                        $getProductResult = mysqli_query($conn, $getProductQuery);

                        if ($getProductResult) {
                            if ($productRow = mysqli_fetch_assoc($getProductResult)) {
                                $price = $productRow['price'];
                                $newprice = $price;
                                $userquery = "SELECT *FROM cart ";
                                $insertQuery = "INSERT INTO cart (user_id, product_id, quantity, total_amount) VALUES ('$id', '$product_id', '1', '$newprice')";
                                $insertResult = mysqli_query($conn, $insertQuery);
                            }
                        }
                    }
                    setcookie('cart', '', time() - 3600);
                    header("Location: profile.php");
                    exit();
                } else {
                    header("Location: profile.php");
                    exit();
                }

                if (isset($_POST["remember"])) {
                    setcookie("id", $id, time() + (60 * 60 * 24), '/');
                }
                header("Location: profile.php");
                exit();

            } else {
                $loginErr = "Invalid password";
            }
        } else {
            $loginErr = "Email not found";
        }
    }
}
$conn->close();
ob_end_flush();

?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/login.css">
</head>

<body>
    <div id="loading">
        <h1>loading</h1>
    </div>

    <section>

        <div class="imgbox">
            <img src="/img/loginimg.jpg">
        </div>

        <div class="content">
            <a class="mainpage" href="profile.php">Ana Sayfa</a>

            <div>
                <h3>Login</h3>
            </div>

            <form action="login.php" method="POST" id="myform">

                <label for="">E-mail</label>
                <input type="email" name="email" placeholder="E-mail">
                <p class="erortext">
                    <?php echo $emailErr ?>
                </p>
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password">
                <p class="erortext">
                    <?php echo $passErr ?>
                </p>
                <div class="chb">
                    <span style="display: flex;"><input type="checkbox" name="remember"><label for="">Remember
                            me</label></span>

                    <a href="singup.php" style="position: relative; right:30px;">Singup</a>
                </div>

                <div class="btn">
                    <input type="submit" name="login" value="Sing up">
                </div>
                <p class="erortext center">
                    <?php echo $loginErr
                        ?>

                </p>
            </form>
        </div>
    </section>
    <script src="jsc/app.js"></script>
</body>

</html>
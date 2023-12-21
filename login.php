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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        body {
            box-sizing: border-box;
            font-family: "Poppins";
            margin: 0;
            padding: 0;
            height: 101vh;
            overflow: hidden;
        }

        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            background-color: #fff;
            z-index: 99999;
        }

        #loading h1 {
            position: absolute;
            height: 130px;
            width: 130px;
            font-size: 20px;
            border-radius: 60%;
            border: 3px rgb(91, 91, 91) solid;
            text-align: center;
            line-height: 130px;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        #loading h1::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: -3px;
            left: -3px;
            border-radius: 50%;
            border: 3px transparent solid;
            border-top: 3px red solid;
            border-right: 3px red solid;
            animation: animate 2s linear infinite;
        }

        @keyframes animate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        section {
            position: relative;
            display: flex;
            width: 100%;
            height: 100%;
        }

        section .imgbox {
            position: relative;
            width: 50%;
            height: 100%;
        }

        section .imgbox img {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        section .imgbox::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 99, 71, 0.3);
            z-index: 1;
            mix-blend-mode: screen;
        }


        .content {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 50%;
            height: 100%;
        }

        .content form {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 50%;
        }

        section .content h3 {
            position: relative;
            display: flex;
            letter-spacing: 2px;
            color: #a5a5a5;
            font-size: 2rem;
            border-bottom: 3px tomato solid;
        }

        section .content label {
            margin: 10px;
            color: #a5a5a5;
            font-size: 0.9rem;
        }

        section .content form input {
            background-color: transparent;
            border-radius: 20px;
            padding: 10px 20px;
            height: 20px;
            outline: none;
            letter-spacing: 1px;
            border: 2px solid #7f7f7f;
        }


        section .content .btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;

        }

        section .content .btn input {
            width: 50%;
            height: 40px;
            border: none;
            background-color: coral;
            border-radius: 20px;
            color: white;
            font-size: 1rem;
        }

        section .content .btn:hover input {
            background-color: tomato;

        }

        section .chb {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: auto;
        }

        section .chb input {
            display: inline;
            justify-content: left;
            margin: 10px 1px 10px 10px;
        }

        section .chb a {
            text-decoration: none;
            padding: 2px 10px;
        }

        section .chb a:hover {
            border-radius: 20px;
            background-color: #f8f8f8;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }

        section .content form .erortext {
            color: red;
            margin: 0;
            padding: 0;
        }

        section .content form .erortext.center {
            display: flex;
            justify-content: center;

        }

        section .chb label {
            color: darkslateblue;
        }

        @media (max-width:768px) {
            section .imgbox {
                position: absolute;
                z-index: -1;
                width: 100%;
                height: 100%;
            }

            section {
                justify-content: center;
                align-items: center;
            }

            section .content {
                width: 60%;
                background-color: rgba(255, 255, 255, 0.7);
                border-radius: 20px;
                height: 600px;
            }

            section .content form {
                width: 60%;
            }

            section .chb {
                justify-content: center;
            }


        }

        section .content .mainpage {
            position: absolute;
            top: 20px;
            transform: translateX(-50%);
            left: 50%;
            font-size: 24px;
            text-decoration: none;
            color: #cccc;
        }
    </style>
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
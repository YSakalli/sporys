<?php
include("backend/connect.php");

$user = $email = $pass = $passtry = "";
$nameErr = $emailErr = $passErr = $passtryErr = $usersame = "";

if (isset($_POST["submit"])) {

    if (empty($_POST["username"])) {
        $nameErr = "Name is required";
    } else {
        $user = $_POST["username"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        $pass = md5($_POST["password"]);
    }

    if (empty($_POST["passwordtry"])) {
        $passtryErr = "Password is required";
    } else {
        $passtry = md5($_POST["passwordtry"]);
    }
    if ($pass != $passtry) {
        $passtryErr = "Password must be the same";
    }
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $usersame = "Zaten boyle bir hesap ";
    }
}

if (!empty($username) && !empty($email) && !empty($pass) && !empty($pass) && $pass == $passtry && mysqli_num_rows($result) == 0) {
    echo "<script> showAlert() </script>";
    $add = "INSERT INTO users (username,email,pass) VALUES('$user','$email','$pass')";
    $work = mysqli_query($conn, $add);
    sleep(3);
    header("Location: login.php");
    exit();
}
if (isset($_POST["submit"])) {

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/stylesingup.css">
</head>

<body>
    <div id="loading">
        <h1>loading</h1>
    </div>

    <section>

        <div class="alert" id="alert">
            <h3>Singup Process Successful</h3>
        </div>

        <div class="imgbox">
            <img src="/img/loginimg.jpg">
        </div>
        <div class="content">
            <a class="mainpage" href="profile.php">Ana Sayfa</a>

            <div>
                <h3>Sing up</h3>
            </div>

            <form action="singup.php" method="POST" id="myform">
                <label for="">Username</label>
                <input type="text" name="username" placeholder="Username">
                <p class="erortext">
                    <?php echo $nameErr ?>
                </p>
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
                <label for="">Password Try</label>
                <input type="password" name="passwordtry" placeholder="Password Try">
                <p class="erortext">
                    <?php echo $passtryErr ?>
                </p>
                <div class="chb">

                    <p style="font-size: 12px;">Do you already have an account?</p>

                    <a href="login.php" style="position: relative; right:30px;">Login</a>

                </div>

                <div class="btn">
                    <input type="submit" name="submit" value="Sing up" onclick="showAlert()">
                </div>
                <p class="erortext center">
                    <?php echo $usersame; ?>
                </p>

            </form>
        </div>
    </section>
    <script src="jsc/app.js"></script>

    <script>
        function showAlert() {
            var alert = document.getElementById('alert');
            alert.style.display = 'block';
            alert.classList.add('active');
        }
        setTimeout(function () {
            alert.style.display = 'none';
            alert.classList.remove('active');
        }, 2000);

    </script>";
</body>

</html>
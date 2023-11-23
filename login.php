<?php
include("connect.php");
$emailErr = $passErr = $loginErr = "";
$email = $pass = "";

if (isset($_POST["submit"])) {

    if (empty($_POST["email"])) {
        $emailErr = "E-posta adresi gereklidir";
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["password"])) {
        $passErr = "Şifre gereklidir";
    } else {
        $pass = md5($_POST["password"]);
    }

    $query = "SELECT * FROM users WHERE email = '$email'";  
    $result = mysqli_query($conn,$query);

    if ($result && mysqli_num_rows($result) > 0) {
        $userdoc = mysqli_fetch_assoc($result);
        $hash = $userdoc['pass'];
        
        if ($pass == $hash) {
            session_start();
            $_SESSION["username"] = $userdoc["username"];
            $_SESSION["email"] = $userdoc["email"];
            $_SESSION["id"] = $userdoc["id"]; 
            header("Location:profile.php");
            exit();
        } else {
            $loginErr = "Yanlış şifre";
        }
    } else {
        $loginErr = "Yanlış e-posta";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

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


        section .content .btn{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            
        }
        section .content .btn input{
            width: 50%;
            height: 40px;
            border: none;
            background-color: coral;
            border-radius: 20px;
            color: white;
            font-size: 1rem;
        }
        section .content .btn:hover input{
            background-color:tomato;
        
        }
        section .chb {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: auto;
        }
        section .chb input{
            display: inline;
            justify-content: left;
            margin: 10px 1px 10px 10px;
        }
        section .chb a{
            text-decoration: none;
            padding: 2px 10px;
        }
        section .chb a:hover{
            border-radius: 20px;
            background-color: #f8f8f8;
            box-shadow: 1px 1px 1px rgba(0,0,0,0.1);
        }
        section .content form .erortext{
            color: red;
            margin: 0;
            padding: 0;
        }
        section .content form .erortext.center{
            display: flex;
            justify-content: center;
            
        }
        section .chb label{
            color:darkslateblue;
        }
        @media (max-width:768px) {
        section .imgbox{
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
        }
        section{
            justify-content: center;
            align-items: center;
        }
        section .content{
            width: 60%;
            background-color: rgba(255, 255,255, 0.7);
            border-radius: 20px;
            height: 600px;
        }
        section .content form{
            width: 60%;
        }
        section .chb{
        justify-content: center;
        }
    }
    </style>
</head>

<body>
    <section>

        <div class="imgbox">
            <img src="/img/loginimg.jpg">
        </div>
        <div class="content">
            <div>
                <h3>Login</h3>
            </div>

            <form action="login.php" method="POST" id="myform">   
                <label for="">E-mail</label>
                <input type="email" name="email" placeholder="E-mail">
                <p class="erortext">
                <?php echo $emailErr; ?>
                </p>
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password">
                <p class="erortext">
                <?php echo $passErr; ?>
                </p>
                <div class="chb">
                    <span style="display: flex;"><input type="checkbox"><label for="">Remember me</label></span>

                    <a href="singup.php" style="position: relative; right:30px;">Singup</a>
                </div>

                <div class="btn">
                    <input type="submit" name="submit" value="Sing up">
                </div>
                <p class="erortext center">
                <?php echo $loginErr; ?>
                </p>
            </form>
        </div>
    </section>
</body>

</html>
<?php
include("connect.php");

$user = $email = $pass = $passtry ="";
$nameErr = $emailErr = $passErr = $passtryErr = $usersame = "";

if (isset($_POST["submit"])) {

    if (empty($_POST["username"])) {
        $nameErr = "Name is required";
      }else {
        $user = $_POST["username"];
      }     

    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
        }else {
        $email =$_POST["email"];
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
    if ($pass!=$passtry) {
        $passtryErr = "Password must be the same";
    }
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $usersame = "Zaten boyle bir hesap ";
}
}

    if (!empty($username)&&!empty($email)&&!empty($pass)&&!empty($pass)&&$pass==$passtry&&mysqli_num_rows($result) == 0) {
    $add = "INSERT INTO user (userName,email,pass) VALUES('$user','$email','$pass')";
    $work = mysqli_query($conn,$add);
    sleep(3);
    header("Location: login.php");
    exit();
}
 if (isset( $_POST["submit"])) {
    
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
            justify-content: center;
            width: 100%;
            height: auto;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        section .chb input{
            display: inline;
            justify-content: left;
            margin: 10px 1px 10px 10px;
        }
        section .chb a{
            text-decoration: none;
            padding: 2px 10px;
            margin-left: 50px;
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
        section .alart{
            width: 100%;
            height: 8%;
            background-color: #f8f8f8;
            position: absolute;
            top: 0;
            z-index: 100;
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
        <div class="alert"> 

        </div>
        <div class="imgbox">
            <img src="/img/loginimg.jpg">
        </div>
        <div class="content">
            <div>
                <h3>Sing up</h3>
            </div>

            <form action="singup.php" method="POST" id="myform">
                <label for="">Username</label>
                <input type="text" name="username" placeholder="Username">
                <p class="erortext">
                <?php echo $nameErr?>
                </p>
                <label for="">E-mail</label>
                <input type="email" name="email" placeholder="E-mail">
                <p class="erortext">
                <?php echo $emailErr?>
                </p>
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password">
                <p class="erortext">
                <?php echo $passErr?>
                </p>
                <label for="">Password Try</label>
                <input type="password" name="passwordtry" placeholder="Password Try">
                <p class="erortext">
                <?php echo $passtryErr?>
                </p>
                <div class="chb">
                    
                    <p style="font-size: 12px;">Do you already have an account?</p>
                    
                    <a href="login.php" style="position: relative; right:30px;">Login</a>
                    
                </div>

                <div class="btn">
                    <input type="submit" name="submit" value="Sing up">
                </div>
                <p class="erortext center">
                <?php echo $usersame;?>
                </p>

            </form>
        </div>
    </section>
    <script>

        function showAlert() {
            var alert = document.getElementById('alert');
            alert.style.display = 'block';}

        setTimeout(function(){
                alert.style.display = 'none';
            }, 3000);

    </script>
</body>

</html>
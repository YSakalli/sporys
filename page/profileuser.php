<?php
include("../backend/connect.php");

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: giris.php");
    exit();
}
$username = $_SESSION["username"];
$userID = $_SESSION["id"];
$email = $_SESSION["email"];
$usernamenew = $passwordnew = $emailnew = $password = $pass = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["submit_username"])) {
        $usernamenew = filter_var($_POST["username"], FILTER_SANITIZE_STRING);

        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $usernamenew, $userID);
        $stmt->execute();
        $stmt->close();
        header("Location: ../backend/exit.php");
        exit();
    }
    if (isset($_POST["submit_email"])) {
        $emailnew = filter_var($_POST["email"], FILTER_SANITIZE_STRING);

        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $emailnew, $userID);
        $stmt->execute();
        $stmt->close();
        header("Location: ../backend/exit.php");
        exit();
    }
    $userInputPassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $hashedPassword = password_hash($userInputPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, pass) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPasswordFromDatabase);
    $stmt->execute();
    $stmt->close();


    if (isset($_POST["submit_password"]) && password_verify($userInputPassword, $hashedPasswordFromDatabase)) {
        $passwordnew = filter_var(md5($_POST["passwordnew"]), FILTER_SANITIZE_STRING);
        $stmt = $conn->prepare("UPDATE users SET pass = ? WHERE id = ?");
        $stmt->bind_param("si", $passwordnew, $userID);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: ../backend/exit.php");
            exit();
        } else {

        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleprofileuser.css">
    <title>Document</title>

</head>

<body>
    <div class="alert">
        <h1>
            <?php echo $password ?>
        </h1>
        <h1>
            <?php echo $pass ?>
        </h1>
    </div>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose a profile picture:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Upload">
    </form>

    <form action="profileuser.php" method="POST">
        <div class="comp">
            <label for="">User Name Change </label>
            <span><input type="text" name="username" placeholder="Enter New Username"><label for=""
                    style="margin-left: 10px;">User Name:
                    <?php echo $username ?>
                </label></span>
            <input type="submit" name="submit_username" value="Uptade" class="btn">
        </div>

        <div class="comp">
            <label for="">E-mail Change</label>
            <span><input type="text" name="email" placeholder="Enter New E-mail"><label for=""
                    style="margin-left: 10px;">E-mail:
                    <?php echo $email ?>
                </label></span>
            <input type="submit" name="submit_email" value="Uptade" class="btn">
        </div>

        <div class="comp">
            <label for="">Password</label>
            <span><input type="text" name="password" placeholder="Enter Password"><label for=""
                    style="margin-left: 10px;"></label></span>
        </div>
        <div class="comp">
            <label for="">Password Change</label>
            <span><input type="text" name="passwordnew" placeholder="Enter New Password"><label for=""
                    style="margin-left: 10px;"></label></span>
            <input type="submit" name="submit_password" value="Uptade" class="btn">
        </div>

    </form>
</body>

</html>
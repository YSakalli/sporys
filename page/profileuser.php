<?php
include("../backend/connect.php");
?>
<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: giris.php");
    exit();
}
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$userID = $_SESSION["id"];

$usernamenew = $passwordnew = $emailnew = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = md5($_POST["password"]);

    if (isset($_POST["submit_username"])) {
        $usernamenew = filter_var($_POST["username"], FILTER_SANITIZE_STRING);

        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $usernamenew, $userID);
        $stmt->execute();
        $stmt->close();

        header("Location: exit.php");
        exit();
    }
    if (isset($_POST["submit_email"])) {
        $usernamenew = $_POST["email"];
        $sql = "UPDATE users SET email= '$emailnew' WHERE id=$userID";
        $query = mysqli_query($conn, $sql);
        header("Location: exit.php");
        exit();
    }
    $data = "SELECT * FROM users WHERE pass='$password'";
    $query = mysqli_query($conn, $data);



    if (isset($_POST["submit_password"])) {
        if ($data) {
            $usernamenew = $_POST["password"];
            $sql = "UPDATE users SET pass= '$passwordnew' WHERE id=$userID";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                header("Location: exit.php");
                exit();
            }

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
    <div class="alert"></div>

    <form action="profileuser.php" method="POST">
        <div class="comp">
            <label for="">User Name Change </label>
            <span><input type="text" name="username" style="width: 60%;" placeholder="Enter New Username"><label for=""
                    style="margin-left: 10px;">User Name:
                    <?php echo $username ?>
                </label></span>
            <input type="submit" name="submit_username" value="Uptade" class="btn">
        </div>

        <div class="comp">
            <label for="">E-mail Change</label>
            <span><input type="text" name="email" style="width: 60%;" placeholder="Enter New E-mail"><label for=""
                    style="margin-left: 10px;">E-mail:
                    <?php echo $email ?>
                </label></span>
            <input type="submit" name="submit_email" value="Uptade" class="btn">
        </div>

        <div class="comp">
            <label for="">Password</label>
            <span><input type="text" name="password" style="width: 60%;" placeholder="Enter Password"><label for=""
                    style="margin-left: 10px;"></label></span>
        </div>
        <div class="comp">
            <label for="">Password Change</label>
            <span><input type="text" name="passwordnew" style="width: 60%;" placeholder="Enter New Password"><label
                    for="" style="margin-left: 10px;"></label></span>
            <input type="submit" name="submit_password" value="Uptade" class="btn">
        </div>

    </form>
</body>

</html>
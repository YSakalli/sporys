<?php
namespace Verot\Upload;

require_once("../backend/class.Upload.php");

include("../backend/connect.php");

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: giris.php");
    exit();
}
$username = $_SESSION["username"];
$userID = $_SESSION["id"];
$email = $_SESSION["email"];
$usernamenew = $passwordnew = $emailnew = $password = $pass = $eror = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("SELECT pass FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($pass);
    $stmt->fetch();
    $stmt->close();

    if (isset($_POST["submit"]) && !empty($_POST["password"]) && password_verify($_POST["password"], $pass)) {

        if (empty($_POST['username'])) {
        } else {
            $usernamenew = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
            $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
            $stmt->bind_param("si", $usernamenew, $userID);
            $stmt->execute();
            $stmt->close();
            header("Location: ../backend/exit.php");
            exit();
        }

        if (empty($_POST['usernamenew'])) {
            if (empty($_POST['email'])) {
            } else {
                $emailnew = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
                $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
                $stmt->bind_param("si", $emailnew, $userID);
                $stmt->execute();
                $stmt->close();
                header("Location: ../backend/exit.php");
                exit();
            }

            if (empty($_POST['passwordnew'])) {
            } else {
                $passwordnew = $_POST["passwordnew"];
                $passwordnew = password_hash($passwordnew, PASSWORD_DEFAULT);
                $emailnew = filter_var($_POST["passwordnew"]);
                $stmt = $conn->prepare("UPDATE users SET pass = ? WHERE id = ?");
                $stmt->bind_param("si", $passwordnew, $userID);
                $stmt->execute();
                $stmt->close();
                header("Location: ../backend/exit.php");
                exit();
            }

        }
    } else {
        if (empty($_POST['passwordnew']) && empty($_POST['usernamenew']) && empty($_POST['username']) && empty($_POST['password'])) {

        } else {
            $eror = "Sifreyi dogru girin";
        }

    }
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
    <a href="../profile.php">Anasayfa</a>
    <?php
    $uploadErr = "";

    if ($_FILES) {
        $image = $_FILES['image'];

        $foo = new Upload($image);
        if ($foo != '') {
            if ($foo->uploaded) {
                $foo->file_new_name_body = 'profile';
                $foo->allowed = array('image/jpeg', 'image/png', 'image/gif');
                $foo->file_max_size = '1048576';
                $foo->process('../uploadprofile/' . $_SESSION['id']);

                if ($foo->processed) {
                    $isim = $foo->file_dst_name;
                    $stmt = $conn->prepare("UPDATE users SET pp = ? WHERE id = ?");
                    $stmt->bind_param("si", $isim, $userID);
                    $stmt->execute();
                    $stmt->close();
                    $uploadErr = 'Upload success';
                } else {
                    $uploadErr = 'Upload unsuccessful';
                }
            }
        } else {
            $uploadErr = 'Bos birakilamaz';

        }

    }
    $pp = "SELECT pp FROM users WHERE id=?";
    $stmt = $conn->prepare($pp);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $pp = $row["pp"];
    if ($row['pp'] == null) {
        $pp = '../img/profileicon.png';

    } else {
        $pp = "/uploadprofile/$userID/$pp";
    }


    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();
    ?>
    <div class='file'>
        <h5>Role:
            <?php

            if ($role == "") {
                echo 'Kullanıcı';
            } else {
                echo $role;
            }
            ?>
        </h5>
        <div class='imgbox'>
            <img src="<?php echo $pp ?>" alt="">
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file">Choose a profile picture:</label>
            <input type="file" name="image">
            <input type="submit" name="submit" value="Upload">
            <p style='color:green; font-weight:bold;'>
                <?php echo $uploadErr ?>
            </p>
        </form>
    </div>
    <div class='information'>

        <form action="profileuser.php" method="POST">
            <div class="comp">
                <p>
                    <?php echo $username ?>
                </p>
                <label for="">User Name Change </label><br>
                <span><input type="text" name="username" placeholder="Enter New Username"><label for=""
                        style="margin-left: 10px;">

                    </label></span>
            </div>

            <div class="comp">
                <p>
                    <?php echo $email ?>
                </p>
                <label for="">E-mail Change</label><br>
                <span><input type="text" name="email" placeholder="Enter New E-mail"><label for=""
                        style="margin-left: 10px;">


                    </label></span>
            </div>
            <div class="comp">
                <label for="">Password Change</label><br>
                <span><input type="password" name="passwordnew" placeholder="Enter New Password"><label for=""
                        style="margin-left: 10px;"></label></span>

            </div>
            <div class="comp">
                <label for="">Password</label><br>
                <span><input type="password" name="password" placeholder="Enter Password"><label for=""
                        style="margin-left: 10px;"></label></span>
                <p style="color:red; font-weight:bold;">
                    <?php echo $eror ?>
                </p>
            </div>

            <input type="submit" name="submit" value="Uptade" class="btn">

        </form>
    </div>
</body>

</html>
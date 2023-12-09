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
    <link rel="stylesheet" href="../style/premium.css">
</head>

<body>
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
    </div>
    <script>
        function confirmEminMisin() {
            // Kullanıcıya emin misin diye bir onay mesajı göster
            var eminMisin = confirm("Premium uyeligi aliniyor");

            // Eminse true, değilse false döndür
            return eminMisin;
        }
    </script>
</body>

</html>
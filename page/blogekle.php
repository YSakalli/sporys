<?php
$role = "";
session_start();
$role = $_SESSION["role"];

if (!isset($_SESSION['id'])) {
    header('Location:/login.php');
    exit();
}
if ($role !== 'admin') {
    die('<h1>Bu sayfaya erişim izniniz yok.</h1>');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/style/blog.css">
    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="logo">
            <a href="../profile.php">Logo</a>
        </div>
        <div class="nav">
            <a href="blogyonet.php"><i class="fa-solid fa-list-check"></i> Blog yonet</a>
            <a href="blogekle.php"><i class="fa-solid fa-plus"></i> Blog ekle</a>
            <a href="../blog.php">Bloglar</a>
        </div>
    </header>
    <!-- Header -->
    <div style="text-align: center;">
        <strong>
            <h1>Bloglar</h1>
        </strong>
    </div>
    <!-- Blogs Ekle-->
    <section class="blogekle">

        <?php
        include("../backend/connect.php");
        $tarih = date('Y-m-d H:i:s');
        if ($_POST) {
            $baslik = htmlspecialchars($_POST['baslik']);
            $yazi = nl2br(htmlspecialchars($_POST['yazi']));
            $resim = htmlspecialchars($_POST['resim']);
            $turu = htmlspecialchars($_POST['turu']);
            if (empty($baslik) && empty($yazi) && empty($resim)) {
                echo "<p> Lutfen Bos Gecmeyin</p>";
            } else {
                $veriekle = "INSERT INTO blogs (baslik,yazi,tarih,resim,turu) VALUES ('$baslik','$yazi','$tarih','$resim','$turu')";
                $query = mysqli_query($conn, $veriekle);
            }
        }
        ?>
        <form action="" method="POST">

            <label for="">baslik</label>
            <input type="text" placeholder="Baslik" name="baslik">
            <textarea style="white-space: pre-wrap;" name="yazi" id="" cols="30" rows="10"></textarea>
            <label for="">Resim Link Ekle:</label>
            <input type="text" name="resim">
            <input list="turler" id="renkSecimi" name="turu" autocomplete="off">
            <datalist id="turler">
                <option value="saglik">
                <option value="beslenme">
                <option value="antrenman">
                <option value="supplement">
            </datalist>
            <input type="submit" name="submit" value="Gonder">

        </form>

    </section>

    <script>
        document.addEventListener('input', function (e) {
            if (e.target.tagName.toLowerCase() === 'textarea') {
                e.target.style.height = 'auto';
                e.target.style.height = (e.target.scrollHeight) + 'px';
            }
        });
    </script>
</body>

</html>
<?php
$role = "";
session_start();
$role = $_SESSION["role"];

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
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
    <link rel="stylesheet" href="blog.css">
    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="logo">
            <a href="profile.php">Logo</a>
        </div>
        <div class="nav">
            <a href="blogyonet.php">Blog yonet</a>
            <a href="blogekle.php">Blog ekle</a>
            <a href="blog.php">Bloglar</a>
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
        include 'connect.php';
        $tarih = date('Y-m-d H:i:s');
        if ($_POST) {
            $baslik = htmlspecialchars($_POST['baslik']);
            $yazi = nl2br(htmlspecialchars($_POST['yazi']));
            $resim = htmlspecialchars($_POST['resim']);

            if (empty($baslik) && empty($yazi) && empty($resim)) {
                echo "<p> Lutfen Bos Gecmeyin</p>";
            } else {
                $veriekle = "INSERT INTO blogs (baslik,yazi,tarih,resim) VALUES ('$baslik','$yazi','$tarih','$resim')";
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
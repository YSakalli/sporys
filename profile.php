<?php
session_start();
$user = $_SESSION["username"];

if (!isset($_SESSION['id'])) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>

</head>

<body>
    <!-- NavBar -->
    <header class="header">
        <div>
            <a href="profile.php" class="logo">Logo</a>
        </div>
        <nav class="navbar">
            <a href="profile.php">Ana Sayfa</a>
            <a href="blog.php">Blog</a>
            <a href="antrenman.html">Antrenman</a>
        </nav>
        <!-- Profile -->
        <div class="profile">
            <h3 style='color: aliceblue; margin-right: 10px;'>
                <?php echo $user ?>
            </h3>
            <img src="img/profileicon.png" alt="">
            <div class="profileactive">
                <h3>Profile <i class="fa-solid fa-chevron-down"></i></h3>

                <div class="downmenu">
                    <a href="profileuser.php">Profile</a>
                    <a href="">Blog</a>
                    <a href="exit.php">Logout</a>
                </div>
            </div>
        </div>

    </header>
    <!-- Banner -->

    <section class="banner">
        <div class="content">
            <h3>Forma Girmek Mi İstiyorsun.</h3>
            <p><span style="border-bottom: tomato 2px solid;">Forma girmenin en iyi zamanı</span> Bloglar ve
                size özel
                anrenmanlar ile
                <br>hemen şimdi forma gir
            </p>
            <button type="button" class="btn">Şimdi Forma Gir</button>
        </div>
    </section>
    <!-- Cards -->
    <section class="container">
        <div class="card">
            <div class="imgbox">
                <h3>Calori Hesaplama</h3>
                <img src="img/calori.jpg" alt="">
            </div>
            <div class="content">
                <h3 class="head">Calori'ni Hesapla</h3>
                <p class="lead">Günlük tüketmen gereken Protein, Yağ ve Karbonhidratı hesapla</p>
                <a href="calori.php" class="btn">Hesapla</a>
            </div>
        </div>
        <div class="card">
            <div class="imgbox">
                <h3 style="left: 70px;">Blog Yazıları</h3>
                <img src="img/blog.png" alt="">
            </div>
            <div class="content">
                <h3 class="head">Blog Yazılarını Oku</h3>
                <p class="lead">Spor, Sağlık, supplementler içerikler hakkında bilimsel bloglar okuyabilirsiniz.</p>
                <a href="blog.html" class="btn">Hesapla</a>
            </div>
        </div>
        <div class="card">
            <div class="imgbox">
                <h3>Anrenmal Programı</h3>
                <img src="img/antrenman.jpg" alt="">
            </div>
            <div class="content">
                <h3 class="head">Örnek Anrenmanlar</h3>
                <p class="lead">Kendinize uygun örnek antrenman programları incelıyebılırsınız</p>
                <a href="antrenman.html">Hesapla</a>
            </div>
        </div>

    </section>
    <!-- Info Cards -->
    <div class="infocards">
        <div class="card">
            <img src="img/dogrulanmis.png" alt="" style="width: 100px;">
            <h3>Blog Yazilarimiz hepsi bilimsel makalerler ile desteklidir</h3>
        </div>
        <div class="card">
            <img src="img/carikaturanrenman.png" style="width: 250px;" alt="">
            <h3>Kendinize uygun antrenman secenekleri ile kendinizi gelistirin </h3>
        </div>
        <div class=" card">
            <img src="img/slim.png" style="width: 150px; " alt="">
            <h3>forma girmenize ve daha saglikli olmaniza yardimci olacagiz</h3>
        </div>
    </div>
    <!-- Footer -->
    <footer>
        <div class=" footercolm">
            <h2>Sosyal Medya</h2>
            <div class="socialmadia">
                <span>
                    <h3><a href=""><i class="fa-brands fa-instagram"></i> Instagram</a></h3>
                </span>
                <span>

                    <h3><a href=""><i class="fa-brands fa-github"></i> Github</a></h3>
                </span>
                <span>

                    <h3><a href=""><i class="fa-brands fa-linkedin"></i> Linkedin</a></h3>
                </span>
                <span>

                    <h3><a href=""><i class="fa-solid fa-blog"></i></a> Blog</h3>
                </span>
            </div>
        </div>
        <div class="footercolm">
            <h3>Hizmetler</h3>
            <a href="">Web Site tasarimi</a>
            <a href="">Sosyal Medya Yonetimi</a>
            <a href="">Mobil Uygulama Gelistirme</a>
            <a href="">Grafik Tasarim Hizmetleri</a>
        </div>
        <div class="footercolm">
            <h3>Kurumsal</h3>
            <a href="">Iletisim</a>
            <a href="">Blog</a>
            <a href="">Gizlilik Politikasi</a>
            <a href="">Reklamlar</a>
        </div>
        <div class="footercolm">
            <h3>Sirket</h3>
            <a href="">Hakkimizda</a>
            <a href="">Ekibimiz</a>
            <a href="">Kariyer</a>
            <a href="">basin</a>
        </div>
    </footer>


    <script src="app.js"></script>
</body>

</html>
<?php
include("backend/connect.php");

if (isset($_COOKIE["id"])) {

    $query = "SELECT id, username, email, role FROM users WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $_COOKIE["id"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $id, $username, $email, $role);
            mysqli_stmt_fetch($stmt);

            session_start();
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            header("Location: profile.php");
            exit();
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>
    <div id="loading">
        <h1>loading</h1>
    </div>
    <!-- NavBar -->
    <header class="header">
        <div class="logo">
            <a href="index.php" class="logo">Sporys</a>
        </div>
        <nav class="navbar">
            <a href="index.php">Ana Sayfa</a>
            <a href="blog.php">Blog</a>
            <a href="antrenman.php">Antrenman</a>
            <a href="page/gallery.php">Gallery</a>
            <a href="page/store.php">Mağaza</a>

        </nav>
        <div class="sign">
            <a href="page/store.php">Premium</a>
            <a href="login.php"> <button><span></span>Giris</button></a>
        </div>
    </header>
    <!-- Banner -->
    <section class="banner">

        <div class="paylas">
            <h3>Paylas</h3>
            <a href=""><i class="fa-brands fa-github"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
        </div>

        <div class="content">
            <h3>Forma Girmek Mi İstiyorsun.</h3>
            <p><span style="border-bottom: tomato 2px solid;">Forma girmenin en iyi zamanı</span> Bloglar ve
                size özel
                anrenmanlar ile
                hemen şimdi forma gir
            </p>
            <a href="antrenman.php"><button type="button" class="btn">Şimdi Forma Gir</button></a>
        </div>
    </section>
    <!-- Cards -->
    <section class="container">
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-calculator"></i>
                <h1>Kalori</h1>
                <p>Günlük tüketmen gereken <span>Kalori</span> hesaplaman için devam et.</p>
                <a href="page/calori.php">Devam et <i class="fa-solid fa-arrow-right"></i></a>

            </div>
            <div class="card">
                <i class="fa-solid fa-dumbbell"></i>
                <h1>Antrenman</h1>
                <p>İstediğiniz <span>Antrenmanı</span> secip forma girmek için devam et.</p>
                <a href="antrenman.php">Devam et <i class="fa-solid fa-arrow-right"></i></a>

            </div>
            <div class="card">
                <i class="fa-brands fa-blogger"></i>
                <h1>Blog</h1>
                <p>İşinize yarıyabılecek <span>Blog</span> yazıları ıcın devam et.</p>
                <a href="blog.php">Devam et <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
    <!-- Info Cards -->
    <div class="infocards">
        <div class="lead">
            <h1>Who we are</h1>
            <p>Sizin en iyi halinizi ortaya koyma konusunda size yardımcı olmak için içerik üretiyoruz. </p>
            <div class="info">
                <div class="infoitem">
                    <i class="fa-solid fa-notes-medical"></i>
                    <p>Daha Sağlıklı yaşam için</p>
                </div>
                <div class="infoitem">
                    <i class="fa-solid fa-person-walking"></i>
                    <p>Daha fit olmak için</p>
                </div>
                <div class="infoitem">
                    <i class="fa-solid fa-check"></i>
                    <p>Daha doğru bilgiler için</p>
                </div>
            </div>
            <a href="antrenman.php">Hemen Başla</a>
        </div>

        <div class="imgbox">
            <img src="img/photo1.jpg" alt="">
        </div>
    </div>
    <!-- Premium -->
    <div class="freemium">
        <div class="plan">
            <img src="img/1sub.webp" alt="">
            <span>
                <h1>Free</h1>
            </span>
            <ul>
                <li>icerikeri okuma</li>
                <li>antrenman programlari</li>
            </ul>
            <a href="/page/store.php">Plan Satin al</a>
        </div>
        <div class="plan">
            <img src="img/2sub.webp" alt="">
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
            <a href="/page/store.php">Plan Satin al</a>

        </div>
        <div class="plan">
            <img src="img/3sub.webp" alt="">
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
            <a href="/page/store.php">Plan Satin al</a>

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
    <script src="jsc/app.js"></script>
</body>

</html>
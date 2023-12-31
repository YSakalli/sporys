<?php
session_start();
include("backend/connect.php");
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
function kisalt($metin, $uzunluk = 120, $noktaSonra = true)
{
    if (mb_strlen($metin) > $uzunluk) {
        $metin = mb_substr($metin, 0, $uzunluk);
        if ($noktaSonra) {
            $metin .= '...';
        }
    }
    return $metin;
}
function kisalt20($metin, $uzunluk = 20, $noktaSonra = true)
{
    if (mb_strlen($metin) > $uzunluk) {
        $metin = mb_substr($metin, 0, $uzunluk);
        if ($noktaSonra) {
            $metin .= '...';
        }
    }
    return $metin;
}
?>


<?php
$sorgu = "
SELECT
  SUM(CASE WHEN turu='saglik' AND turu IS NOT NULL THEN 1 ELSE 0 END) AS saglik_sayi,
  SUM(CASE WHEN turu='supplement' AND turu IS NOT NULL THEN 1 ELSE 0 END) AS supplement_sayi,
  SUM(CASE WHEN turu='antrenman' AND turu IS NOT NULL THEN 1 ELSE 0 END) AS antrenman_sayi,
  SUM(CASE WHEN turu='beslenme' AND turu IS NOT NULL THEN 1 ELSE 0 END) AS beslenme_sayi
FROM blogs";

$count_result = mysqli_query($conn, $sorgu);

if ($count_result) {
    $row = mysqli_fetch_assoc($count_result);

    $saglik_sayi = $row['saglik_sayi'];
    $supplement_sayi = $row['supplement_sayi'];
    $antrenman_sayi = $row['antrenman_sayi'];
    $beslenme_sayi = $row['beslenme_sayi'];
} else {
    // Sorgu başarısız ise hata mesajını alabilirsiniz
    echo "Sorgu hatası: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/blog.css">
    <title>Document</title>
</head>

<body>
    <div id="loading">
        <h1>loading</h1>
    </div>

    <!-- Header Navbar -->
    <header style=" background-color: transparent;">
        <div class="nav">
            <a href="profile.php">Anasayfa</a>
            <a href="blog.php">Bloglar</a>
        </div>

        <div class="logo">
            <a href="profile.php">
            </a>
        </div>

    </header>
    <!-- Header -->
    <div style="text-align: center;">
    </div>
    <!-- Banner -->
    <div class='banner'>

        <div class='box'></div>
        <h1>Blog</h1>
        <div class="blogphoto">
            <img src="https://kalix.club/uploads/posts/2022-12/1672301821_kalix-club-p-oboi-na-telefon-sportzal-oboi-35.jpg"
                alt="">
        </div>
    </div>
    <!-- Blogs -->
    <div class="container">
        <section class="blogs">
            <?php

            $baslik = "SELECT * FROM blogs ORDER BY id DESC";
            $query = mysqli_query($conn, $baslik);
            $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
            foreach ($rows as $row) {
                if ($row['aktif'] == '1') {
                    # code...
                    echo '<div class="blog">
            <div class="img">
                <img src="' . $row['resim'] . '">
                <p>Paylasan: ' . $row['sharing'] . ' ' . $row['tarih'] . '</p>
            </div>
            <div class="content">
                <h1>' . $row['baslik'] . '</h1>
                <p>' . kisalt($row['yazi']) . '</p>
                <a href="page/yazi.php?link=' . $row["baslik"] . '" target="_blank">Read More</a>
            </div>
        </div>';
                }
            }

            ?>

        </section>

        <aside>
            <div class="search">
                <input type="text" placeholder="Search">
                <input type="submit" value="Search">
            </div>

            <div class="categorys">

                <h1>Category</h1>

                <div class="category">
                    <i class="fa-solid fa-chevron-right"></i>
                    <h5>Beslenme</h5>
                    <p>
                        <?php echo $beslenme_sayi ?>

                    </p>
                </div>
                <div class="category">
                    <i class="fa-solid fa-chevron-right"></i>
                    <h5>Sağlık</h5>
                    <p>
                        <?php echo $saglik_sayi ?>

                    </p>
                </div>
                <div class="category">
                    <i class="fa-solid fa-chevron-right"></i>
                    <h5>Antrenman</h5>
                    <p>
                        <?php echo $antrenman_sayi ?>

                    </p>
                </div>
                <div class="category">
                    <i class="fa-solid fa-chevron-right"></i>
                    <h5>Suplument</h5>
                    <p>

                        <?php echo $supplement_sayi ?>
                    </p>
                </div>
            </div>
            <h1>Recent</h1>

            <?php
            $baslik = "SELECT * FROM blogs ORDER BY id DESC LIMIT 3";
            $query = mysqli_query($conn, $baslik);
            $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

            foreach ($rows as $row) {
                echo '<div class="recent">
                
                    <img src="' . $row['resim'] . '" alt="">
                    <span>
                        <h1>' . $row['baslik'] . '</h1>
                        <p>' . kisalt20($row['yazi']) . '</p>
                    </span>
                    <a href="page/yazi.php?link=' . $row["baslik"] . '" target="_blank"><i class="fa-solid fa-up-right-from-square"></i></a>
                </div>';
            }
            ?>
        </aside>


    </div>
    <script src="jsc/app.js"></script>
</body>

</html>
<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/blog.css">
    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="banner"></div>
        <div class="nav">
            <a href="page/blogyonet.php"><i class="fa-solid fa-list-check"></i> Blog yonet</a>
            <a href="page/blogekle.php"><i class="fa-solid fa-plus"></i> Blog ekle</a>
            <a href="blog.php">Bloglar</a>
        </div>
        <div class="logo">
            <a href="profile.php">Logo</a>
        </div>
    </header>
    <!-- Header -->
    <div style="text-align: center;">
    </div>
    <!-- Blogs -->
    <section class="blogs">
        <?php
        include("backend/connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil_id"])) {
            $id = $_POST["sil_id"];
            $sil = "DELETE FROM blogs WHERE id = '$id'";
            $sil_query = mysqli_query($conn, $sil);
        }

        $baslik = "SELECT * FROM blogs ORDER BY id DESC";
        $query = mysqli_query($conn, $baslik);

        $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($rows as $row) {
            echo '<div class="blog">
            <div class="img">
                <img src="' . $row['resim'] . '">
            </div>
            <div class="content">
                <h1>' . $row['baslik'] . '</h1>
                <p>' . kisalt($row['yazi']) . '</p>
                <a href="page/yazi.php?link=' . $row["baslik"] . '" target="_blank">Read More</a>
            </div>
        </div>';
        }
        ?>
    </section>

    <script src="jsc/app.js"></script>
</body>

</html>
<?php
session_start();
function kisalt($metin, $uzunluk = 200, $noktaSonra = true)
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
    <!-- Blogs -->
    <section class="blogs">
        <?php
        include("connect.php");

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
                <a href="yazi.php?link=' . $row["baslik"] . '" target="_blank">Read More</a>
            </div>
        </div>';
        }
        ?>
    </section>


</body>

</html>
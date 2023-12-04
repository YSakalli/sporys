<?php
function kisalt($metin, $uzunluk = 100, $noktaSonra = true)
{
    if (mb_strlen($metin) > $uzunluk) {
        $metin = mb_substr($metin, 0, $uzunluk);
        if ($noktaSonra) {
            $metin .= '...';
        }
    }
    return $metin;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/bodybuild.css">

    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="nav">
            <a href="../profile.php">Anasayfa</a>
            <a href="bodybuild.php">Programlar</a>
        </div>
        <h1>Logo</h1>

    </header>
    <!-- Header Navbar -->

    <!-- Combo Box -->
    <div class="filtre">
        <form action="" method="POST">
            <select name="filter">
                <option value="all" selected>All</option>
                <option value="ppl">Push-Pull-Leg</option>
                <option value="5x5">5x5</option>
            </select>
            <input type="submit" name="submit" value="Filtre">
        </form>
    </div>
    <!-- Combo Box -->

    <!-- Content Card Antrenman -->
    <section>
        <div class="container">
            <?php
            include("../backend/connect.php");

            $ant = "SELECT * FROM antrenman ORDER BY id DESC";

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                $selectedFilter = $_POST["filter"];

                if ($selectedFilter != "all") {
                    $ant = "SELECT * FROM antrenman WHERE turu = '$selectedFilter' ORDER BY id DESC";
                }
            }

            $query = mysqli_query($conn, $ant);
            $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

            if ($query) {
                foreach ($rows as $row) {
                    echo '
            <div class="card">
                <span>' . $row['turu'] . '</span>
                <img src="' . $row['resim'] . '" alt="">
                <h1>' . $row['baslik'] . '</h1>
                <p>' . kisalt($row['yazi']) . '</p>
                <a href="yazibb.php?link=' . $row["baslik"] . '" target="_blank">Devamını oku</a>
            </div>
        ';
                }
            }
            ?>

        </div>


        <!-- Content Card Antrenman -->
    </section>



</body>

</html>
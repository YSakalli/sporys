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
            <a href="SSS.html">SSS</a>
        </div>
        <h1>Logo</h1>
        <div class="login">
            <a href="">Giris</a>
        </div>
    </header>
    <!-- Header Navbar -->

    <!-- Combo Box -->
    <div class="filtre">
        <form action="" method="POST">
            <select>
                <option name="all">All</option>
                <option name="ppl">Push-Pull-Leg</option>
                <option name="5x5">5x5</option>
                <input type="submit" value="Filtre">
            </select>
        </form>
    </div>
    <!-- Combo Box -->

    <!-- Content Card Antrenman -->
    <section>
        <div class="container">
            <?php
            include("../backend/connect.php");

            $ant = "SELECT * FROM antrenman ORDER BY id DESC";
            $query = mysqli_query($conn, $ant);
            $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

            if ($query) {
                foreach ($rows as $row) {
                    echo '
                <div class="card">
                    <span>' . $row['turu'] . '</span>
                    <img src="' . $row['resim'] . '" alt="">
                    <h1>' . $row['baslik'] . '</h1>
                    <p>' . $row['yazi'] . '</p>
                    <a href="yazibb.php?link=' . $row["baslik"] . '" target="_blank"">Devamini oku</a>
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
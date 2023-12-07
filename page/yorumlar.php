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
    <link rel="stylesheet" href="/style/blog.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="logo">
            <a href="../profile.php">Logo</a>
        </div>
        <div class="nav">
            <?php
            if ($role == 'admin') {
                echo '<a href="blogyonet.php"><i class="fa-solid fa-list-check"></i> Blog yonet</a>
            <a href="blogekle.php"><i class="fa-solid fa-plus"></i> Blog ekle</a>
            <a href="yorumlar.php"><i class="fa-solid fa-plus"></i> Yorumlar</a>';
            }
            ?>
            <a href="../blog.php">Bloglar</a>
        </div>
    </header>
    <!-- Blogs Control -->
    <table class="table table-striped" position:relative;>
        <thead>
            <tr>
                <th>ID</th>
                <th>Yazi</th>
                <th>Tarih</th>
                <th>Aktiflik</th>
                <th>Sil</th>
            </tr>
        </thead>
        <?php
        include("../backend/connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["sil_id"])) {
                $id = $_POST["sil_id"];
                $sil = "DELETE FROM blog_comments WHERE id = '$id'";
                $sil_query = mysqli_query($conn, $sil);
            }
            if (isset($_POST["aktif_id"])) {
                $id = $_POST["aktif_id"];
                $aktif = "UPDATE blog_comments SET aktif = 1 WHERE id = '$id'";
                $aktif_query = mysqli_query($conn, $aktif);
            }
            if (isset($_POST["inaktif_id"])) {
                $id = $_POST["inaktif_id"];
                $inaktif = "UPDATE blog_comments SET aktif = 0 WHERE id = '$id'";
                $inaktif_query = mysqli_query($conn, $inaktif);
            }
        }
        $baslik = "SELECT * FROM blog_comments ORDER BY id DESC";
        $query = mysqli_query($conn, $baslik);
        $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($rows as $row) {

            $id = $row["blogid"];
            $baslik = "SELECT * FROM blogs WHERE id='$id'";
            $query = mysqli_query($conn, $baslik);
            $baslik = mysqli_fetch_assoc($query);
            $baslik = $baslik["baslik"];

            if ($row["aktif"] == 0) {
                $aktiflik = "<p style='color:red;'>inaktif</p>";
            } else {
                $aktiflik = "<p style='color:green;'>inaktif</p>";
            }
            echo '<tr>
        <td>' . $row["id"] . '</td>

        <td><a href="yazi.php?link=' . $baslik . '" target="_blank">' . $row['text'] . '</a></td>

        <td>' . $row["tarih"] . '</td>
        <td>' . $aktiflik . '</td>
        <td>
            <form method="post" action="">
                <input type="hidden" name="sil_id" value="' . $row["id"] . '">
                <input type="submit" value="sil">
            </form>
        </td>
        <td style="">
            <form method="post" action="">
                <input type="hidden" name="aktif_id" value="' . $row["id"] . '">
                <input style="width:75px; color:green; font-size:16px; text-aling:center;" type="submit" value="aktif">
            </form>
            <form method="post" action="">
                <input type="hidden" name="inaktif_id" value="' . $row["id"] . '">
                <input style="width:75px; color:red; font-size:16px; text-aling:center;" type="submit" value="inaktif">
            </form>
        </td>
    </tr>';
        }
        ?>
        <tbody>

        </tbody>
    </table>
</body>

</html>
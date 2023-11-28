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

    <title>Document</title>
</head>

<body>
    <!-- Header Navbar -->
    <header>
        <div class="logo">
            <a href="../profile.php">Logo</a>
        </div>
        <div class="nav">
            <a href="blogyonet.php">Blog yonet</a>
            <a href="blogekle.php">Blog ekle</a>
            <a href="blog.php">Bloglar</a>
        </div>
    </header>
    <!-- Blogs Control -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Baslik</th>
                <th>Tarih</th>
                <th>Sil</th>
            </tr>
        </thead>
        <?php
        include("../backend/connect.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil_id"])) {
            $id = $_POST["sil_id"];
            $sil = "DELETE FROM blogs WHERE id = '$id'";
            $sil_query = mysqli_query($conn, $sil);
        }

        $baslik = "SELECT * FROM blogs ORDER BY id DESC";
        $query = mysqli_query($conn, $baslik);

        $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($rows as $row) {
            echo '<tr>
        <td>' . $row["id"] . '</td>
        <td><a href="yazi.php?link=' . $row["baslik"] . '" target="_blank">' . $row["baslik"] . '</a></td>
        <td>' . $row["tarih"] . '</td>
        <td>
            <form method="post" action="">
                <input type="hidden" name="sil_id" value="' . $row["id"] . '">
                <input type="submit" value="sil">
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
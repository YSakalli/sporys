<?php
include("connect.php");
$link = @$_GET["link"];
$query = "SELECT * FROM blogs WHERE baslik = '$link'";
$result = mysqli_query($conn, $query);
$blog = mysqli_fetch_assoc($result);

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
    <div>
        <div style="display:flex; align-items: center; flex-direction: column; ">
            <h1>
                <?php echo $blog['baslik']; ?>
            </h1>
            <img style=" width:400px; align-items:center;" src="<?php echo $blog['resim']; ?>" alt="">
        </div>
        <div style="display:flex; justify-content:center; align-items:center; width:100%">
            <p style="width:60%; font-size:20px;">
                <?php echo $blog['yazi']; ?>
            </p>
        </div>
    </div>
    <!-- Blogs -->


</body>

</html>
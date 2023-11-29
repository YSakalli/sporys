<?php
include("../backend/connect.php");
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
    <link rel="stylesheet" href="../style/blog.css">
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
            <a href="blogyonet.php"><i class="fa-solid fa-list-check"></i> Blog yonet</a>
            <a href="blogekle.php"><i class="fa-solid fa-plus"></i> Blog ekle</a>
            <a href="../blog.php">Bloglar</a>
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
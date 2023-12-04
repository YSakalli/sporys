<?php
include("../backend/connect.php");
$link = @$_GET["link"];
$query = "SELECT * FROM antrenman WHERE baslik = '$link'";
$result = mysqli_query($conn, $query);
$antrenman = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/yazibb.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>
    <section>
        <div class="img">
            <a href="bodybuild.php">Main Page <br>
                <i class="fa-solid fa-arrow-down"></i></a>
            <img src="<?php echo $antrenman['resim']; ?>" alt="">
        </div>
        <div class="content">

            <div class="info">
                <h2>Tarih:
                    <?php echo $antrenman['tarih']; ?>
                </h2>
                <h1>
                    <?php echo $antrenman['baslik']; ?>
                </h1>
            </div>

            <h3>PPL</h3>




            <p>
                <?php echo $antrenman['yazi']; ?>
            </p>
        </div>
    </section>
</body>

</html>
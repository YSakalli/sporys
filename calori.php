<?php 
    session_start();
    $user = $_SESSION['username']
    ?>
    <?php 
    $weight= $size=$age=$vki=$format_vki="";
    $text = "";
    if (isset($_POST['submit'])) {
        $weight = $_POST['weight'];   
        $size = $_POST['size'];
        $size = $size / 100;
        $age = $_POST['age'];

        if (is_numeric($weight) && is_numeric($size)) {
            $vki = $weight / ($size * $size);
            $vki = number_format((float)$vki,2);
            $text = "Vucut kitle endeksiniz";
        } else {
            $vki = "<p>Lütfen geçerli bir ağırlık ve boy girin.</p>";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <link rel="stylesheet" href="stylecalori.css">
</head>

<body>
    <header class="">
        <div style="align-items: center;">
            <a href="index.html" class="logo">Logo</a>
        </div>
        <nav class="navbar">
            <a href="profile.php">Home</a>
            <a href="blog.html">Blog</a>
            <a href="antrenman.html">Antrenmanlar</a>
            <a href="hakkimizda.html">Hakkimizda</a>
        </nav>
        <!-- Profile -->
        <div class="profile">
            <h3><?php echo $user?></h3>
            <img src="img/profileicon.png" alt="">
            <div class="profileactive">
                <h3>Profile <i class="fa-solid fa-chevron-down"></i></h3>

                <div class="downmenu">
                    <a href="">Profile</a>
                    <a href="">Blog</a>
                    <a href="exit.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <section>
        <div class="container">
            <form action="calori.php" method='POST' >
                <!-- Gender -->
                <!-- <p>Select Gender</p> -->
                
                <!-- <div class="radiogender">
                    <input type="radio" value="radio_group" name="Man">
                    <label for="man">Man</label><br>
                    <input type="radio" value="radio_group" name="Women">
                    <label for="women">Women</label><br>
                </div> -->

                <!-- weith and size -->
                <div class="info" >

                    <span><i class="fa-solid fa-weight-scale"></i><label for="weight">Weight</label></span><br>
                    <input name="weight" type="number" class="kilo" required="required" placeholder="Weight(kg)">

                    <span><i class="fa-solid fa-ruler"></i><label for="size">Size</label></span>
                    <input name="size" type="text" placeholder="Size(cm)">

                    <span><i class="fa-solid fa-calendar-days"></i><label for="age">Age</label></span>
                    <input name="age" type="text" placeholder="Age">

                    <input class="btn" type="submit" name='submit' value="Hesapla">

                    <div class="vki"><?php echo $text?><div><?php echo $vki?></div></div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
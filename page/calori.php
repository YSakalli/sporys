<?php

$weight = $size = $age = $vki = $format_vki = $durum = "";
$text = "";
if (isset($_POST['submit'])) {
    $weight = $_POST['weight'];
    $size = $_POST['size'];
    $size = $size / 100;
    $age = $_POST['age'];

    if (is_numeric($weight) && is_numeric($size)) {
        $vki = $weight / ($size * $size);
        $vki = number_format((float) $vki, 2);
        $text = "Vucut kitle endeksiniz";
    } else {
        $vki = "<p>Lütfen geçerli bir ağırlık ve boy girin.</p>";
    }

    if ($vki <= 18.4) {
        $durum = "Zayif";
    } else if ($vki > 18.5 && $vki < 24.9) {
        $durum = "Normal";

    } else if ($vki > 25 && $vki < 29.9) {
        $durum = "Kilolu";

    } else if ($vki > 30 && $vki < 34.9) {
        $durum = "Obese";
    } else if ($vki > 35) {
        $durum = "Extrema obese";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/stylecalori.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body>


    <section>
        <div class="container">
            <form action="calori.php" method='POST'>
                <div class="info">

                    <span><i class="fa-solid fa-weight-scale"></i><label for="weight">Weight</label></span><br>
                    <input name="weight" type="number" class="kilo" required="required" placeholder="Weight(kg)">

                    <span><i class="fa-solid fa-ruler"></i><label for="size">Height</label></span>
                    <input name="size" type="text" placeholder="Height (cm)">

                    <span><i class="fa-solid fa-calendar-days"></i><label for="age">Age</label></span>
                    <input name="age" type="text" placeholder="Age">

                    <input class="btn" type="submit" name='submit' value="Hesapla">
                    <div class="vki">
                        <span>
                            <h1>Vki's: </h1>
                            <?php echo $vki ?>
                        </span>
                        <span>
                            <h1>Weight's:</h1>
                            <?php echo $durum ?>
                        </span>
                    </div>

                </div>
        </div>
        </form>
        </div>
    </section>
</body>

</html>
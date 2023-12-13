<?php
include("../backend/connect.php");
$maxFileSize = 1024 * 1024 * 5;
function compress_image($source_url, $destination_url, $quality)
{
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);
    elseif ($info['mime'] == 'image/jpg')
        $image = imagecreatefromjpeg($source_url);

    imagejpeg($image, $destination_url, $quality);

    return $destination_url;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_FILES["image"]["size"] > $maxFileSize) {
        echo "Hata: Dosya boyutu 5 MB'den büyük olamaz.";
    } else {
        $imname = $_FILES["image"]["tmp_name"];
        $source_photo = $imname;
        $namecreate = "codeconia_" . time();
        $namecreatenumber = rand(1000, 10000);
        $picname = $namecreate . $namecreatenumber;
        $finalname = $picname . ".jpeg";
        $dest_photo = '../uploads/' . $finalname;
        $compressimage = compress_image($source_photo, $dest_photo, 60);
        if ($compressimage != '') {
            $query = "INSERT INTO resimler (resim) VALUES ('$compressimage')";
            $execute = mysqli_query($conn, $query);

            if ($execute) {
                echo "Resim başarıyla eklendi.";
            } else {
                echo "Veritabanına resim eklenirken bir hata oluştu: " . mysqli_error($conn);
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/gallery.css">
    <title>Resim Yükleme Formu</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <h1>Resim Yükleme Formu</h1>
        <div>
            <label for="image">Resim Seçin:</label>
            <input type="file" name="image" required>
            <button type="submit">Yükle</button>
        </div>
    </form>
    <div class="resimler">
        <?php
        $query = "SELECT * FROM resimler";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<img src="' . $row['resim'] . '">';
        }
        ?>
    </div>
</body>

</html>
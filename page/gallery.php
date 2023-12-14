<?php
include("../backend/connect.php");
session_start();

if (isset($_SESSION["id"])) {
    $query = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];
    }
}
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
    $baslik = $_POST["baslik"];
    $yazi = $_POST["yazi"];

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
            $query = "INSERT INTO resimler (resim,userid,baslik,yazi) VALUES ('$compressimage','$id','$baslik','$yazi')";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Resim Yükleme Formu</title>
</head>

<body>
    <?php
    if (isset($_SESSION["id"])) {
        echo '
        <div class="users">
        <div class="ppbox">
            <img src="../uploadprofile/' . $row["id"] . '/' . $row["pp"] . '">
        </div>
        <span>
            <h3>
                ' . $row["username"] . '
            </h3>
            <p>' . $row["role"] . '</p>
        </span>
    </div>
        ';
    }
    ?>


    <nav>
        <a href="../profile.php">Anasayfa</a>
        <a href="../userphoto.php">Fotoğraflarım</a>
    </nav>
    <?php
    if (isset($_SESSION['id'])) {
        echo '
        <form action="" method="post" enctype="multipart/form-data">
        <h1>Resim Yükle</h1>
        <div>
            <input type="text" name="baslik" placeholder="Baslik girin" required>
            <input type="text" name="yazi" placeholder="Yorum yazin" required>
        </div>

        <input class="filec" type="file" name="image" required>


        <button type="submit">Yükle</button>

    </form>
        ';
    } else {
        echo ' 
        <a class="login" href="../login.php"><button>Giris yap</button></a>
        
        ';
    }
    ?>

    <div class="resimler">
        <?php
        $queryOuter = "SELECT * FROM resimler";
        $resultOuter = mysqli_query($conn, $queryOuter);

        while ($rowOuter = mysqli_fetch_assoc($resultOuter)) {

            $userid = $rowOuter["userid"];
            $queryInner = "SELECT * FROM users WHERE id=?";
            $stmtInner = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmtInner, $queryInner)) {
                mysqli_stmt_bind_param($stmtInner, "i", $userid);
                mysqli_stmt_execute($stmtInner);
                $resultInner = mysqli_stmt_get_result($stmtInner);
                $userdoc = mysqli_fetch_assoc($resultInner);
            }

            echo '
            <div class="imgbox">
            <i class="fa-solid fa-xmark xmark"></i>

            <div class="like">
            <i class="fa-regular fa-heart like"></i>
            <i class="fa-regular fa-thumbs-down disslike"></i>
            </div>
            <div class="profile">
                <div class="ppbox">
                    <img src="../uploadprofile/' . $userdoc["id"] . '/' . $userdoc["pp"] . '">
                
                </div>
                <div class="profile_lead"> 
                    <h1>' . $userdoc["username"] . '</h1>
                    <h6>22.11.22</h6>
                    <p>' . $rowOuter['yazi'] . '</p>
                </div>
            </div>
            <img class="resim" src="' . $rowOuter['resim'] . '">
            </div>
            ';
        }
        ?>
    </div>
    <script>
        let images = document.querySelectorAll('.imgbox');
        let xmark = document.querySelectorAll('.xmark');
        let body = document.querySelector('body');
        let profile = document.querySelectorAll('.profile');
        let like = document.querySelectorAll('.like');
        let disslike = document.querySelectorAll('.disslike');

        images.forEach(function (img) {
            img.addEventListener('click', function () {
                img.classList.add('active');
                body.classList.add('blur');
            });
        });

        xmark.forEach(function (mark) {
            mark.addEventListener('click', function (event) {
                event.stopPropagation();
                let imgBox = mark.closest('.imgbox');
                imgBox.classList.remove('active');
                body.classList.remove('blur');

            });
        });

        profile.forEach(function (active) {
            active.addEventListener('click', function () {
                active.classList.toggle('active');
            });
        });

        disslike.forEach(function (dl) {
            dl.addEventListener('click', function () {
                disslike.classList.toggle('active');
            });
        });
        like.forEach(function (l) {
            l.addEventListener('click', function () {
                like.classList.toggle('active');
            });
        });

    </script>
</body>

</html>
<?php
ob_start();
include("../backend/connect.php");
$kesfet = 0;
session_start();
$sessionid = @$_SESSION["id"];
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['file'])) {
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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_SESSION["id"]) && isset($_POST["like"]))) {
        $imgidby = $_POST["likeby"];
        $imgid = $_POST["imglike"];

        $queryliked = "SELECT * FROM likes WHERE liked_user = ? AND likedby_user = ? AND liked_img = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $queryliked)) {
            mysqli_stmt_bind_param($stmt, "iii", $imgidby, $sessionid, $imgid);
            mysqli_stmt_execute($stmt);
            $executeliked = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($executeliked);
            $deleteid = @$row['id'];
            if (mysqli_num_rows($executeliked) == 1) {
                $querydelete = "DELETE FROM likes WHERE id=?";
                $stmtdelete = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmtdelete, $querydelete)) {
                    mysqli_stmt_bind_param($stmtdelete, 'i', $deleteid);
                    mysqli_stmt_execute($stmtdelete);
                }

            } else {
                $queryaddlik = "INSERT INTO likes (liked_user, likedby_user, liked_img) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $queryaddlik)) {
                    mysqli_stmt_bind_param($stmt, "iii", $imgidby, $sessionid, $imgid);
                    mysqli_stmt_execute($stmt);
                }
            }


        }
    }


    ?>


    <nav>
        <a href="../profile.php">Anasayfa</a>
        <a href="../userphoto.php">Fotoğraflarım</a>
    </nav>
    <?php
    if (isset($_SESSION['id'])) {
        echo '
        <form class="upload" action="" method="post" enctype="multipart/form-data">
        <h1>Resim Yükle</h1>
        <div>
            <input type="text" name="baslik" placeholder="Baslik girin" required>
            <input type="text" name="yazi" placeholder="Yorum yazin" required>
        </div>

        <input class="filec" type="file" name="image" required>
        <button type="submit" name="file">Yükle</button>
    </form>
        ';
    } else {
        echo ' 
        <a class="login" href="../login.php"><button>Giris yap</button></a>
        ';
    }
    ?>

    <div class="resimler">
        <div class="location">
            <?php

            $querylike = "SELECT COUNT(*) AS likesrate FROM likes WHERE liked_img = ?";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $querylike)) {
                mysqli_stmt_bind_param($stmt, 'i', $imgid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $likerate = $row['likesrate'];
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['kesfet'])) {
                    $kesfet = 0;
                }
                if (isset($_POST['ozel'])) {
                    $kesfet = 1;
                }
            }
            ?>
            <form action="" method="post">
                <?php
                if ($kesfet == 0) {
                    echo '
                    <button style="background-color:#f1f1f1;" type="submit" name="kesfet">
                    Kesfet
                </button>
                ';
                } else {
                    echo '
                    <button  type="submit" name="kesfet">
                    Kesfet
                </button>
                ';
                }

                ?>
                <?php
                if (isset($_SESSION['id'])) {
                    if ($kesfet == 0) {
                        echo ' <button type="submit" name="ozel">
                    Arkadaslar
                </button>';
                    } else {
                        echo ' <button style="background-color:#f1f1f1;" type="submit" name="ozel">
                    Arkadaslar
                </button>';
                    }


                } else {
                    echo ' <button type="submit" name="ozel" disabled>
                    Arkadaslar
                </button>';
                }
                ?>
            </form>
        </div>
        <?php
        if (isset($_SESSION['id']) && $kesfet == 1) {
            $id = $_SESSION['id'];

            $query = "SELECT * FROM follows WHERE follower='$id'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 0) {
                echo ' <div class="nonefriend">
                <h1>Resim Bulunamadı</h1>
                <h2>Arkadaş edin</h2>
                    </div>';

            }
            while ($row = mysqli_fetch_assoc($result)) {
                $rowid = $row['follow'];
                $queryuser = "SELECT * FROM users WHERE id='$rowid'";
                $resultuser = mysqli_query($conn, $queryuser);

                while ($rowuser = mysqli_fetch_assoc($resultuser)) {
                    $rowid = $rowuser['id'];
                    $queryresim = "SELECT * FROM resimler WHERE userid='$rowid'";
                    $resultResim = mysqli_query($conn, $queryresim);

                    while ($row = mysqli_fetch_array($resultResim)) {
                        echo '
                        <div class="imgbox">
                        <div class="close">
                            <i class="fa-solid fa-xmark xmark"></i>
                        </div>
                        <div class="rate">
            
                        <form action="" method="post">
                            <input type="hidden" name="likeby" value="' . $rowuser['id'] . '">
                            <input type="hidden" name="imglike" value="' . $row['id'] . '">
                            <button type="submit" name="like">';
                        ?>

                        <?php
                        $querylikescontrol = "SELECT * FROM likes WHERE liked_user = ? AND likedby_user='' AND liked_img=? ";
                        $stmtControl = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($stmtControl, $querylikescontrol)) {
                            mysqli_stmt_bind_param($stmtControl, 'ii', $_SESSION['id'], $rowOuter['id']);
                            mysqli_stmt_execute($stmtControl);
                            $resultlikescontrol = mysqli_stmt_get_result($stmtControl);
                        }
                        if (mysqli_num_rows($resultlikescontrol) == 1) {
                            echo '<i style="color:green;" class="fa-regular fa-heart like"></i><span>' . $likerate . '</span>';
                        } else if (mysqli_num_rows($resultlikescontrol) == 0) {
                            echo '<i style="color:green;" class="fa-regular fa-heart like"></i><span>' . $likerate . '</span>';
                        }

                        ?>

                        <?php

                        echo '
                            </button>
                        </form>
                            
                        </div>
                        <a href="user.php?user_id=' . $rowuser['id'] . '">
                            <div class="profile">
                                <div class="ppbox">
                                        <img src="../uploadprofile/' . $rowuser["id"] . '/' . $rowuser["pp"] . '">
                                </div>
                                <div class="profile_lead"> 
                                    <h1>' . $rowuser["username"] . '</h1>
                                    <h6>22.11.22</h6>
                                    <p>' . $row['yazi'] . '</p>
                                </div>
                            </div>
                        </a>
                        <img class="resim" src="' . $row['resim'] . '">
                        </div>
                        ';
                    }
                }

            }



        } else {

            $queryOuter = "SELECT * FROM resimler";
            $resultOuter = mysqli_query($conn, $queryOuter);

            $queryOuter = "SELECT * FROM resimler";
            $resultOuter = mysqli_query($conn, $queryOuter);

            while ($rowOuter = mysqli_fetch_assoc($resultOuter)) {
                $userid = $rowOuter["userid"];
                $imgid = $rowOuter["id"];

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
            <div class="close">
                <i class="fa-solid fa-xmark xmark"></i>
            </div>
            <div class="rate">

            <form action="" method="post">
                <input type="hidden" name="likeby" value="' . $userdoc['id'] . '">
                <input type="hidden" name="imglike" value="' . $rowOuter['id'] . '">
                <button type="submit" name="like">';
                ?>

                <?php
                $querylikescontrol = "SELECT * FROM likes WHERE liked_user = ? AND likedby_user='' AND liked_img=? ";
                $stmtControl = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmtControl, $querylikescontrol)) {
                    mysqli_stmt_bind_param($stmtControl, 'ii', $_SESSION['id'], $rowOuter['id']);
                    mysqli_stmt_execute($stmtControl);
                    $resultlikescontrol = mysqli_stmt_get_result($stmtControl);
                }
                if (mysqli_num_rows($resultlikescontrol) == 1) {
                    echo '<i style="color:green;" class="fa-regular fa-heart like"></i><span>' . $likerate . '</span>';
                } else if (mysqli_num_rows($resultlikescontrol) == 0) {
                    echo '<i style="color:green;" class="fa-regular fa-heart like"></i><span>' . $likerate . '</span>';
                }

                ?>

                <?php

                echo '
                </button>
            </form>
                
            </div>
            <a href="user.php?user_id=' . $userdoc['id'] . '">
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
            </a>
            <img class="resim" src="' . $rowOuter['resim'] . '">
            </div>
            ';
            }
        }

        ob_end_flush();
        ?>
    </div>
    <script>

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        let images = document.querySelectorAll('.imgbox');
        let xmark = document.querySelectorAll('.xmark');
        let body = document.querySelector('body');
        const likes = document.querySelectorAll('.like');


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
    </script>
</body>

</html>
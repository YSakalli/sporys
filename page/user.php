<?php
session_start();
include("../backend/connect.php");
$sessionid = @$_SESSION["id"];
$id = $_GET["user_id"];

$followbutton = "Follow";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style/user.css">
    <title>Document</title>
</head>

<body>
    <?php

    if (isset($_SESSION["id"])) {
        $queryfollowtrue = "SELECT * FROM follows WHERE follow ='$id' AND follower='$sessionid'";
        $resultaddfollow = mysqli_query($conn, $queryfollowtrue);
        if (mysqli_num_rows($resultaddfollow) > 0) {
            if (isset($_POST["follow"])) {
                $followbutton = "Follow";
                $queryfollowtrue = "DELETE FROM follows WHERE follow ='$id' AND follower='$sessionid'";
                $resultaddfollow = mysqli_query($conn, $queryfollowtrue);
            }
        } else {
            if (isset($_POST["follow"])) {
                $followbutton = "Following";
                $queryaddfollow = "INSERT INTO follows (follow,follower) VALUE ('$id','$sessionid')";
                $resultaddfollow = mysqli_query($conn, $queryaddfollow);
            }
        }

    }

    $queryfollow = "SELECT COUNT(*) as followerCount FROM follows WHERE follow = '$id'";
    $resultfollow = mysqli_query($conn, $queryfollow);
    if ($resultfollow) {
        $rowFollow = mysqli_fetch_assoc($resultfollow);
        $followCount = $rowFollow['followerCount'];
    }
    $queryfollower = "SELECT COUNT(*) as followerCount FROM follows WHERE follower = '$id'";
    $queryfollower = mysqli_query($conn, $queryfollower);
    if ($queryfollower) {
        $rowFollower = mysqli_fetch_assoc($queryfollower);
        $followerCount = $rowFollower['followerCount'];
    }
    $queryuser = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $queryuser);
    $rowuser = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) == 0) {
        die("boyle bir kullanici yok");
    } else {
        $pp = '../uploadprofile/' . $id . '/' . @$rowuser["pp"] . '';

        echo '
    <div class="profile">
        <div class="ppbox">
            <img src="' . $pp . '" alt="">
        </div>

        <div class="rate">
            <h3>' . $rowuser["username"] . '</h3>
            <div>
                <h2>Follow</h2>
                <p>' . $followerCount . '</p>
            </div>
            <div>
                <h2>Followers</h2>
                <p>' . $followCount . '</p>
            </div>
        </div>
        <div class="content">
            <p>' . @$rowuser["text"] . '</p>
            <!-- Follow -->
            <form action="" method="post">
                <input type="hidden" name="follow" value="' . $id . '">
                <button name="follow" type="submit">' . $followbutton . '</button>
            </form>
            <!-- Follow -->
        </div>

    </div>';

    }

    ?>


    <div class="container">
        <div class="nav">
            <h3>Photo</h3>
            <h3>Archive</h3>
        </div>
        <div class="images">
            <?php
            if (isset($_POST["delete"])) {
                $imgid = $_POST["imgid"];
                $queryDelete = "DELETE  FROM resimler WHERE id='$imgid'";
                $resultDelete = mysqli_query($conn, $queryDelete);
            }
            if (isset($_POST["archive"])) {

            }
            if (isset($_POST["edit"])) {

            }
            $query = "SELECT * FROM resimler WHERE userid='$id'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <!-- Image -->
                        <div class="imgbox">
                            <img src="' . $row['resim'] . '" alt="">';
                    ?>
                    <?php
                    if (isset($_SESSION['id'])) {
                        $getid = $_SESSION['id'];
                        if ($id == $getid) {
                            echo '
                            <!-- there dots -->
                            <form action="" method="post">
                                <input type="hidden" value="">
                                <div class="downmenu">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                    <input type="hidden" name="imgid" value="' . $row['id'] . '">
                                    <button type="submit" name="delete">Delete</button>
                                    <button type="submit" name="archive">Archive</button>
                                    <button type="submit" name="edit">Edit</button>
                                </div>
                            </form>
                            ';
                        }
                    }

                    ?>
                    <?php


                    echo '</div>';
                }

            } else {
                echo '
                <div class="noneimg">
                <h1>Resim Bulunamadi</h1>
                <a href="gallery.php">Resim ekle</a>
            </div>
                ';
            }

            ?>

        </div>
        </form>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        let imgbox = document.querySelectorAll('.imgbox');
        imgbox.forEach(function (img) {
            img.addEventListener('click', function () {
                img.classList.toggle('active');
            });
        });

        document.addEventListener('click', function (event) {
            var target = event.target;

            if (!target.classList.contains('fa-ellipsis-vertical')) {
                var downmenus = document.querySelectorAll('.downmenu');

                downmenus.forEach(function (downmenu) {
                    downmenu.classList.remove('active');
                });
            }
        });

        let dots3 = document.querySelectorAll('.fa-ellipsis-vertical');
        let downmenus = document.querySelectorAll('.downmenu');

        dots3.forEach(function (dot) {

            dot.addEventListener('click', function () {
                downmenus.forEach(function (down) {
                    down.classList.remove('active');
                });
                event.stopPropagation();
                let downmenu = dot.closest('.downmenu');
                downmenu.classList.add('active');
            });
        });
    </script>
</body>

</html>
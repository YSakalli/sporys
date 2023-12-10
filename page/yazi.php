<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
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
    <header style="position:absolute;">
        <div class="nav">
            <?php
            if ($role == 'admin') {
                echo '<a style="text-shadow:3px 3px 10px rgba(0,0,0,0.5);" href="blogyonet.php"><i class="fa-solid fa-list-check"></i> Blog yonet</a>
            <a style="text-shadow:3px 3px 10px rgba(0,0,0,0.5);" href="blogekle.php"><i class="fa-solid fa-plus"></i> Blog ekle</a>
            <a style="text-shadow:3px 3px 10px rgba(0,0,0,0.5);" href="yorumlar.php"><i class="fa-solid fa-comment"></i> Yorumlar</a>';
            }
            ?>
            <a style="text-shadow:3px 3px 10px rgba(0,0,0,0.5);" href="../profile.php">Anasayfa</a>
            <a style="text-shadow:3px 3px 10px rgba(0,0,0,0.5);" href="../blog.php">Bloglar</a>
        </div>
    </header>

    <!-- Header -->
    <div class='main'>
        <div class="yazi">
            <h1>
                <?php echo $blog['baslik']; ?>
            </h1>
            <img src="<?php echo $blog['resim']; ?>" alt="">
        </div class="lead">
        <div style="display:flex; justify-content:center; align-items:center; width:100%">
            <p style="width:60%; font-size:20px;">
                <?php echo $blog['yazi']; ?>
            </p>
        </div>
    </div>

    <!-- Comments -->
    <div class='comments'>
        <h1 class='head'>Comments</h1>
        <?php
        if ($role == 'admin') {
            echo ' 
        <form action="" method="post">
            <input class="text" type="text" name="text" placeholder="Yorum Ekle">
            <input class="btn" type="submit" name="submit">
        </form>';
        } else if ($role == '1. Pre') {
            echo ' 
        <form action="" method="post">
            <input class="text" type="text" name="text" placeholder="Yorum Ekle">
            <input class="btn" type="submit" name="submit">
        </form>';
        } else if ($role == '2. Pre') {
            echo ' 
        <form action="" method="post">
            <input class="text" type="text" name="text" placeholder="Yorum Ekle">
            <input class="btn" type="submit" name="submit">
        </form>';
        } else if ($role == '') {
            echo ' 
        <form action="" method="post" class="disabled-form">
            <input class="text" type="text" name="text" placeholder="Yorum Ekle" disabled>
            <input class="btn" type="submit" name="submit" disabled>
        </form>';
        }
        ?>
        <?php
        // Yorum ekleme kısmı
        if (isset($_POST['submit']) && !empty($_POST['text'])) {
            $tarih = date('Y-m-d H:i:s');
            $userID = $_SESSION['id'];
            $add = "INSERT INTO blog_comments (blogid, userid, text,tarih) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($add);
            $stmt->bind_param("iiss", $blog['id'], $userID, $_POST['text'], $tarih);
            $stmt->execute();
            $stmt->close();
        }

        $query = "SELECT bc.*, u.pp, u.username FROM blog_comments bc
                  INNER JOIN users u ON bc.userid = u.id
                  WHERE bc.blogid = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $blog['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $pp = "../uploadprofile/" . $row['userid'] . '/' . $row['pp'];

            if ($row['pp'] == null) {
                $pp = "../img/profileicon.png";
            }

            $text = $row["text"];
            $tarih = $row["tarih"];
            $username = $row["username"];
            if ($row['aktif'] == '1') {
                echo '<div class="comment">
                    <div class="profile">
                        <div class="imgbox">
                            <img src="' . $pp . '" alt="">
                        </div>
                        <span>
                            <h1 class="username">' . $username . '</h1>
                            <p class="tarih">' . $tarih . '</p>
                        </span>
                    </div>
                    <p class="text">' . $text . '</p>
                </div>';
            }
        }

        ?>

    </div>

</body>

</html>
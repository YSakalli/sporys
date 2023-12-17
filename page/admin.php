<?php
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
if ($role != "admin") {
    header('Location: ../profile.php');
    exit();
}
include("../backend/connect.php");
function kisalt($metin, $uzunluk = 20, $ek = '...')
{
    $kisaltilmis_metin = mb_substr($metin, 0, $uzunluk);
    if (mb_strlen($metin) > $uzunluk) {
        $kisaltilmis_metin .= $ek;
    }

    return $kisaltilmis_metin;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/adminpanel.css">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Admin Panel</title>
</head>

<body>

    <div class="admin-panel">
        <div class="sidebar menu">
            <button class="menu-btn" onclick="toggleMenu()">☰ <p>Menu</p></button>
            <ul>
                <li onclick="showContent('blog-ekle')">Blog Ekle</li>
                <li onclick="showContent('blog-yonet')">Blog Yönet</li>
                <li onclick="showContent('yorum-yonet')">Yorum Yönet</li>
                <li onclick="showContent('product-ekle')">Ürün Ekle</li>
                <li onclick="showContent('product-yonet')">Ürün Yonet</li>


                <li><a href="../profile.php">AnaSayfa</a></li>
                <li><a href="../blog.php">Bloglar</a></li>
                <li><a href="../antrenman.php">Anternmanlar</a></li>
            </ul>
        </div>
        <div class="content">
            <div id="blog-ekle" class="content-section">
                <?php
                include("../backend/connect.php");
                $editorContent = $statusMsg = '';

                if (isset($_POST['submit'])) {
                    $editorContent = $_POST['editor'];
                    $turu = $_POST['turu'];
                    $resim = $_POST['resim'];
                    $baslik = $_POST['baslik'];
                    $tarih = date('Y-m-d H:i:s');

                    $sharing = "SELECT * FROM users where id=?";
                    $stmt = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($stmt, $sharing)) {
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION["id"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        $name = $row["username"];
                    }
                    if (!empty($editorContent)) {
                        $insert = $conn->query("INSERT INTO blogs (yazi,sharing,baslik,resim,tarih,turu) VALUES ('" . $editorContent . "', '$name',
                        '$baslik','$resim','$tarih','$turu')");
                        if ($insert) {
                            $statusMsg = "The editor content has been inserted successfully.";
                        } else {
                            $statusMsg = "Some problem occurred, please try again.";
                        }
                    } else {
                        $statusMsg = 'Please add content in the editor.';
                    }
                }
                ?>
                <form method="post" action="">
                    <input type="text" name="baslik" placeholder="Başlık">
                    <textarea name="editor" id="editor"></textarea>
                    <div>
                        <input type="text" name="resim" placeholder="Resim URL">
                        <select name="turu" id="">
                            <option value="saglik">Sağlık</option>
                            <option value="supplement">Supplement</option>
                            <option value="antrenman">Anternmanlar</option>
                            <option value="beslenme">Beslenme</option>
                        </select>
                    </div>
                    <input type="submit" name="submit" value="Gönder">
                </form>
                <script
                    src="https://cdn.tiny.cloud/1/drnotwjw8qh08bb9ivhocoh5hvnlf1mynjdx7dslrh7kpull/tinymce/6/tinymce.min.js"
                    referrerpolicy="origin"></script>
                <script>
                    tinymce.init({
                        selector: '#editor',
                        height: 500,
                        width: '100%',
                        plugins: 'advlist autolink lists link image charmap print preview anchor',
                        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
                    });
                </script>
            </div>





            <div id="blog-yonet" class="content-section">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Baslik</th>
                            <th>Paylaşan</th>
                            <th>Türü</th>
                            <th>Tarih</th>
                            <th>Aktiflik</th>
                            <th>Sil</th>
                            <th>Aktif</th>
                        </tr>
                    </thead>
                    <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil_id"])) {
                        $id = $_POST["sil_id"];
                        $sil = "DELETE FROM blogs WHERE id = '$id'";
                        $sil_query = mysqli_query($conn, $sil);
                    }
                    if (isset($_POST["aktif_id"])) {
                        $id = $_POST["aktif_id"];
                        $aktif = "UPDATE blogs SET aktif = 1 WHERE id = '$id'";
                        $aktif_query = mysqli_query($conn, $aktif);
                    }
                    if (isset($_POST["inaktif_id"])) {
                        $id = $_POST["inaktif_id"];
                        $inaktif = "UPDATE blogs SET aktif = 0 WHERE id = '$id'";
                        $inaktif_query = mysqli_query($conn, $inaktif);
                    }

                    $baslik = "SELECT * FROM blogs ORDER BY id DESC";
                    $query = mysqli_query($conn, $baslik);

                    $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

                    foreach ($rows as $row) {
                        if ($row["aktif"] == 0) {
                            $aktiflik = "<p style='color:red;'>inaktif</p>";
                        } else {
                            $aktiflik = "<p style='color:green;'>aktif</p>";
                        }
                        echo '<tr>
                        <td>' . $row["id"] . '</td>
                        <td><a href="yazi.php?link=' . $row["baslik"] . '" target="_blank">' . kisalt($row["baslik"]) . '</a></td>
                        <td>' . $row["sharing"] . '</td>

                        <td>' . $row["turu"] . '</td>
                        <td>' . $aktiflik . '</td>
                        <td>' . $row["tarih"] . '</td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="sil_id" value="' . $row["id"] . '">
                                <input type="submit" value="sil">
                            </form>
                            <td style="">
                                <form method="post" action="">
                                    <input type="hidden" name="aktif_id" value="' . $row["id"] . '">
                                    <input style="width:75px; color:green; font-size:16px; text-align:center;" type="submit" value="aktif">
                                </form>
                                <form method="post" action="">
                                    <input type="hidden" name="inaktif_id" value="' . $row["id"] . '">
                                    <input style="width:75px; color:red; font-size:16px; text-align:center;" type="submit" value="inaktif">
                                </form>
                            </td>
                        </td>
                    </tr>';
                    }
                    ?>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div id="yorum-yonet" class="content-section">

                <table class="table table-striped" position:relative;>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Yazi</th>
                            <th>Tarih</th>
                            <th>User</th>
                            <th>Aktiflik</th>
                            <th>Sil</th>
                            <th>Aktif</th>
                        </tr>
                    </thead>
                    <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST["sil_id"])) {
                            $id = $_POST["sil_id"];
                            $sil = "DELETE FROM blog_comments WHERE id = '$id'";
                            $sil_query = mysqli_query($conn, $sil);
                        }
                        if (isset($_POST["aktif_id"])) {
                            $id = $_POST["aktif_id"];
                            $aktif = "UPDATE blog_comments SET aktif = 1 WHERE id = '$id'";
                            $aktif_query = mysqli_query($conn, $aktif);
                        }
                        if (isset($_POST["inaktif_id"])) {
                            $id = $_POST["inaktif_id"];
                            $inaktif = "UPDATE blog_comments SET aktif = 0 WHERE id = '$id'";
                            $inaktif_query = mysqli_query($conn, $inaktif);
                        }
                    }
                    $blogbaslik = "SELECT * FROM blog_comments ORDER BY id DESC";
                    $query = mysqli_query($conn, $blogbaslik);
                    $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

                    foreach ($rows as $row) {

                        $id = $row["blogid"];
                        $yorumBaslik = "SELECT * FROM blogs WHERE id='$id'";
                        $query = mysqli_query($conn, $yorumBaslik);
                        $blogBaslik1 = mysqli_fetch_assoc($query);

                        if ($blogBaslik1) {
                            $blogBaslik1 = $blogBaslik1["baslik"];

                            if ($row["aktif"] == 0) {
                                $aktiflik = "<p style='color:red;'>inaktif</p>";
                            } else {
                                $aktiflik = "<p style='color:green;'>aktif</p>";
                            }

                            echo '<tr>
                                <td>' . $row["id"] . '</td>
                                <td><a href="yazi.php?link=' . $blogBaslik1 . '" target="_blank">' . kisalt($row['text']) . '</a></td>
                                <td>' . $row["tarih"] . '</td>
                                <td>ID: ' . $row["userid"] . '</td>

                                <td>' . $aktiflik . '</td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="sil_id" value="' . $row["id"] . '">
                                        <input type="submit" value="sil">
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="aktif_id" value="' . $row["id"] . '">
                                        <input style="width:75px; color:green; font-size:16px; text-align:center;" type="submit" value="aktif">
                                    </form>
                                    <form method="post" action="">
                                        <input type="hidden" name="inaktif_id" value="' . $row["id"] . '">
                                        <input style="width:75px; color:red; font-size:16px; text-align:center;" type="submit" value="inaktif">
                                    </form>
                                </td>
                            </tr>';
                        }
                    }
                    ?>
                    <tbody>

                    </tbody>
                </table>

            </div>

            <div id="product-ekle" class="content-section">
                <?php
                include("../backend/connect.php");
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $name = $_POST['name'];
                    $text = $_POST['text'];
                    $resim = $_POST['resim'];
                    $price = $_POST['price'];
                    $query = "INSERT INTO product (name,text,resim,price) VALUE ('$name','$text','$resim','$price')";
                    $result = mysqli_query($conn, $query);
                }
                ?>
                <form class="productadd" action="" method="post">
                    <label for="name">Ürün Adı</label>
                    <input type="text" name="name" placeholder="Ürün Adı">
                    <label for="name">Resim Url</label>

                    <input type="text" name="resim" placeholder="Resim Url">
                    <label for="name">Açıklama</label>

                    <input type="text" name="text" placeholder="Açıklama">
                    <label for="name">Fiyatı</label>

                    <input type="text" name="price" placeholder="Fiyatı">
                    <button name="submit">Gönder</button>

                </form>


            </div>
            <div id="product-yonet" class="content-section">
                <table class="table table-striped" position:relative;>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Açıklama</th>
                            <th>Fiyat</th>
                            <th>Aktiflik</th>
                            <th>Sil</th>
                            <th>Aktif</th>
                        </tr>
                    </thead>
                    <?php
                    include("../backend/connect.php");
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST["sil_id"])) {
                            $id = $_POST["sil_id"];
                            $sil = "DELETE FROM product WHERE id = '$id'";
                            $sil_query = mysqli_query($conn, $sil);
                        }
                        if (isset($_POST["aktif_id"])) {
                            $id = $_POST["aktif_id"];
                            $aktif = "UPDATE product SET aktif = 1 WHERE id = '$id'";
                            $aktif_query = mysqli_query($conn, $aktif);
                        }
                        if (isset($_POST["inaktif_id"])) {
                            $id = $_POST["inaktif_id"];
                            $inaktif = "UPDATE product SET aktif = 0 WHERE id = '$id'";
                            $inaktif_query = mysqli_query($conn, $inaktif);
                        }
                    }
                    $blogbaslik = "SELECT * FROM product ORDER BY id DESC";
                    $query = mysqli_query($conn, $blogbaslik);
                    $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

                    foreach ($rows as $row) {


                        if ($row["aktif"] == 0) {
                            $aktiflik = "<p style='color:red;'>inaktif</p>";
                        } else {
                            $aktiflik = "<p style='color:green;'>aktif</p>";
                        }

                        echo '<tr>
                                <td>' . $row["id"] . '</td>
                                <td>' . $row["name"] . '</td>
                                <td>' . $row["text"] . '</td>
                                <td>' . $row["price"] . '$</td>
                                <td>' . $aktiflik . '</td>

                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="sil_id" value="' . $row["id"] . '">
                                        <input type="submit" value="sil">
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="aktif_id" value="' . $row["id"] . '">
                                        <input style="width:75px; color:green; font-size:16px; text-align:center;" type="submit" value="aktif">
                                    </form>
                                    <form method="post" action="">
                                        <input type="hidden" name="inaktif_id" value="' . $row["id"] . '">
                                        <input style="width:75px; color:red; font-size:16px; text-align:center;" type="submit" value="inaktif">
                                    </form>
                                </td>
                            </tr>';
                    }
                    ?>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../jsc/admin.js"></script>
</body>

</html>
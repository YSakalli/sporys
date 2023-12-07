<?php
$role = "";
session_start();
$role = $_SESSION["role"];
$alert = "";
if (!isset($_SESSION['id'])) {
    header('Location:/login.php');
    exit();
}
if ($role !== 'admin') {
    die('<h1>Bu sayfaya erişim izniniz yok.</h1>');
}
include("../backend/connect.php");


$tarih = date('Y-m-d H:i:s');

if ($_POST) {
    $baslik = htmlspecialchars($_POST['baslik']);
    $yazi = nl2br(htmlspecialchars_decode($_POST['yazi']));
    $resim = htmlspecialchars($_POST['resim']);
    $turu = htmlspecialchars($_POST['turu']);

    if (empty($baslik) || empty($yazi) || empty($resim) || empty($turu)) {
        echo "<p>Lütfen tüm alanları doldurun.</p>";

    } else {
        $veriekle = "INSERT INTO blogs (baslik,yazi,tarih,resim,turu) VALUES ('$baslik','$yazi','$tarih','$resim','$turu')";
        $query = mysqli_query($conn, $veriekle);

        if ($query) {
            $alert = "<p>Blog başarıyla eklendi.</p>";
        } else {
            $alert = "<p>Bir hata oluştu, lütfen tekrar deneyin.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/blogekle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="../blog.php">
        <h6>Bloglar</h6>
    </a>
    <div id="alert">
        <h1>
            Blog başarıyla eklendi.
        </h1>
    </div>
    <section>
        <form action="" id="form" method="POST">

            <input type="text" placeholder="Başlık" name="baslik" required>

            <input type="hidden" id="quillContent" name="yazi" class="editor">

            <div id="editor" style='width:100%; height:400px;'></div>

            <div>
                <input type="text" name="resim" placeholder="Resim Link Ekle" required>


                <select name="turu">
                    <option value="saglik"> Sağlık</option>
                    <option value="supplement">Supplement</option>
                    <option value="antrenman">Anterenman</option>
                    <option value="beslenme"> Beslenme</option>

                </select>
            </div>
            <input type="submit" name="submit" value="Gönder" class="btn" id="submit">
        </form>
    </section>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        document.getElementById('form').addEventListener('submit', function (e) {
            e.preventDefault();

            document.getElementById('quillContent').value = quill.root.innerHTML;

            sendForm();
        });

        function sendForm() {
            var form = document.getElementById('form');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    showAlert();
                    inactive();

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            };
            xhr.send(formData);
        }

        function showAlert() {
            var alert = document.getElementById('alert');
            alert.classList.add('active');

            setTimeout(function () {
                alert.classList.remove('active');
            }, 2000);
        }

        function inactive() {
            var btn = document.getElementById('submit');
            btn.classList.add('inaktif-nesne');

            setTimeout(function () {
                btn.classList.add('inaktif-nesne');
            }, 2000);
        }

    </script>
</body>

</html>
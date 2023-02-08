<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="uploadedFileInput">
            Select file to upload:
        </label>
        <input type="file" name="uploadedFile" id="uploadedFileInput">
        <input type="submit" value="Send file" name="submit">
    </form>

<?php

if(isset($_POST['submit']))
{
    //zapisz oryginalna nazwe pliku
    $fileName = $_FILES['uploadedFile']['name'];
    //ustaw katalog do wgrywania plikow
    $targetDir = 'img/';

    //wyciagnij rozszerzenie z oryginalnej nazwy pliku
    $targetExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    //zmien wielkosc liter w rozszerzeniu na same małe litery
    $targetExtension = strtolower($targetExtension);

    //wygeneruj hash sha-256 jako nowa nazwa pliku
    $targetFileName = $fileName . hrtime(true);
    $targetFileName = hash("sha256", $targetFileName);

    //zbuduj pełną ścieżkę do pliku docelowego
    $targetUrl = $targetDir . $targetFileName . "." . $targetExtension;
    if(file_exists($targetUrl))
        die("ERROR: File with the same name already exists.");
    move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $targetUrl);
}
?>

</body>
</html>
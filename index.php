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
    //zapisz oryginalna nazwe pliku do lokalnej zmiennej
    $fileName = $_FILES['uploadedFile']['name'];
    //zapisz tymczasową nazwę pliku do lokalnej zmeinnej
    $tempFileUrl = $_FILES["uploadedFile"]["tmp_name"];
    //ustaw katalog do wgrywania plikow
    $targetDir = 'img/';

    //sprawdź typ pliku
    $imageInfo = getimagesize($tempFileUrl);
    if(!is_array($imageInfo)) {
        die("ERROR: Incorrect file format");
    }

    //zaczytaj cały obraz do stringa
    $imgString = file_get_contents($tempFileUrl);

    $gdImage = imagecreatefromstring($imgString);

    //wyciagnij rozszerzenie z oryginalnej nazwy pliku
    $targetExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    //zmien wielkosc liter w rozszerzeniu na same małe litery
    $targetExtension = strtolower($targetExtension);

    //wygeneruj hash sha-256 jako nowa nazwa pliku
    $targetFileUrl = $fileName . hrtime(true);
    $targetFileUrl = hash("sha256", $targetFileUrl);

    //zbuduj pełną ścieżkę do pliku docelowego
    $targetUrl = $targetDir . $targetFileUrl . "." . $targetExtension;
    if(file_exists($targetUrl))
        die("ERROR: File with the same name already exists.");
    

    $targetUrl = $targetDir . $targetFileUrl . ".webp";
    imagewebp($gdImage, $targetUrl);
}
?>

</body>
</html>
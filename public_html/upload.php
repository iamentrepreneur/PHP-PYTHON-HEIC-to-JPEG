<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['heicfiles'])) {
        die("Файлы не найдены.");
    }

    $uploadDir = __DIR__ . '/uploads/';
    $outputDir = __DIR__ . '/output/';

    foreach ($_FILES['heicfiles']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['heicfiles']['error'][$index] !== UPLOAD_ERR_OK) {
            echo "Ошибка загрузки файла: " . $_FILES['heicfiles']['name'][$index] . "<br>";
            continue;
        }

        $filename = basename($_FILES['heicfiles']['name'][$index]);
        $uploadPath = $uploadDir . $filename;

        if (!move_uploaded_file($tmpName, $uploadPath)) {
            echo "Не удалось сохранить файл: $filename<br>";
            continue;
        }

        // Отправляем в FastAPI
        $apiUrl = 'http://127.0.0.1:8000/convert';
        $cfile = new CURLFile($uploadPath, 'image/heic', $filename);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => $cfile]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            echo "Ошибка конвертации файла $filename: $error<br>";
            continue;
        }

        $outputFilename = pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
        $outputPath = $outputDir . $outputFilename;
        file_put_contents($outputPath, $response);

        echo "Файл $filename успешно сконвертирован: <a href=\"output/$outputFilename\" target=\"_blank\">Скачать JPEG</a><br>";
    }
}

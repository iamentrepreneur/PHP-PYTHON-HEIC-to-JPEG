<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>HEIC Конвертер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <div class="container">
        <h1>HEIC → JPEG Конвертер</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input class="form-control custom-file-input" type="file" name="heicfiles[]" multiple accept=".heic"
                       required>
            </div>
            <button type="submit" class="btn btn-primary">Конвертировать</button>
        </form>
    </div>
    </body>
</html>

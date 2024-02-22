<!DOCTYPE html>
<html>
<head>
    <title>Админ-панель</title>
</head>
<style>
    .grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 20px;
}

.grid-item {
    position: relative;
}

.grid-item img {
    width: 100%;
    height: auto;
}

.delete-button {
    position: absolute;
    bottom: 10px;
    right: 10px;
}
</style>
<body>
    <?php
    // Проверяем, была ли отправлена форма
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Обрабатываем загруженные фотографии
        $uploadDir = 'gallery-materials/'; // Директория для сохранения фотографий
        $allowedExtensions = ['jpg', 'jpeg', 'png']; // Разрешенные расширения файлов
        
        // Проверяем, есть ли загруженные файлы
        if (!empty($_FILES['files']['name'][0])) {
            // Цикл по всем загруженным файлам
            foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
                $fileName = $_FILES['files']['name'][$key];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                
                // Проверяем расширение файла
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = uniqid('', true) . '.' . $fileExtension;
                    $destination = $uploadDir . $newFileName;
                    
                    // Сохраняем файл на сервере
                    move_uploaded_file($tmpName, $destination);
                    
                    echo 'Фотография ' . $fileName . ' успешно загружена!<br>';
                } else {
                    echo 'Неверное расширение файла ' . $fileName . '! Разрешены только JPG, JPEG и PNG.<br>';
                }
            }
        } else {
            echo 'Файлы не были загружены.<br>';
        }
    }
    ?>
    <?php
    // Проверяем, была ли отправлена форма
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Проверяем, был ли отправлен запрос на удаление фотографии
        if (isset($_POST['delete'])) {
            $fileName = $_POST['delete'];
            $filePath = 'gallery-materials/' . $fileName;

            // Проверяем, существует ли файл
            if (file_exists($filePath)) {
                // Удаляем файл
                unlink($filePath);
                echo 'Фотография ' . $fileName . ' успешно удалена!<br>';
            } else {
                echo 'Фотография ' . $fileName . ' не найдена.<br>';
            }
        }
    }
    ?>
    <h1>Админ-панель</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple accept="image/*" required><br><br>
        <input type="submit" value="Загрузить">
    </form>
    <h2>Удаление фотографий</h2>
    <div class="grid-container">
        <?php
        // Получаем список файлов в папке "teest"
        $files = glob('gallery-materials/*');

        // Проверяем, есть ли файлы
        if (!empty($files)) {
            foreach ($files as $file) {
                $fileName = basename($file);
                echo '<div class="grid-item">';
                echo '<img src="'.$file.'" alt="'.$fileName.'">';
                echo '<form action="" method="post" class="delete-button">
                          <input type="hidden" name="delete" value="'.$fileName.'">
                          <input type="submit" value="Удалить">
                      </form>';
                echo '</div>';
            }
        } else {
            echo 'Нет доступных фотографий для удаления.';
        }
    ?>
</body>
</html>

<?php

/** Дополнительные функции, которые могут потребоваться */
class AddFunc
{
    //Переводим имя файла в транслит
    static function translit($str)
    {
        $rus = array(
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О',
            'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о',
            'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
        );
        $lat = array(
            'A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O',
            'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya',
            'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o',
            'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya'
        );
        return str_replace($rus, $lat, $str);
    }

    // очистить существующий файл
    static function clean_file($filename)
    {
        if (file_exists($filename)) {
            file_put_contents($filename, "");
        }
    }

    /** Упаковать файл в архив */
    static function toZip($destination, $dir)
    {
        $dir = str_replace('\\', '/', realpath($dir));

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        if (is_dir($dir) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                continue;

                $file = realpath($file);
                $file = str_replace('\\', '/', $file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($dir . '/', '', $file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($dir . '/', '', $file), file_get_contents($file));
                }
            }
        }

        return $zip->close();
    }

    /** Посчитать кол-во директорий */
    static function countDir($dir)
    {
        $i = 0;
        $dir_list = scandir($dir);
        foreach ($dir_list as $d) {
            if ($d != '.' && $d != '..') {
                $i++;
            }
        }
        return $i;
    }

    /** Копирование директорий */
    static function copydirect($source, $dest, $over = false)
    {
        if (!is_dir($dest))
        mkdir($dest);
        if ($handle = opendir($source)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $path = $source . '/' . $file;
                    if (is_file($path)) {
                        if (!is_file($dest . '/' . $file || $over))
                        if (!@copy($path, $dest . '/' . $file)) {
                            echo "('.$path.') Ошибка!!! ";
                        }
                    } elseif (is_dir($path)) {
                        if (!is_dir($dest . '/' . $file))
                        mkdir($dest . '/' . $file);
                        self::copydirect($path, $dest . '/' . $file, $over);
                    }
                }
            }
            closedir($handle);
        }
    }

    // удалить существующий файл
    static function delete_file($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    // удаление директории
    static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
 
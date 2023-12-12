<?php

namespace Sportsante86\Sapa\Outils;

class FilesManager
{
    /**
     * @return string
     */
    public static function rootDirectory()
    {
        // Change the second parameter to suit your needs
        return dirname(__FILE__, 2);
    }


    /**
     * @param $filepath string the complete path of the file
     * @return bool true on success or false on failure
     */
    public static function delete_file(string $filepath): bool
    {
        $delete_ok = unlink($filepath);

        if (!$delete_ok) {
            \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
                'An unexpected error occurred when user ' . ($_SESSION['email_connecte'] ?? "") . ':' . ($_SESSION['id_user'] ?? "") . ' attempted to delete a file',
                ['event' => 'upload_delete_error:' . ($_SESSION['email_connecte'] ?? "") . ',' . $filepath]

            );

            return false;
        }

        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . ($_SESSION['email_connecte'] ?? "") . ' deleted the file ' . $filepath,
            ['event' => 'upload_delete:' . ($_SESSION['email_connecte'] ?? "") . ',' . $filepath]
        );

        return true;
    }

    /**
     * Sauvegarde une image
     *
     * @param $image string l'image au format suivant: "data:image/png;base64,*" où * est l'image au format base64
     * @param $path string chemin du dossier au serra sauvegarder l'image
     * @param $filename string le nom du fichier sans l'extension
     * @return false|string The function returns the name of the file created (including the extension), or false on
     *     failure.
     */
    public static function save_image_from_base64($image, $path, $filename)
    {
        $image_parts = explode(";base64,", $image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_en_base64 = base64_decode($image_parts[1]);
        $file = $path . $filename . '.' . $image_type;

        $success = file_put_contents($file, $image_en_base64);
        if (!$success) {
            return false;
        }

        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . ($_SESSION['email_connecte'] ?? "") . ' uploaded the file ' . $filename . '.' . $image_type,
            ['event' => 'upload_complete:' . ($_SESSION['email_connecte'] ?? "") . ',' . $filename . '.' . $image_type]
        );

        return $filename . '.' . $image_type;
    }

    /**
     * @param string $dir
     * @return array un array de tous les fichiers contenus dans un dossier
     */
    public static function find_all_files($dir)
    {
        $root = scandir($dir);
        $result = [];
        foreach ($root as $value) {
            if ($value === '.' || $value === '..') {
                continue;
            }
            if (is_file("$dir/$value")) {
                $result[] = "$dir/$value";
                continue;
            }
            foreach (self::find_all_files("$dir/$value") as $value_) {
                $result[] = $value_;
            }
        }
        return $result;
    }

    /**
     * @param $path_file1 string the path to the first file
     * @param $path_file2 string the path to the second file
     * @return bool if the two files are equal
     */
    public static function files_equals(string $path_file1, string $path_file2): bool
    {
        $size_file1 = filesize($path_file1);
        if (is_bool($size_file1)) {
            return false;
        }
        $size_file2 = filesize($path_file2);
        if (is_bool($size_file2)) {
            return false;
        }

        if ($size_file1 !== $size_file2) {
            return false;
        }

        $sha1_file1 = sha1_file($path_file1);
        if (is_bool($sha1_file1)) {
            return false;
        }
        $sha1_file2 = sha1_file($path_file2);
        if (is_bool($sha1_file2)) {
            return false;
        }

        return $sha1_file1 === $sha1_file2;
    }
}
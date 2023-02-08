<?php

echo "Masukkan nama folder: ";

$folder = trim(fgets(STDIN));

echo "Pilih aksi: 1. Enkripsi 2. Deskripsi: ";

$aksi = trim(fgets(STDIN));

echo "Masukkan password: ";

$password = trim(fgets(STDIN));

if ($aksi == "1") {

    echo "Enkripsi file dalam folder " . $folder . "\n";

    $files = scandir($folder);

    foreach ($files as $file) {

        if ($file === '.' || $file === '..') continue;

        $file_path = $folder . '/' . $file;

        exec("openssl enc -aes-256-cbc -salt -in $file_path -out $file_path.enc -k $password");

        unlink($file_path);

    }

    echo "File utama sudah dihapus\n";

} elseif ($aksi == "2") {

    echo "Deskripsi file dalam folder " . $folder . "\n";

    $files = scandir($folder);

    foreach ($files as $file) {

        if ($file === '.' || $file === '..') continue;

        $file_path = $folder . '/' . $file;

        $path_info = pathinfo($file_path);

        if ($path_info['extension'] === "enc") {

            $decrypted_file = $path_info['dirname'] . '/' . $path_info['filename'];

            exec("openssl enc -d -aes-256-cbc -in $file_path -out $decrypted_file -k $password");

            unlink($file_path);

        }

    }

    echo "File utama sudah dihapus\n";

} else {

    echo "Aksi tidak dikenal\n";

}

?>

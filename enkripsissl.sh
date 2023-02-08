#!/bin/bash

echo "Pilih folder: "
read folder
echo "Pilih aksi: 1. Enkripsi 2. Deskripsi"
read aksi
echo "Masukkan password: "
read -s password

if [ "$aksi" == "1" ]; then
  echo "Enkripsi file dalam folder $folder"
  for file in $folder/*; do
    openssl enc -aes-256-cbc -salt -in $file -out $file.enc -k $password
    rm -f $file
  done
  echo "File utama sudah dihapus"
elif [ "$aksi" == "2" ]; then
  echo "Deskripsi file dalam folder $folder"
  for file in $folder/*.enc; do
    openssl enc -d -aes-256-cbc -in $file -out ${file%.enc} -k $password
    rm -f $file
  done
  echo "File utama sudah dihapus"
else
  echo "Aksi tidak dikenal"
fi

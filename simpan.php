<?php
$data = json_decode(file_get_contents("php://input"), true);

$file = 'data.js';

// Cek apakah file sudah ada
if (file_exists($file)) {
    // Ambil data lama
    $content = file_get_contents($file);
    $content = str_replace("const data = ", "", $content); // hapus deklarasi JS
    $content = rtrim($content, ";"); // hapus titik koma
    $data_array = json_decode($content, true);
} else {
    $data_array = [];
}

// Tambah data baru
$data_array[] = $data;

// Tulis kembali ke file
file_put_contents($file, "const data = " . json_encode($data_array, JSON_PRETTY_PRINT) . ";");

echo "Data berhasil disimpan!";

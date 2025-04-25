<?php
$dataFile = 'data.js';
$rawData = file_exists($dataFile) ? file_get_contents($dataFile) : "const data = [];";
$jsonData = str_replace(["const data = ", ";"], "", $rawData);
$data = json_decode($jsonData, true);

// Ambil data dari request
$input = json_decode(file_get_contents("php://input"), true);
$action = $input['action'] ?? null;
$index = $input['index'] ?? -1;

if ($action === 'delete' && isset($data[$index])) {
    array_splice($data, $index, 1);
} elseif ($action === 'edit' && isset($data[$index])) {
    $data[$index] = $input['item'];
} else {
    echo json_encode(['status' => 'gagal']);
    exit;
}

// Simpan kembali
file_put_contents($dataFile, "const data = " . json_encode($data, JSON_PRETTY_PRINT) . ";");

echo json_encode(['status' => 'ok']);

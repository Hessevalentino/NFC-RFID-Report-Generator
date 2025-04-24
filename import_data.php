<?php
/**
 * NFC/RFID Report Generator
 * Import Data Script
 * 
 * Tento skript zpracovává nahraný JSON soubor a vrací data pro formulář
 */

// Kontrola, zda byl soubor nahrán
if (!isset($_FILES['dataFile']) || $_FILES['dataFile']['error'] !== UPLOAD_ERR_OK) {
    $response = [
        'success' => false,
        'message' => 'Chyba při nahrávání souboru.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Kontrola typu souboru
$fileInfo = pathinfo($_FILES['dataFile']['name']);
if ($fileInfo['extension'] !== 'json') {
    $response = [
        'success' => false,
        'message' => 'Neplatný formát souboru. Nahrajte soubor JSON.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Načtení obsahu souboru
$fileContent = file_get_contents($_FILES['dataFile']['tmp_name']);
$reportData = json_decode($fileContent, true);

// Kontrola, zda se podařilo dekódovat JSON
if ($reportData === null) {
    $response = [
        'success' => false,
        'message' => 'Neplatný formát JSON souboru.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Vrácení dat
$response = [
    'success' => true,
    'message' => 'Data byla úspěšně načtena.',
    'data' => $reportData
];
header('Content-Type: application/json');
echo json_encode($response);
exit;

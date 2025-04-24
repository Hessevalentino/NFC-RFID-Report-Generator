<?php
/**
 * NFC/RFID Report Generator
 * Export Data Script
 * 
 * Tento skript zpracovává data z formuláře a exportuje je do JSON souboru
 */

// Kontrola, zda byl formulář odeslán
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Zpracování dat z formuláře
$reportData = $_POST;

// Konverze dat do JSON formátu
$jsonData = json_encode($reportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Nastavení hlaviček pro stažení souboru
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="nfc-rfid-report-' . $reportData['reportId'] . '.json"');
header('Content-Length: ' . strlen($jsonData));

// Odeslání dat
echo $jsonData;
exit;

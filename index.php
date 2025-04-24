<?php
// NFC/RFID Report Generator
// Hlavní stránka aplikace

// Načtení potřebných souborů
require_once 'classes/ReportGenerator.php';

// Inicializace session
session_start();

// Základní nastavení
$pageTitle = "NFC/RFID Report Generator";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Print CSS -->
    <link href="assets/css/print.css" rel="stylesheet" media="print">

    <!-- Hackerský styl -->
    <style>
        body {
            font-family: "Courier New", monospace;
            background-color: #0a0a0a;
            color: #00ff00;
        }

        .container {
            background-color: #121212;
            border: 1px solid #1a1a1a;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
            padding: 20px;
        }

        .card {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-left: 3px solid #00ff00;
            border-radius: 0;
        }

        .card-header {
            background-color: #000000;
            color: #00ff00;
            border-bottom: 1px solid #333;
            font-family: "Courier New", monospace;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 0;
        }

        .card-body {
            color: #cccccc;
        }

        .form-control, .form-select {
            background-color: #0a0a0a;
            border: 1px solid #333;
            color: #00ff00;
            border-radius: 0;
        }

        .form-control:focus, .form-select:focus {
            background-color: #0a0a0a;
            border-color: #00ff00;
            box-shadow: 0 0 0 0.25rem rgba(0, 255, 0, 0.25);
            color: #00ff00;
        }

        .form-label {
            color: #00cc00;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .form-check-label {
            color: #cccccc;
        }

        .btn {
            border-radius: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: "Courier New", monospace;
            font-weight: 700;
        }

        .btn-primary {
            background-color: #000;
            border-color: #00ff00;
            color: #00ff00;
        }

        .btn-primary:hover {
            background-color: #0a0a0a;
            border-color: #00ff00;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .btn-secondary {
            background-color: #1a1a1a;
            border-color: #333;
            color: #ccc;
        }

        .btn-secondary:hover {
            background-color: #0a0a0a;
            border-color: #666;
        }

        .btn-success {
            background-color: #005500;
            border-color: #00ff00;
        }

        .btn-success:hover {
            background-color: #004400;
            border-color: #00ff00;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        .btn-info {
            background-color: #003366;
            border-color: #0099ff;
            color: #0099ff;
        }

        .btn-info:hover {
            background-color: #002244;
            border-color: #0099ff;
            color: #0099ff;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Courier New", monospace;
            color: #00ff00;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .lead {
            color: #cccccc;
            font-family: "Courier New", monospace;
        }

        .table {
            color: #cccccc;
        }

        .table th {
            background-color: #000;
            color: #00ff00;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            border-color: #333;
        }

        .table td {
            border-color: #333;
        }

        .table-bordered {
            border-color: #333;
        }

        /* Přizpůsobení pro placeholder */
        ::placeholder {
            color: #666 !important;
            opacity: 1;
        }

        /* Přizpůsobení pro scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 0;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #00ff00;
        }
    </style>
</head>
<body>
    <!-- Hlavní obsah -->
    <div class="container mt-4">
        <header class="mb-4">
            <h1><?php echo $pageTitle; ?></h1>
            <p class="lead">Nástroj pro generování analýz NFC a RFID tagů</p>
        </header>

        <div class="card mb-4">
            <div class="card-body">
                <form id="reportForm" method="post" action="preview_report.php">
                    <!-- 1.1 Základní informace o analýze -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">1. Základní informace o analýze</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="analysisDate" class="form-label">Datum analýzy</label>
                                    <input type="date" class="form-control" id="analysisDate" name="analysisDate"
                                           value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="analystName" class="form-label">Jméno analytika</label>
                                    <input type="text" class="form-control" id="analystName" name="analystName" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="reportId" class="form-label">ID reportu</label>
                                    <input type="text" class="form-control" id="reportId" name="reportId"
                                           value="<?php echo date('ymd').'-'.rand(100, 999); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="analysisType" class="form-label">Typ analýzy</label>
                                    <select class="form-select" id="analysisType" name="analysisType" required>
                                        <option value="">-- Vyberte typ --</option>
                                        <option value="NFC">NFC</option>
                                        <option value="RFID">RFID</option>
                                        <option value="Combined">Kombinovaná</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.2 Informace o testovaném tagu -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">2. Informace o testovaném tagu</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tagType" class="form-label">Typ tagu</label>
                                    <select class="form-select" id="tagType" name="tagType" required>
                                        <option value="">-- Vyberte typ --</option>
                                        <optgroup label="NFC">
                                            <option value="NFC Type 1">NFC Type 1</option>
                                            <option value="NFC Type 2">NFC Type 2</option>
                                            <option value="NFC Type 3">NFC Type 3</option>
                                            <option value="NFC Type 4">NFC Type 4</option>
                                            <option value="NFC Type 5">NFC Type 5</option>
                                        </optgroup>
                                        <optgroup label="RFID">
                                            <option value="ISO 14443-A">ISO 14443-A</option>
                                            <option value="ISO 14443-B">ISO 14443-B</option>
                                            <option value="ISO 15693">ISO 15693</option>
                                            <option value="Mifare Classic">Mifare Classic</option>
                                            <option value="Mifare DESFire">Mifare DESFire</option>
                                            <option value="EM4100">EM4100</option>
                                            <option value="HID">HID</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="manufacturer" class="form-label">Výrobce</label>
                                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" list="manufacturerList">
                                    <datalist id="manufacturerList">
                                        <option value="NXP">
                                        <option value="STMicroelectronics">
                                        <option value="Infineon">
                                        <option value="Texas Instruments">
                                        <option value="Sony">
                                        <option value="HID Global">
                                    </datalist>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="model" class="form-label">Model/označení</label>
                                    <input type="text" class="form-control" id="model" name="model">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="serialNumber" class="form-label">Sériové číslo</label>
                                    <input type="text" class="form-control" id="serialNumber" name="serialNumber">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="frequency" class="form-label">Frekvence</label>
                                    <select class="form-select" id="frequency" name="frequency">
                                        <option value="">-- Vyberte frekvenci --</option>
                                        <option value="13.56 MHz">13.56 MHz (HF)</option>
                                        <option value="125 kHz">125 kHz (LF)</option>
                                        <option value="860-960 MHz">860-960 MHz (UHF)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="memoryCapacity" class="form-label">Kapacita paměti</label>
                                    <input type="text" class="form-control" id="memoryCapacity" name="memoryCapacity" placeholder="např. 1KB">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dimensions" class="form-label">Fyzické rozměry (mm)</label>
                                    <input type="text" class="form-control" id="dimensions" name="dimensions" placeholder="např. 85.6 × 54 × 0.8">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.3 Technická specifikace -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">3. Technická specifikace</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Použité protokoly</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="protocol1" name="protocols[]" value="ISO/IEC 14443">
                                        <label class="form-check-label" for="protocol1">ISO/IEC 14443</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="protocol2" name="protocols[]" value="ISO/IEC 15693">
                                        <label class="form-check-label" for="protocol2">ISO/IEC 15693</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="protocol3" name="protocols[]" value="NDEF">
                                        <label class="form-check-label" for="protocol3">NDEF</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="protocol4" name="protocols[]" value="FeliCa">
                                        <label class="form-check-label" for="protocol4">FeliCa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="protocol5" name="protocols[]" value="MIFARE">
                                        <label class="form-check-label" for="protocol5">MIFARE</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Typ šifrování</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encryption1" name="encryption[]" value="DES">
                                        <label class="form-check-label" for="encryption1">DES</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encryption2" name="encryption[]" value="3DES">
                                        <label class="form-check-label" for="encryption2">3DES</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encryption3" name="encryption[]" value="AES">
                                        <label class="form-check-label" for="encryption3">AES</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encryption4" name="encryption[]" value="RSA">
                                        <label class="form-check-label" for="encryption4">RSA</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="encryption5" name="encryption[]" value="Žádné">
                                        <label class="form-check-label" for="encryption5">Žádné</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="supportedCommands" class="form-label">Podporované příkazy</label>
                                    <textarea class="form-control" id="supportedCommands" name="supportedCommands" rows="3"
                                              placeholder="Zadejte seznam podporovaných příkazů, jeden na řádek"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ndefRecords" class="form-label">NDEF záznamy (pro NFC)</label>
                                    <textarea class="form-control" id="ndefRecords" name="ndefRecords" rows="3"
                                              placeholder="Zadejte NDEF záznamy, pokud jsou k dispozici"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="uid" class="form-label">UID/NUID</label>
                                    <input type="text" class="form-control" id="uid" name="uid" placeholder="např. 04:A2:B3:C4:D5:E6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="atrResponse" class="form-label">ATR response</label>
                                    <input type="text" class="form-control" id="atrResponse" name="atrResponse" placeholder="např. 3B 8F 80 01 80 4F 0C A0 00 00 03 06">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.4 Bezpečnostní analýza -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">4. Bezpečnostní analýza</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vulnerabilities" class="form-label">Zjištěné zranitelnosti</label>
                                    <textarea class="form-control" id="vulnerabilities" name="vulnerabilities" rows="3"
                                              placeholder="Popište zjištěné zranitelnosti"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="securityLevel" class="form-label">Úroveň zabezpečení (1-5)</label>
                                    <div class="rating">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="securityLevel" id="security1" value="1">
                                            <label class="form-check-label" for="security1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="securityLevel" id="security2" value="2">
                                            <label class="form-check-label" for="security2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="securityLevel" id="security3" value="3">
                                            <label class="form-check-label" for="security3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="securityLevel" id="security4" value="4">
                                            <label class="form-check-label" for="security4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="securityLevel" id="security5" value="5">
                                            <label class="form-check-label" for="security5">5</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Možnosti klonování</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cloning1" name="cloning[]" value="Možné bez speciálního vybavení">
                                        <label class="form-check-label" for="cloning1">Možné bez speciálního vybavení</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cloning2" name="cloning[]" value="Možné se specializovaným vybavením">
                                        <label class="form-check-label" for="cloning2">Možné se specializovaným vybavením</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cloning3" name="cloning[]" value="Teoreticky možné">
                                        <label class="form-check-label" for="cloning3">Teoreticky možné</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="cloning4" name="cloning[]" value="Nemožné">
                                        <label class="form-check-label" for="cloning4">Nemožné</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="knownExploits" class="form-label">Známé exploity</label>
                                    <textarea class="form-control" id="knownExploits" name="knownExploits" rows="3"
                                              placeholder="Uveďte známé exploity a případné odkazy"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="securityRecommendations" class="form-label">Doporučení pro zabezpečení</label>
                                    <textarea class="form-control" id="securityRecommendations" name="securityRecommendations" rows="3"
                                              placeholder="Uveďte doporučení pro zvýšení zabezpečení"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.5 Testovací prostředí -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">5. Testovací prostředí</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="readers" class="form-label">Použité čtečky/zařízení</label>
                                    <textarea class="form-control" id="readers" name="readers" rows="3"
                                              placeholder="Uveďte použité čtečky a zařízení"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="software" class="form-label">Software pro analýzu</label>
                                    <input type="text" class="form-control" id="software" name="software"
                                           placeholder="např. Proxmark3, libnfc, NFC Tools Pro">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firmware" class="form-label">Verze firmware</label>
                                    <input type="text" class="form-control" id="firmware" name="firmware"
                                           placeholder="např. Proxmark3 v4.9237">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="testConditions" class="form-label">Podmínky testování</label>
                                    <textarea class="form-control" id="testConditions" name="testConditions" rows="3"
                                              placeholder="Popište podmínky, za kterých bylo testování prováděno"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.6 Výsledky testů -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">6. Výsledky testů</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="readWriteTest" class="form-label">Čtení/zápis test</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="readWriteTestTable">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #000; color: #00ff00; border: 1px solid #333;">Operace</th>
                                                    <th style="background-color: #000; color: #00ff00; border: 1px solid #333;">Úspěšnost</th>
                                                    <th style="background-color: #000; color: #00ff00; border: 1px solid #333;">Čas (ms)</th>
                                                    <th style="background-color: #000; color: #00ff00; border: 1px solid #333;">Poznámka</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="background-color: #0a0a0a; color: #cccccc;">Čtení UID</td>
                                                    <td style="background-color: #0a0a0a;">
                                                        <select class="form-select" name="readUidSuccess" style="background-color: #0a0a0a; color: #00ff00; border-color: #333;">
                                                            <option value="Úspěšné">Úspěšné</option>
                                                            <option value="Částečně úspěšné">Částečně úspěšné</option>
                                                            <option value="Neúspěšné">Neúspěšné</option>
                                                        </select>
                                                    </td>
                                                    <td style="background-color: #0a0a0a;"><input type="number" class="form-control" name="readUidTime" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                    <td style="background-color: #0a0a0a;"><input type="text" class="form-control" name="readUidNote" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #0a0a0a; color: #cccccc;">Čtení dat</td>
                                                    <td style="background-color: #0a0a0a;">
                                                        <select class="form-select" name="readDataSuccess" style="background-color: #0a0a0a; color: #00ff00; border-color: #333;">
                                                            <option value="Úspěšné">Úspěšné</option>
                                                            <option value="Částečně úspěšné">Částečně úspěšné</option>
                                                            <option value="Neúspěšné">Neúspěšné</option>
                                                        </select>
                                                    </td>
                                                    <td style="background-color: #0a0a0a;"><input type="number" class="form-control" name="readDataTime" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                    <td style="background-color: #0a0a0a;"><input type="text" class="form-control" name="readDataNote" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #0a0a0a; color: #cccccc;">Zápis dat</td>
                                                    <td style="background-color: #0a0a0a;">
                                                        <select class="form-select" name="writeDataSuccess" style="background-color: #0a0a0a; color: #00ff00; border-color: #333;">
                                                            <option value="Úspěšné">Úspěšné</option>
                                                            <option value="Částečně úspěšné">Částečně úspěšné</option>
                                                            <option value="Neúspěšné">Neúspěšné</option>
                                                            <option value="Nepodporováno">Nepodporováno</option>
                                                        </select>
                                                    </td>
                                                    <td style="background-color: #0a0a0a;"><input type="number" class="form-control" name="writeDataTime" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                    <td style="background-color: #0a0a0a;"><input type="text" class="form-control" name="writeDataNote" style="background-color: #0a0a0a; color: #cccccc; border-color: #333;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="transferSpeed" class="form-label">Rychlost přenosu dat</label>
                                    <input type="text" class="form-control" id="transferSpeed" name="transferSpeed"
                                           placeholder="např. 106 kbit/s">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="readDistance" class="form-label">Úspěšnost čtení na vzdálenost</label>
                                    <input type="text" class="form-control" id="readDistance" name="readDistance"
                                           placeholder="např. max. 5 cm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="interferenceResistance" class="form-label">Odolnost proti rušení (1-5)</label>
                                    <div class="rating">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="interferenceResistance" id="interference1" value="1">
                                            <label class="form-check-label" for="interference1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="interferenceResistance" id="interference2" value="2">
                                            <label class="form-check-label" for="interference2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="interferenceResistance" id="interference3" value="3">
                                            <label class="form-check-label" for="interference3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="interferenceResistance" id="interference4" value="4">
                                            <label class="form-check-label" for="interference4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="interferenceResistance" id="interference5" value="5">
                                            <label class="form-check-label" for="interference5">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="penetrationTestResults" class="form-label">Výsledky penetračních testů</label>
                                    <textarea class="form-control" id="penetrationTestResults" name="penetrationTestResults" rows="3"
                                              placeholder="Popište výsledky penetračních testů"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.7 Přílohy -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">7. Přílohy</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="communicationLogs" class="form-label">Zachycené komunikační logy</label>
                                    <textarea class="form-control" id="communicationLogs" name="communicationLogs" rows="4"
                                              placeholder="Vložte zachycené komunikační logy"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="screenshots" class="form-label">Screenshoty z analýzy</label>
                                    <textarea class="form-control" id="screenshots" name="screenshots" rows="4"
                                              placeholder="Popište nebo vložte odkazy na screenshoty"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tagPhotos" class="form-label">Fotografie tagu</label>
                                    <textarea class="form-control" id="tagPhotos" name="tagPhotos" rows="4"
                                              placeholder="Popište nebo vložte odkazy na fotografie tagu"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="performanceGraphs" class="form-label">Grafy výkonu</label>
                                    <textarea class="form-control" id="performanceGraphs" name="performanceGraphs" rows="4"
                                              placeholder="Popište nebo vložte odkazy na grafy výkonu"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1.8 Závěr a doporučení -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title h5 mb-0">8. Závěr a doporučení</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="overallRating" class="form-label">Celkové hodnocení (1-5)</label>
                                    <div class="rating">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="overallRating" id="rating1" value="1">
                                            <label class="form-check-label" for="rating1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="overallRating" id="rating2" value="2">
                                            <label class="form-check-label" for="rating2">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="overallRating" id="rating3" value="3">
                                            <label class="form-check-label" for="rating3">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="overallRating" id="rating4" value="4">
                                            <label class="form-check-label" for="rating4">4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="overallRating" id="rating5" value="5">
                                            <label class="form-check-label" for="rating5">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="suitability" class="form-label">Vhodnost pro zamýšlené použití</label>
                                    <select class="form-select" id="suitability" name="suitability">
                                        <option value="">-- Vyberte hodnocení --</option>
                                        <option value="Vysoce vhodné">Vysoce vhodné</option>
                                        <option value="Vhodné">Vhodné</option>
                                        <option value="Podmíněně vhodné">Podmíněně vhodné</option>
                                        <option value="Spíše nevhodné">Spíše nevhodné</option>
                                        <option value="Nevhodné">Nevhodné</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="securityRecommendationsFinal" class="form-label">Bezpečnostní doporučení</label>
                                    <textarea class="form-control" id="securityRecommendationsFinal" name="securityRecommendationsFinal" rows="4"
                                              placeholder="Uveďte závěrečná bezpečnostní doporučení"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="improvementSuggestions" class="form-label">Návrhy na vylepšení</label>
                                    <textarea class="form-control" id="improvementSuggestions" name="improvementSuggestions" rows="4"
                                              placeholder="Uveďte návrhy na vylepšení"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tlačítka formuláře -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-secondary me-2" id="saveDataBtn" onclick="saveFormData(); return false;">Uložit data</button>
                            <button type="button" class="btn btn-info me-2" id="loadDataBtn" onclick="loadFormData(); return false;">Načíst data</button>
                            <button type="button" class="btn btn-primary me-2" id="previewBtn" onclick="previewReport(); return false;">Náhled</button>
                            <button type="submit" class="btn btn-success">Generovat PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>

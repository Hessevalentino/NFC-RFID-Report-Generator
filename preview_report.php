<?php
/**
 * NFC/RFID Report Generator
 * Náhled reportu
 */

// Kontrola, zda byl formulář odeslán
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Zpracování dat z formuláře
$reportData = $_POST;

// Nastavení hlaviček pro HTML výstup
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Začátek generování HTML obsahu
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC/RFID Analýza - ' . htmlspecialchars($reportData['reportId']) . '</title>

    <style>
        /* Základní styly - hackerský design */
        body {
            font-family: "Courier New", monospace;
            line-height: 1.6;
            color: #00ff00; /* Matrix zelená */
            background-color: #0a0a0a;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px;
            background-color: #121212;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
            border: 1px solid #1a1a1a;
        }

        /* Hlavička reportu */
        .report-header {
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: #00ff00;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            border-left: 4px solid #00ff00;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            font-family: "Courier New", monospace;
        }

        .report-header h1::before {
            content: "[ ";
        }

        .report-header h1::after {
            content: " ]";
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 12px;
            font-family: "Courier New", monospace;
            color: #00cc00;
        }

        .report-id {
            font-weight: bold;
            background-color: rgba(0, 255, 0, 0.1);
            padding: 5px 10px;
            border: 1px solid #00ff00;
            border-radius: 0;
            font-family: "Courier New", monospace;
        }

        /* Sekce reportu */
        .section {
            margin-bottom: 30px;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.1);
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-left: 3px solid #00ff00;
        }

        .section-header {
            background-color: #000000;
            padding: 15px 20px;
            border-bottom: 1px solid #333;
            display: flex;
            align-items: center;
        }

        .section-header h2 {
            margin: 0;
            font-size: 16px;
            color: #00ff00;
            font-weight: 700;
            font-family: "Courier New", monospace;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-header .section-icon {
            margin-right: 10px;
            width: 24px;
            height: 24px;
            background-color: #000000;
            color: #ffff00;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            font-family: "Courier New", monospace;
        }

        .section-content {
            padding: 20px;
            color: #cccccc;
            font-family: "Courier New", monospace;
        }

        /* Tabulky */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-family: "Courier New", monospace;
        }

        .data-table {
            border: 1px solid #333;
            width: 100%;
            background-color: #0a0a0a;
        }

        .data-table th {
            background-color: #000000;
            font-weight: 700;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #333;
            color: #00ff00;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #333;
            vertical-align: top;
            color: #cccccc;
            background-color: #0a0a0a;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:nth-child(even) {
            background-color: #0f0f0f;
        }

        /* Info tabulka (bez rámečků) */
        .info-table {
            width: 100%;
            background-color: #0a0a0a;
        }

        .info-table td {
            padding: 8px 0;
            vertical-align: top;
            border-bottom: 1px solid #333;
            color: #cccccc;
            background-color: #0a0a0a;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .info-table td:first-child {
            font-weight: 700;
            width: 30%;
            color: #00cc00;
            padding-right: 15px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        /* Hodnocení */
        .rating {
            display: inline-flex;
            align-items: center;
            font-family: "Courier New", monospace;
        }

        .rating-stars {
            color: #00ff00;
            font-size: 18px;
            letter-spacing: 2px;
            text-shadow: 0 0 5px rgba(0, 255, 0, 0.5);
        }

        /* Zápatí */
        .report-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            padding: 20px;
            border-top: 1px solid #333;
            font-family: "Courier New", monospace;
        }

        .report-footer::before {
            content: "/* ";
            color: #00ff00;
        }

        .report-footer::after {
            content: " */";
            color: #00ff00;
        }

        /* Tlačítka */
        .btn-container {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px solid #333;
        }

        .btn {
            display: inline-block;
            font-weight: 700;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid #00ff00;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            line-height: 1.5;
            border-radius: 0;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            margin: 0 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: "Courier New", monospace;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .btn-primary {
            color: #00ff00;
            background-color: #000;
            border-color: #00ff00;
        }

        .btn-secondary {
            color: #ccc;
            background-color: #1a1a1a;
            border-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="report-header">
            <h1>NFC/RFID Analýza - ' . htmlspecialchars($reportData['reportId']) . '</h1>
            <div class="report-meta">
                <div>
                    <span>Datum: ' . htmlspecialchars($reportData['analysisDate']) . '</span> |
                    <span>Analytik: ' . htmlspecialchars($reportData['analystName']) . '</span>
                </div>
                <div class="report-id">ID: ' . htmlspecialchars($reportData['reportId']) . '</div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">1</div>
                <h2>Základní informace o analýze</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Datum analýzy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['analysisDate']) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Analytik:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['analystName']) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">ID reportu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['reportId']) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Typ analýzy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['analysisType']) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">2</div>
                <h2>Informace o testovaném tagu</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Typ tagu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['tagType'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Výrobce:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['manufacturer'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Model/označení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['model'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Sériové číslo:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['serialNumber'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Frekvence:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['frequency'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Kapacita paměti:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['memoryCapacity'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Fyzické rozměry:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['dimensions'] ?? 'Neuvedeno') . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">3</div>
                <h2>Technická specifikace</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Použité protokoly:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . (isset($reportData['protocols']) && is_array($reportData['protocols']) ? htmlspecialchars(implode(', ', $reportData['protocols'])) : 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Typ šifrování:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . (isset($reportData['encryption']) && is_array($reportData['encryption']) ? htmlspecialchars(implode(', ', $reportData['encryption'])) : 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Podporované příkazy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['supportedCommands'] ?? 'Neuvedeno')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">NDEF záznamy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['ndefRecords'] ?? 'Neuvedeno')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">UID/NUID:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['uid'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">ATR response:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['atrResponse'] ?? 'Neuvedeno') . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">4</div>
                <h2>Bezpečnostní analýza</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Zjištěné zranitelnosti:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['vulnerabilities'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Úroveň zabezpečení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">
                            <div class="rating">
                                <div class="rating-stars" style="color: #00ff00; font-size: 18px; letter-spacing: 2px; text-shadow: 0 0 5px rgba(0, 255, 0, 0.5);">' . str_repeat('★', intval($reportData['securityLevel'] ?? 0)) . str_repeat('☆', 5 - intval($reportData['securityLevel'] ?? 0)) . '</div>
                                <span style="margin-left: 10px; color: #00ff00;">' . htmlspecialchars($reportData['securityLevel'] ?? 'Nehodnoceno') . '/5</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Možnosti klonování:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . (isset($reportData['cloning']) && is_array($reportData['cloning']) ? htmlspecialchars(implode(', ', $reportData['cloning'])) : 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Známé exploity:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['knownExploits'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Doporučení pro zabezpečení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['securityRecommendations'] ?? 'Žádné')) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">5</div>
                <h2>Testovací prostředí</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Použité čtečky/zařízení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['readers'] ?? 'Neuvedeno')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Software pro analýzu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['software'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Verze firmware:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['firmware'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Podmínky testování:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['testConditions'] ?? 'Neuvedeno')) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">6</div>
                <h2>Výsledky testů</h2>
            </div>
            <div class="section-content">
                <h3 style="font-size: 16px; color: #00ff00; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;">Čtení/zápis test</h3>
                <table class="data-table" style="width: 100%; border-collapse: collapse; border: 1px solid #333; background-color: #0a0a0a;">
                    <thead>
                        <tr>
                            <th style="background-color: #000; color: #00ff00; padding: 8px; text-align: left; border: 1px solid #333; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Operace</th>
                            <th style="background-color: #000; color: #00ff00; padding: 8px; text-align: left; border: 1px solid #333; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Úspěšnost</th>
                            <th style="background-color: #000; color: #00ff00; padding: 8px; text-align: left; border: 1px solid #333; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Čas (ms)</th>
                            <th style="background-color: #000; color: #00ff00; padding: 8px; text-align: left; border: 1px solid #333; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Poznámka</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">Čtení UID</td>
                            <td style="background-color: #0a0a0a; color: #00ff00; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readUidSuccess'] ?? 'Neuvedeno') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readUidTime'] ?? '-') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readUidNote'] ?? '-') . '</td>
                        </tr>
                        <tr>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">Čtení dat</td>
                            <td style="background-color: #0a0a0a; color: #00ff00; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readDataSuccess'] ?? 'Neuvedeno') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readDataTime'] ?? '-') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['readDataNote'] ?? '-') . '</td>
                        </tr>
                        <tr>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">Zápis dat</td>
                            <td style="background-color: #0a0a0a; color: #00ff00; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['writeDataSuccess'] ?? 'Neuvedeno') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['writeDataTime'] ?? '-') . '</td>
                            <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border: 1px solid #333;">' . htmlspecialchars($reportData['writeDataNote'] ?? '-') . '</td>
                        </tr>
                    </tbody>
                </table>

                <h3 style="font-size: 16px; color: #00ff00; margin: 20px 0 15px; text-transform: uppercase; letter-spacing: 1px;">Další výsledky testů</h3>
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Rychlost přenosu dat:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['transferSpeed'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Úspěšnost čtení na vzdálenost:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . htmlspecialchars($reportData['readDistance'] ?? 'Neuvedeno') . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Odolnost proti rušení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">
                            <div class="rating">
                                <div class="rating-stars" style="color: #00ff00; font-size: 18px; letter-spacing: 2px; text-shadow: 0 0 5px rgba(0, 255, 0, 0.5);">' . str_repeat('★', intval($reportData['interferenceResistance'] ?? 0)) . str_repeat('☆', 5 - intval($reportData['interferenceResistance'] ?? 0)) . '</div>
                                <span style="margin-left: 10px; color: #00ff00;">' . htmlspecialchars($reportData['interferenceResistance'] ?? 'Nehodnoceno') . '/5</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Výsledky penetračních testů:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['penetrationTestResults'] ?? 'Neuvedeno')) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">7</div>
                <h2>Přílohy</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Zachycené komunikační logy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['communicationLogs'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Screenshoty z analýzy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['screenshots'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Fotografie tagu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['tagPhotos'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Grafy výkonu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['performanceGraphs'] ?? 'Žádné')) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <div class="section-icon">8</div>
                <h2>Závěr a doporučení</h2>
            </div>
            <div class="section-content">
                <table class="info-table" style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Celkové hodnocení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">
                            <div class="rating">
                                <div class="rating-stars" style="color: #00ff00; font-size: 18px; letter-spacing: 2px; text-shadow: 0 0 5px rgba(0, 255, 0, 0.5);">' . str_repeat('★', intval($reportData['overallRating'] ?? 0)) . str_repeat('☆', 5 - intval($reportData['overallRating'] ?? 0)) . '</div>
                                <span style="margin-left: 10px; color: #00ff00;">' . htmlspecialchars($reportData['overallRating'] ?? 'Nehodnoceno') . '/5</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Vhodnost pro zamýšlené použití:</td>
                        <td style="background-color: #0a0a0a; color: #00ff00; padding: 8px; border-bottom: 1px solid #333;"><strong>' . htmlspecialchars($reportData['suitability'] ?? 'Neuvedeno') . '</strong></td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Bezpečnostní doporučení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['securityRecommendationsFinal'] ?? 'Žádné')) . '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Návrhy na vylepšení:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;">' . nl2br(htmlspecialchars($reportData['improvementSuggestions'] ?? 'Žádné')) . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="report-footer">
            <p>Vygenerováno pomocí NFC/RFID Report Generator</p>
            <p>Datum vygenerování: ' . date('d.m.Y H:i:s') . '</p>
        </div>

        <div class="btn-container">
            <a href="index.php" class="btn btn-secondary">Zpět na formulář</a>
            <button onclick="window.print()" class="btn btn-primary">Vytisknout</button>
            <form method="post" action="generate_pdf.php" style="display: inline;">';

// Přidání všech POST dat jako skrytá pole
foreach ($reportData as $key => $value) {
    if (is_array($value)) {
        foreach ($value as $item) {
            $html .= "<input type=\"hidden\" name=\"{$key}[]\" value=\"" . htmlspecialchars($item) . "\">";
        }
    } else {
        $html .= "<input type=\"hidden\" name=\"{$key}\" value=\"" . htmlspecialchars($value) . "\">";
    }
}

$html .= '
                <button type="submit" class="btn btn-primary">Generovat PDF</button>
            </form>
        </div>
    </div>
</body>
</html>';

// Zobrazení HTML
echo $html;

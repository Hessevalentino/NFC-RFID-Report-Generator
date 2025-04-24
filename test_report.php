<?php
// Testovací soubor pro zobrazení reportu v hackerskému stylu

// Simulace dat z formuláře
$reportData = [
    'reportId' => '250424-250',
    'analysisDate' => '2025-04-24',
    'analystName' => 'Test Analytik',
    'analysisType' => 'Bezpečnostní analýza',
    'tagType' => 'NFC Type 2',
    'manufacturer' => 'NXP',
    'model' => 'NTAG213',
    'serialNumber' => '04:A2:B3:C4:D5:E6',
    'frequency' => '13.56 MHz',
    'memoryCapacity' => '144 bytes',
    'dimensions' => '25mm x 25mm',
    'protocols' => ['ISO/IEC 14443A', 'MIFARE'],
    'encryption' => ['None'],
    'supportedCommands' => 'READ, WRITE, FAST_READ',
    'ndefRecords' => 'URL, Text',
    'uid' => '04:A2:B3:C4:D5:E6',
    'atrResponse' => '3B 8F 80 01 80 4F 0C A0 00 00 03 06',
    'vulnerabilities' => 'Žádné významné zranitelnosti nebyly zjištěny.',
    'securityLevel' => '4',
    'cloning' => ['Teoreticky možné'],
    'knownExploits' => 'Žádné známé exploity',
    'securityRecommendations' => 'Použití silnějšího šifrování pro citlivá data.',
    'readers' => 'ACR122U, Proxmark3',
    'software' => 'NFC Tools Pro, MFOC',
    'firmware' => '1.2.3',
    'testConditions' => 'Laboratorní podmínky, teplota 22°C',
    'readUidSuccess' => 'Úspěšné',
    'readUidTime' => '12',
    'readUidNote' => 'Bez problémů',
    'readDataSuccess' => 'Úspěšné',
    'readDataTime' => '45',
    'readDataNote' => 'Bez problémů',
    'writeDataSuccess' => 'Úspěšné',
    'writeDataTime' => '78',
    'writeDataNote' => 'Bez problémů',
    'transferSpeed' => '106 kbit/s',
    'readDistance' => 'Až 5 cm',
    'interferenceResistance' => '3',
    'penetrationTestResults' => 'Všechny testy proběhly úspěšně.',
    'communicationLogs' => 'Log1.txt, Log2.txt',
    'screenshots' => 'Screenshot1.png, Screenshot2.png',
    'tagPhotos' => 'Photo1.jpg, Photo2.jpg',
    'performanceGraphs' => 'Graph1.png, Graph2.png',
    'overallRating' => '4',
    'suitability' => 'Vhodné pro zamýšlené použití',
    'securityRecommendationsFinal' => 'Doporučujeme použití silnějšího šifrování pro citlivá data.',
    'improvementSuggestions' => 'Zvážit použití novější verze tagu s lepší podporou šifrování.'
];

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
            background-color: #00ff00;
            color: #000;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="report-header">
            <h1>NFC/RFID Analýza</h1>
        </div>
        
        <div class="section">
            <div class="section-header">
                <div class="section-icon">1</div>
                <h2>Základní informace o analýze</h2>
            </div>
            <div class="section-content">
                <table style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Datum analýzy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['analysisDate']); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Analytik:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['analystName']); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">ID reportu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['reportId']); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Typ analýzy:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['analysisType']); ?></td>
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
                <table style="width: 100%; border-collapse: collapse; background-color: #0a0a0a;">
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Typ tagu:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['tagType']); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: #0a0a0a; color: #00cc00; padding: 8px; border-bottom: 1px solid #333; width: 30%; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Výrobce:</td>
                        <td style="background-color: #0a0a0a; color: #cccccc; padding: 8px; border-bottom: 1px solid #333;"><?php echo htmlspecialchars($reportData['manufacturer']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>';

// Zobrazení HTML
echo $html;

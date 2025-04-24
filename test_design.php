<?php
// Testovací soubor pro hackerský design
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Hackerského Designu</title>
    
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
                <p>Toto je ukázka hackerského designu pro NFC/RFID Report Generator.</p>
                <p>Datum analýzy: <?php echo date('d.m.Y'); ?></p>
                <p>Analytik: Test User</p>
                <p>ID reportu: <?php echo date('ymd').'-'.rand(100, 999); ?></p>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                <div class="section-icon">2</div>
                <h2>Informace o testovaném tagu</h2>
            </div>
            <div class="section-content">
                <p>Typ tagu: NFC Type 2</p>
                <p>Výrobce: NXP</p>
                <p>Model: NTAG213</p>
                <p>Frekvence: 13.56 MHz</p>
            </div>
        </div>
    </div>
</body>
</html>

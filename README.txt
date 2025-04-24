NFC/RFID REPORT GENERATOR
=======================

Aplikace pro generování komplexních analýz NFC a RFID tagů.

INSTALACE
---------

1. Rozbalte soubory do adresáře na webovém serveru s podporou PHP
2. Pro plnou funkčnost nainstalujte knihovnu mPDF pomocí Composeru:
   composer require mpdf/mpdf
3. Ujistěte se, že adresáře 'lib' a 'templates' mají práva pro zápis

POUŽITÍ
-------

1. Otevřete aplikaci ve webovém prohlížeči (např. http://localhost/Analyse%20Generator/index.php)
2. Vyplňte formulář s informacemi o analýze
3. Použijte tlačítko "Náhled" pro zobrazení náhledu reportu
4. Klikněte na "Generovat PDF" pro vytvoření a stažení PDF reportu
5. Pomocí tlačítek "Uložit data" a "Načíst data" můžete exportovat a importovat data ve formátu JSON

STRUKTURA APLIKACE
-----------------

- index.php - Hlavní stránka s formulářem
- generate_pdf.php - Skript pro generování PDF
- export_data.php - Skript pro export dat do JSON
- import_data.php - Skript pro import dat z JSON
- assets/ - Adresář s CSS, JavaScript a obrázky
- classes/ - Adresář s PHP třídami
- lib/ - Adresář pro knihovny (mPDF)
- templates/ - Adresář se šablonami

POŽADAVKY
---------

- PHP 7.4 nebo vyšší
- Webový server (Apache, Nginx, atd.)
- Pro generování PDF: knihovna mPDF
- Moderní webový prohlížeč

KONTAKT
-------

Pro další informace nebo podporu kontaktujte autora aplikace.

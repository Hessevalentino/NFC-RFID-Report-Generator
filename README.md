# NFC/RFID Report Generator

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Open Source](https://badges.frapsoft.com/os/v1/open-source.svg?v=103)](https://opensource.org/)

Aplikace pro generování komplexních analýz NFC a RFID tagů s hackerským vizuálním stylem.

## 📋 Popis projektu

NFC/RFID Report Generator je webová aplikace, která umožňuje vytvářet detailní technické reporty o NFC a RFID technologiích. Aplikace je určena pro bezpečnostní analytiky, vývojáře a testery, kteří potřebují dokumentovat výsledky svých analýz.

## 🚀 Funkce

- Komplexní formulář pro zadání všech aspektů analýzy
- Generování PDF reportů
- Export/import dat ve formátu JSON
- Náhled reportu před generováním
- Ukládání dat lokálně do počítače
- Responzivní design (Bootstrap 5)

## 📦 Struktura aplikace

Aplikace obsahuje následující sekce:

1. **Základní informace o analýze**
   - Datum analýzy
   - Jméno analytika
   - ID reportu
   - Typ analýzy

2. **Informace o testovaném tagu**
   - Typ tagu
   - Výrobce
   - Model/označení
   - Sériové číslo
   - Frekvence
   - Kapacita paměti
   - Fyzické rozměry

3. **Technická specifikace**
   - Použité protokoly
   - Typ šifrování
   - Podporované příkazy
   - NDEF záznamy
   - UID/NUID
   - ATR response

4. **Bezpečnostní analýza**
   - Zjištěné zranitelnosti
   - Úroveň zabezpečení
   - Možnosti klonování
   - Známé exploity
   - Doporučení pro zabezpečení

5. **Testovací prostředí**
   - Použité čtečky/zařízení
   - Software pro analýzu
   - Verze firmware
   - Podmínky testování

6. **Výsledky testů**
   - Čtení/zápis test
   - Rychlost přenosu dat
   - Úspěšnost čtení na vzdálenost
   - Odolnost proti rušení
   - Výsledky penetračních testů

7. **Přílohy**
   - Zachycené komunikační logy
   - Screenshoty z analýzy
   - Fotografie tagu
   - Grafy výkonu

8. **Závěr a doporučení**
   - Celkové hodnocení
   - Vhodnost pro zamýšlené použití
   - Bezpečnostní doporučení
   - Návrhy na vylepšení

## 🔧 Technologie

- PHP
- JavaScript
- AJAX
- Bootstrap 5
- mPDF (pro generování PDF)

## 💻 Instalace

1. Stáhněte nebo naklonujte repozitář
2. Nainstalujte mPDF pomocí Composeru (pokud není součástí repozitáře)
   ```
   composer require mpdf/mpdf
   ```
3. Nahrajte soubory na webový server s podporou PHP
4. Otevřete aplikaci ve webovém prohlížeči

## 🔍 Použití

1. Vyplňte formulář s informacemi o analýze
2. Použijte tlačítko "Náhled" pro zobrazení náhledu reportu
3. Klikněte na "Generovat PDF" pro vytvoření a stažení PDF reportu
4. Pomocí tlačítek "Uložit data" a "Načíst data" můžete exportovat a importovat data ve formátu JSON

## 📝 Licence

Tento projekt je licencován pod MIT licencí.

```
MIT License

Copyright (c) 2023 NFC/RFID Report Generator

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## 👥 Autor a přispěvatelé

Vytvořeno jako součást projektu analýzy NFC/RFID technologií.

## 🤝 Přispívání

Příspěvky jsou vítány! Pokud chcete přispět k projektu:

1. Forkněte repozitář
2. Vytvořte novou větev (`git checkout -b feature/amazing-feature`)
3. Commitněte vaše změny (`git commit -m 'Add some amazing feature'`)
4. Pushněte do větve (`git push origin feature/amazing-feature`)
5. Otevřete Pull Request

## 🔒 Bezpečnost

Aplikace pracuje pouze s lokálními daty a neukládá žádné informace na server. Všechna data jsou zpracovávána pouze v prohlížeči uživatele a ukládána lokálně.

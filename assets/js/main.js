/**
 * NFC/RFID Report Generator - Main JavaScript
 * Handles form interactions, data saving/loading, and preview functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize form elements
    initFormElements();

    // Set up event listeners
    setupEventListeners();
});

/**
 * Initialize form elements and set default values
 */
function initFormElements() {
    // Set default date to today
    document.getElementById('analysisDate').valueAsDate = new Date();

    // Load analyst name from localStorage if available
    const savedAnalystName = localStorage.getItem('analystName');
    if (savedAnalystName) {
        document.getElementById('analystName').value = savedAnalystName;
    }

    // Generate random report ID if not already set
    if (!document.getElementById('reportId').value) {
        generateReportId();
    }
}

/**
 * Set up event listeners for buttons and form elements
 */
function setupEventListeners() {
    // Save data button
    document.getElementById('saveDataBtn').addEventListener('click', function() {
        saveFormData();
    });

    // Load data button
    document.getElementById('loadDataBtn').addEventListener('click', function() {
        loadFormData();
    });

    // Preview button
    document.getElementById('previewBtn').addEventListener('click', function() {
        previewReport();
    });

    // Save analyst name to localStorage when changed
    document.getElementById('analystName').addEventListener('change', function() {
        localStorage.setItem('analystName', this.value);
    });

    // Update form sections based on analysis type
    document.getElementById('analysisType').addEventListener('change', function() {
        updateFormSections(this.value);
    });
}

/**
 * Generate a unique report ID based on date and random number
 */
function generateReportId() {
    const date = new Date();
    const year = date.getFullYear().toString().substr(-2);
    const month = ('0' + (date.getMonth() + 1)).slice(-2);
    const day = ('0' + date.getDate()).slice(-2);
    const random = Math.floor(Math.random() * 900) + 100; // Random 3-digit number

    const reportId = `${year}${month}${day}-${random}`;
    document.getElementById('reportId').value = reportId;
}

/**
 * Save form data to a JSON file for download
 */
function saveFormData() {
    // Collect all form data
    const formData = new FormData(document.getElementById('reportForm'));
    const jsonData = {};

    // Convert FormData to JSON object
    for (const [key, value] of formData.entries()) {
        // Handle arrays (checkboxes with same name)
        if (key.endsWith('[]')) {
            const cleanKey = key.slice(0, -2);
            if (!jsonData[cleanKey]) {
                jsonData[cleanKey] = [];
            }
            jsonData[cleanKey].push(value);
        } else {
            jsonData[key] = value;
        }
    }

    // Create a downloadable JSON file
    const dataStr = JSON.stringify(jsonData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});

    // Create download link
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(dataBlob);
    downloadLink.download = `nfc-rfid-report-${jsonData.reportId}.json`;

    // Trigger download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);

    alert('Data byla úspěšně uložena!');
}

/**
 * Load form data from a JSON file
 */
function loadFormData() {
    // Create file input element
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'application/json';

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const jsonData = JSON.parse(e.target.result);
                populateForm(jsonData);
                alert('Data byla úspěšně načtena!');
            } catch (error) {
                alert('Chyba při načítání dat: ' + error.message);
            }
        };
        reader.readAsText(file);
    });

    // Trigger file selection
    fileInput.click();

    // Prevent form submission
    return false;
}

/**
 * Populate form with data from JSON object
 * @param {Object} data - JSON data to populate the form with
 */
function populateForm(data) {
    // Reset form first
    document.getElementById('reportForm').reset();

    // Populate text inputs, selects, and textareas
    for (const key in data) {
        const element = document.getElementById(key);
        if (element) {
            if (element.type === 'checkbox' || element.type === 'radio') {
                element.checked = data[key] === 'on' || data[key] === true;
            } else {
                element.value = data[key];
            }
        }

        // Handle arrays (checkboxes with same name)
        if (Array.isArray(data[key])) {
            data[key].forEach(value => {
                const checkboxes = document.querySelectorAll(`input[name="${key}[]"]`);
                checkboxes.forEach(checkbox => {
                    if (checkbox.value === value) {
                        checkbox.checked = true;
                    }
                });

                // Handle radio buttons
                const radios = document.querySelectorAll(`input[name="${key}"]`);
                radios.forEach(radio => {
                    if (radio.value === value) {
                        radio.checked = true;
                    }
                });
            });
        }
    }
}

/**
 * Preview the report before generating PDF
 */
function previewReport() {
    // Open a new window for preview
    const previewWindow = window.open('', '_blank');

    // Collect form data
    const formData = new FormData(document.getElementById('reportForm'));
    const reportData = {};

    // Convert FormData to object
    for (const [key, value] of formData.entries()) {
        if (key.endsWith('[]')) {
            const cleanKey = key.slice(0, -2);
            if (!reportData[cleanKey]) {
                reportData[cleanKey] = [];
            }
            reportData[cleanKey].push(value);
        } else {
            reportData[key] = value;
        }
    }

    // Generate HTML content for preview
    let previewContent = `
    <!DOCTYPE html>
    <html lang="cs">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Náhled reportu - ${reportData.reportId}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { padding: 20px; }
            .section { margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
            h1, h2 { color: #0d6efd; }
            .section-title { background-color: #f1f5f9; padding: 10px; margin: -15px -15px 15px; border-radius: 5px 5px 0 0; }
            table { width: 100%; border-collapse: collapse; }
            table, th, td { border: 1px solid #ddd; }
            th, td { padding: 8px; text-align: left; }
            th { background-color: #f1f5f9; }
            @media print { body { padding: 0; } }
        </style>
    </head>
    <body>
        <div class="container">
            <h1 class="mb-4">NFC/RFID Analýza - ${reportData.reportId}</h1>

            <div class="section">
                <h2 class="section-title">1. Základní informace o analýze</h2>
                <p><strong>Datum analýzy:</strong> ${reportData.analysisDate}</p>
                <p><strong>Analytik:</strong> ${reportData.analystName}</p>
                <p><strong>ID reportu:</strong> ${reportData.reportId}</p>
                <p><strong>Typ analýzy:</strong> ${reportData.analysisType}</p>
            </div>

            <div class="section">
                <h2 class="section-title">2. Informace o testovaném tagu</h2>
                <p><strong>Typ tagu:</strong> ${reportData.tagType || 'Neuvedeno'}</p>
                <p><strong>Výrobce:</strong> ${reportData.manufacturer || 'Neuvedeno'}</p>
                <p><strong>Model/označení:</strong> ${reportData.model || 'Neuvedeno'}</p>
                <p><strong>Sériové číslo:</strong> ${reportData.serialNumber || 'Neuvedeno'}</p>
                <p><strong>Frekvence:</strong> ${reportData.frequency || 'Neuvedeno'}</p>
                <p><strong>Kapacita paměti:</strong> ${reportData.memoryCapacity || 'Neuvedeno'}</p>
                <p><strong>Fyzické rozměry:</strong> ${reportData.dimensions || 'Neuvedeno'}</p>
            </div>
    `;

    // Add more sections based on form data
    // Technical specification
    previewContent += `
            <div class="section">
                <h2 class="section-title">3. Technická specifikace</h2>
                <p><strong>Použité protokoly:</strong> ${reportData.protocols ? reportData.protocols.join(', ') : 'Neuvedeno'}</p>
                <p><strong>Typ šifrování:</strong> ${reportData.encryption ? reportData.encryption.join(', ') : 'Neuvedeno'}</p>
                <p><strong>Podporované příkazy:</strong> ${reportData.supportedCommands || 'Neuvedeno'}</p>
                <p><strong>NDEF záznamy:</strong> ${reportData.ndefRecords || 'Neuvedeno'}</p>
                <p><strong>UID/NUID:</strong> ${reportData.uid || 'Neuvedeno'}</p>
                <p><strong>ATR response:</strong> ${reportData.atrResponse || 'Neuvedeno'}</p>
            </div>
    `;

    // Security analysis
    previewContent += `
            <div class="section">
                <h2 class="section-title">4. Bezpečnostní analýza</h2>
                <p><strong>Zjištěné zranitelnosti:</strong> ${reportData.vulnerabilities || 'Žádné'}</p>
                <p><strong>Úroveň zabezpečení:</strong> ${reportData.securityLevel || 'Nehodnoceno'}/5</p>
                <p><strong>Možnosti klonování:</strong> ${reportData.cloning ? reportData.cloning.join(', ') : 'Neuvedeno'}</p>
                <p><strong>Známé exploity:</strong> ${reportData.knownExploits || 'Žádné'}</p>
                <p><strong>Doporučení pro zabezpečení:</strong> ${reportData.securityRecommendations || 'Žádné'}</p>
            </div>
    `;

    // Testing environment
    previewContent += `
            <div class="section">
                <h2 class="section-title">5. Testovací prostředí</h2>
                <p><strong>Použité čtečky/zařízení:</strong> ${reportData.readers || 'Neuvedeno'}</p>
                <p><strong>Software pro analýzu:</strong> ${reportData.software || 'Neuvedeno'}</p>
                <p><strong>Verze firmware:</strong> ${reportData.firmware || 'Neuvedeno'}</p>
                <p><strong>Podmínky testování:</strong> ${reportData.testConditions || 'Neuvedeno'}</p>
            </div>
    `;

    // Test results
    previewContent += `
            <div class="section">
                <h2 class="section-title">6. Výsledky testů</h2>
                <table class="mb-3">
                    <thead>
                        <tr>
                            <th>Operace</th>
                            <th>Úspěšnost</th>
                            <th>Čas (ms)</th>
                            <th>Poznámka</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Čtení UID</td>
                            <td>${reportData.readUidSuccess || 'Neuvedeno'}</td>
                            <td>${reportData.readUidTime || '-'}</td>
                            <td>${reportData.readUidNote || '-'}</td>
                        </tr>
                        <tr>
                            <td>Čtení dat</td>
                            <td>${reportData.readDataSuccess || 'Neuvedeno'}</td>
                            <td>${reportData.readDataTime || '-'}</td>
                            <td>${reportData.readDataNote || '-'}</td>
                        </tr>
                        <tr>
                            <td>Zápis dat</td>
                            <td>${reportData.writeDataSuccess || 'Neuvedeno'}</td>
                            <td>${reportData.writeDataTime || '-'}</td>
                            <td>${reportData.writeDataNote || '-'}</td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Rychlost přenosu dat:</strong> ${reportData.transferSpeed || 'Neuvedeno'}</p>
                <p><strong>Úspěšnost čtení na vzdálenost:</strong> ${reportData.readDistance || 'Neuvedeno'}</p>
                <p><strong>Odolnost proti rušení:</strong> ${reportData.interferenceResistance || 'Nehodnoceno'}/5</p>
                <p><strong>Výsledky penetračních testů:</strong> ${reportData.penetrationTestResults || 'Neuvedeno'}</p>
            </div>
    `;

    // Attachments
    previewContent += `
            <div class="section">
                <h2 class="section-title">7. Přílohy</h2>
                <p><strong>Zachycené komunikační logy:</strong> ${reportData.communicationLogs || 'Žádné'}</p>
                <p><strong>Screenshoty z analýzy:</strong> ${reportData.screenshots || 'Žádné'}</p>
                <p><strong>Fotografie tagu:</strong> ${reportData.tagPhotos || 'Žádné'}</p>
                <p><strong>Grafy výkonu:</strong> ${reportData.performanceGraphs || 'Žádné'}</p>
            </div>
    `;

    // Conclusion
    previewContent += `
            <div class="section">
                <h2 class="section-title">8. Závěr a doporučení</h2>
                <p><strong>Celkové hodnocení:</strong> ${reportData.overallRating || 'Nehodnoceno'}/5</p>
                <p><strong>Vhodnost pro zamýšlené použití:</strong> ${reportData.suitability || 'Neuvedeno'}</p>
                <p><strong>Bezpečnostní doporučení:</strong> ${reportData.securityRecommendationsFinal || 'Žádné'}</p>
                <p><strong>Návrhy na vylepšení:</strong> ${reportData.improvementSuggestions || 'Žádné'}</p>
            </div>

            <div class="mt-4 text-center">
                <p>Vygenerováno pomocí NFC/RFID Report Generator</p>
                <p>Datum vygenerování: ${new Date().toLocaleString()}</p>
            </div>
        </div>

        <div class="mt-4 text-center d-print-none">
            <button class="btn btn-primary" onclick="window.print()">Vytisknout</button>
            <button class="btn btn-secondary ms-2" onclick="window.close()">Zavřít</button>
        </div>
    </body>
    </html>
    `;

    // Write content to preview window
    previewWindow.document.open();
    previewWindow.document.write(previewContent);
    previewWindow.document.close();
}

/**
 * Update form sections based on selected analysis type
 * @param {string} analysisType - Selected analysis type
 */
function updateFormSections(analysisType) {
    // Show/hide relevant form sections based on analysis type
    if (analysisType === 'NFC') {
        // Show NFC specific fields
        document.querySelectorAll('.nfc-field').forEach(el => {
            el.style.display = 'block';
        });
        // Hide RFID specific fields
        document.querySelectorAll('.rfid-field').forEach(el => {
            el.style.display = 'none';
        });
    } else if (analysisType === 'RFID') {
        // Show RFID specific fields
        document.querySelectorAll('.rfid-field').forEach(el => {
            el.style.display = 'block';
        });
        // Hide NFC specific fields
        document.querySelectorAll('.nfc-field').forEach(el => {
            el.style.display = 'none';
        });
    } else {
        // Show all fields for combined analysis
        document.querySelectorAll('.nfc-field, .rfid-field').forEach(el => {
            el.style.display = 'block';
        });
    }
}

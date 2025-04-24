<?php
/**
 * NFC/RFID Report Generator
 * Hlavní třída pro generování reportů
 */

class ReportGenerator {
    /**
     * Data reportu
     * @var array
     */
    private $reportData;
    
    /**
     * ID reportu
     * @var string
     */
    private $reportId;
    
    /**
     * Konstruktor
     * @param array $data Data reportu (volitelné)
     */
    public function __construct($data = []) {
        $this->reportData = $data;
        $this->reportId = $this->generateReportId();
    }
    
    /**
     * Generuje unikátní ID reportu
     * @return string ID reportu ve formátu RRMMDD-XXX
     */
    public function generateReportId() {
        $date = new DateTime();
        $year = $date->format('y');
        $month = $date->format('m');
        $day = $date->format('d');
        $random = mt_rand(100, 999);
        
        return "{$year}{$month}{$day}-{$random}";
    }
    
    /**
     * Nastaví data reportu
     * @param array $data Data reportu
     */
    public function setReportData($data) {
        $this->reportData = $data;
    }
    
    /**
     * Vrátí data reportu
     * @return array Data reportu
     */
    public function getReportData() {
        return $this->reportData;
    }
    
    /**
     * Vrátí ID reportu
     * @return string ID reportu
     */
    public function getReportId() {
        return $this->reportId;
    }
    
    /**
     * Exportuje data do JSON souboru
     * @return string JSON data
     */
    public function exportToJson() {
        return json_encode($this->reportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Importuje data z JSON souboru
     * @param string $jsonData JSON data
     * @return bool Úspěch importu
     */
    public function importFromJson($jsonData) {
        $data = json_decode($jsonData, true);
        if ($data === null) {
            return false;
        }
        
        $this->reportData = $data;
        if (isset($data['reportId'])) {
            $this->reportId = $data['reportId'];
        }
        
        return true;
    }
    
    /**
     * Validuje data reportu
     * @return array Pole chyb (prázdné, pokud je vše v pořádku)
     */
    public function validateData() {
        $errors = [];
        
        // Kontrola povinných polí
        $requiredFields = [
            'analysisDate' => 'Datum analýzy',
            'analystName' => 'Jméno analytika',
            'analysisType' => 'Typ analýzy',
            'tagType' => 'Typ tagu'
        ];
        
        foreach ($requiredFields as $field => $label) {
            if (empty($this->reportData[$field])) {
                $errors[] = "Pole '{$label}' je povinné.";
            }
        }
        
        return $errors;
    }
}

/**
 * Třída pro NFC analýzu
 */
class NFCAnalysis extends ReportGenerator {
    /**
     * Konstruktor
     * @param array $data Data reportu (volitelné)
     */
    public function __construct($data = []) {
        parent::__construct($data);
    }
    
    /**
     * Validuje data NFC reportu
     * @return array Pole chyb (prázdné, pokud je vše v pořádku)
     */
    public function validateData() {
        $errors = parent::validateData();
        
        // Specifická validace pro NFC
        if (isset($this->getReportData()['analysisType']) && $this->getReportData()['analysisType'] === 'NFC') {
            // Kontrola specifických polí pro NFC
            if (empty($this->getReportData()['ndefRecords'])) {
                $errors[] = "Pro NFC analýzu je vhodné vyplnit NDEF záznamy.";
            }
        }
        
        return $errors;
    }
}

/**
 * Třída pro RFID analýzu
 */
class RFIDAnalysis extends ReportGenerator {
    /**
     * Konstruktor
     * @param array $data Data reportu (volitelné)
     */
    public function __construct($data = []) {
        parent::__construct($data);
    }
    
    /**
     * Validuje data RFID reportu
     * @return array Pole chyb (prázdné, pokud je vše v pořádku)
     */
    public function validateData() {
        $errors = parent::validateData();
        
        // Specifická validace pro RFID
        if (isset($this->getReportData()['analysisType']) && $this->getReportData()['analysisType'] === 'RFID') {
            // Kontrola specifických polí pro RFID
            if (empty($this->getReportData()['frequency'])) {
                $errors[] = "Pro RFID analýzu je vhodné vyplnit frekvenci.";
            }
        }
        
        return $errors;
    }
}

/**
 * Třída pro generování PDF
 */
class PDFExporter {
    /**
     * Data reportu
     * @var array
     */
    private $reportData;
    
    /**
     * Konstruktor
     * @param array $data Data reportu
     */
    public function __construct($data) {
        $this->reportData = $data;
    }
    
    /**
     * Generuje PDF soubor
     * @return string Název vygenerovaného souboru
     */
    public function generatePDF() {
        // Tato metoda by v produkčním prostředí používala knihovnu mPDF
        // Pro účely demonstrace pouze vrátíme název souboru
        $filename = 'nfc-rfid-report-' . $this->reportData['reportId'] . '.pdf';
        return $filename;
    }
}

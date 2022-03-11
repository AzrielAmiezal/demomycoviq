<?php
// Include the main TCPDF library (search for installation path).
session_start();
require 'TCPDF-main/tcpdf.php';
require 'functions.php';

$conn = connection();
$id = $_GET['id'];

//check whether the user is login or not
if (!isset($_SESSION['login'])) {
  header("Location: patient_login.php");
  exit;
}

$dh = query("SELECT patient.*, deklarasi_harian.* FROM patient
                          JOIN deklarasi_harian 
                          ON patient.patient_id = deklarasi_harian.patient_id
                          WHERE patient.patient_id = '$id'")[0];




class PDF extends TCPDF
{
  public function Header()
  {
    $imageFile = K_PATH_IMAGES . 'logo.png';
    $this->Image($imageFile, 90, 10, 38, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $this->Ln(5);
    //font name,size and style
    $this->setFont('helvetica', 'B', 12);
    //total width of A4 page, height, border, line,
    $this->Ln(25);
    $this->Cell(190, 4, 'COVID-19 INDIVIDUAL QUARANTINE APPLICATION (MYCOVIQ)', 0, 1, 'C');
    $this->setFont('helvetica', '', 8);
    $this->Cell('');
    $this->Ln(2);
  }
}

// create new PDF document
$pdf = new PDF('p', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MYCOVIQ COVID-19 INDIVIDUAL QUARANTINE APPLICATION');
$pdf->SetTitle('DEKLARASI HARIAN KENDIRI MYCOVIQ_' . $dh['patientName']);
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$pdf->Ln(22);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(189, 3, 'LAPORAN DEKLARASI HARIAN KENDIRI', 0, 1, 'C');
$pdf->Ln(5);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(189, 3, 'MAKLUMAT PESAKIT', 0, 1, 'C');

$pdf->Ln(5);
$pdf->setFillColor(224, 235, 255);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(118, 5, 'NAMA PESAKIT: ' . $dh['patientName'] . ' ', 0, 0);

$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(20, 5, 'NO KP / PASSPORT: ' . $dh['patient_icNo'] . ' ', 0, 1);
$pdf->Ln(2);

$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(118, 5, 'NO H/P: 0' . $dh['patient_telNo'] . ' ', 0, 0);

$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(20, 5, 'EMAIL: ' . strtoupper($dh['patientEmail']) . ' ', 0, 1);
$pdf->Ln(2);

$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(135, 5, 'ALAMAT: ' . $dh['patient_address'] . ' ', 0, 0);

$pdf->Ln(15);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(189, 3, 'MAKLUMAT KUARANTIN', 0, 1, 'C');

$pdf->Ln(5);
$pdf->setFillColor(224, 235, 255);
$pdf->Cell(70, 5, 'TAHAP JANGKITAN COVID-19', 1, 0, 'C', 1);
$pdf->Cell(60, 5, 'TEMPOH KUARANTIN', 1, 0, 'C', 1);
$pdf->Cell(49, 5, 'STATUS', 1, 0, 'C', 1);
$pdf->setFont('helvetica', '', 10);
$pdf->Ln(5);
$pdf->setFillColor(224, 235, 255);
$pdf->Cell(70, 5, $dh['covidStage'], 1, 0, 'C', 1);
$pdf->Cell(60, 5, date('d M Y', strtotime($dh['tarikh_mula'])) . ' - ' . date('d M Y', strtotime($dh['tarikh_tamat'])), 1, 0, 'C', 1);
$pdf->Cell(49, 5, $dh['status_kuarantin'], 1, 0, 'C', 1);
$pdf->setFont('helvetica', '', 10);


$startTimeStamp = strtotime($dh['tarikh_mula']);
$endTimeStamp = strtotime($dh['tarikh_tamat']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff / 86400;  // 86400 seconds in one day
// and you might want to convert to integer
$numberDays = intval($numberDays) + 1;


$pdf->Ln(15);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(189, 3, 'TAHNIAH. ANDA TELAH BERJAYA MENJALANI KUARANTIN KENDIRI SELAMA ' . $numberDays . ' HARI', 0, 1, 'C');
$pdf->Cell(189, 3, 'SILA SIMPAN SLIP INI UNTUK RUJUKAN PEGAWAI PERUBATAN DAN RUJUKAN DI MASA HADAPAN', 0, 1, 'C');

$pdf->Ln(5);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(189, 3, '"TERUS KEKAL PATUHI SOP, AMALKAN 3W, ELAKKAN 3S"', 0, 1, 'C');


// Close and output PDF document
$pdf->Output($dh['patientName'] . '_' . $dh['patient_icNo'] . '_MYCOVIQ.pdf', 'I');

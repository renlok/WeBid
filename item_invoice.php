<?php

include 'common.php';
define('FPDF_FONTPATH', $include_path . 'pdfgen/font/');
include $include_path . 'pdfgen/fpdf.php';

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,50);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'INVOICE',1,0,'C');
    // Line break
    $this->Ln(10);
	$this->SetFillColor(232, 232, 232);
	$this->SetFont('Arial', 'B', 6);
	$this->SetX(5);
	$this->Cell(10, 6, 'ID', 1, 0, 'C', 1);
	$this->Cell(14, 6, 'AUCTION', 1, 0, 'C', 1);
	$this->Cell(10, 6, 'USER', 1, 0, 'C', 1);
	$this->Cell(30, 6, 'DATE', 1, 0, 'C', 1);
	$this->Cell(14, 6, 'SETUP', 1, 0, 'C', 1);
	$this->Cell(18, 6, 'FEATURED', 1, 0, 'C', 1);
	$this->Cell(10, 6, 'BOLD', 1, 0, 'C', 1);
	$this->Cell(21, 6, 'HIGHLIGHTED', 1, 0, 'C', 1);
	$this->Cell(15, 6, 'SUBTITLE', 1, 0, 'C', 1);
	$this->Cell(11, 6, 'RELIST', 1, 0, 'C', 1);
	$this->Cell(14, 6, 'RESERVE', 1, 0, 'C', 1);
	$this->Cell(14, 6, 'BUYNOW', 1, 0, 'C', 1);
	$this->Cell(10, 6, 'IMAGE', 1, 0, 'C', 1);
	$this->Cell(12, 6, 'EXTCAT', 1, 0, 'C', 1);
	$this->Cell(12, 6, 'TOTAL', 1, 0, 'C', 1);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->SetFillColor(232, 232, 232);
$pdf->SetY(25);
$pdf->SetX(5);
$y_axis_initial = 25;
$y_axis = $y_axis_initial + $row_height;
//Select the Products you want to show in your PDF file
$query="SELECT ID, auction, user, date, featured, bold, highlighted, subtitle, relist, reserve, buynow, image, extcat, total FROM " . $DBPrefix . "invoice WHERE auction =" . $_GET['id'];
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 25;

//Set Row Height
$row_height = 6;

while($row = mysql_fetch_array($result))
{
    //If the current row is the last one, create new page and print column title
    if ($i == $max)
    {
        $pdf->AddPage();

        //Go to next row
        $y_axis = $y_axis + $row_height;

        //Set $i variable to 0 (first row)
        $i = 0;
    }

    $ID = $row['ID'];
    $auction = $row['auction'];
    $user = $row['user'];
	$date = ArrangeDateNoCorrection($row['date']);
	$setup = $row['setup'];
	$featured = $row['featured'];
	$bold = $row['bold'];
	$highlighted = $row['highlighted'];
	$subtitle = $row['subtitle'];
	$relist = $row['relist'];
	$reserve = $row['reserve'];
	$buynow = $row['buynow'];
	$image = $row['image'];
	$extcat = $row['extcat'];
	$total = $row['total'];

    $pdf->SetY($y_axis);
    $pdf->SetX(5);
    $pdf->Cell(10, 6, $ID, 1, 0, 'C', 1);
    $pdf->Cell(14, 6, $auction, 1, 0, 'C', 1);
    $pdf->Cell(10, 6, $user, 1, 0, 'C', 1);
	$pdf->Cell(30, 6, $date, 1, 0, 'C', 1);
	$pdf->Cell(14, 6, $setup, 1, 0, 'C', 1);
	$pdf->Cell(18, 6, $featured, 1, 0, 'C', 1);
	$pdf->Cell(10, 6, $bold,1, 0, 'C', 1);
	$pdf->Cell(21, 6, $highlighted, 1, 0, 'C', 1);
	$pdf->Cell(15, 6, $subtitle, 1, 0, 'C', 1);
	$pdf->Cell(11, 6, $relist, 1, 0, 'C', 1);
	$pdf->Cell(14, 6, $reserve, 1, 0, 'C', 1);
	$pdf->Cell(14, 6, $buynow, 1, 0, 'C', 1);
	$pdf->Cell(10, 6, $image, 1, 0, 'C', 1);
	$pdf->Cell(12, 6, $extcat, 1, 0, 'C', 1);
	$pdf->Cell(12, 6, $total, 1, 0, 'C', 1);

    //Go to next row
    $y_axis = $y_axis + $row_height;
    $i = $i + 1;
}

$pdf->Output();
?>
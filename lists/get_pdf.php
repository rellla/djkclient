<?php
require "../includes/inc.request.php";    // Request Routines
require "../includes/inc.render.php";    // HTML Render Routines
require_once "../includes/settings.php";   // Global Settings
require("../includes/fpdf/fpdf.php");

function print_r_html ($arr) {
        echo "<pre>";
        print_r($arr);
        echo"</pre>";
}

class PDF extends FPDF {
	function FancyTable($header,$data) {
		//Colors, line width and bold font
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		//Header
		$w=array(15,35,35,25,10);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'L',true);
		$this->Ln();
		//Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Data
		$fill=false;
		for ($i=0;$i<count($data);$i++) {
			$this->Cell($w[0],5,utf8_decode($data[$i][0]),'LR',0,'L',$fill);
			$this->Cell($w[1],5,utf8_decode($data[$i][1]),'LR',0,'L',$fill);
			$this->Cell($w[2],5,utf8_decode($data[$i][2]),'LR',0,'L',$fill);
			$this->Cell($w[3],5,utf8_decode($data[$i][8]),'LR',0,'L',$fill);
			$this->Cell($w[4],5,utf8_decode($data[$i][9]),'LR',0,'L',$fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w),0,'','T');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // POST Request
	$input = file_get_contents("php://input");
	$json = json_decode($input);
	$data = $json->aaData;
	$pdf=new PDF();
	//Column titles
	$header=array('ID','Name','Vorname','Geburtstag','Alter');
	//Data loading
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->FancyTable($header,$data);
	$pdf->Output();
	print_r_html($test);
}
?>
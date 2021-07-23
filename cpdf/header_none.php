<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

	// SET DEFAULT MONOSPACED FONT
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// SET MARGINS
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

	// SET AUTO PAGE BREAKS
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// SET IMAGE SCALE FACTOR
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// SET SOME LANGUAGE-DEPENDENT STRINGS (OPTIONAL)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
		{
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
		}
	// ---------------------------------------------------------

	//SET FONT
	$pdf->SetFont($data['doc_style']['font'], $data['doc_style']['font_style'], $data['doc_style']['font_size']);


	// ADD A PAGE
	$pdf->AddPage();
	$pdf->SetY($doc_style['main_data_padding_top']);
	$pdf->SetY($data['doc_style']['main_data_padding_top']);

?>
<?php
// EXTEND THE TCPDF CLASS TO CREATE CUSTOM HEADER AND FOOTER
class MYPDF extends TCPDF
	{
	//PAGE HEADER
	public function Header()
		{
		$headerData = $this->getHeaderData();
		$this->SetFont('freeserif', '', 10);
		$this->writeHTML($headerData['string']);
		}

	// PAGE FOOTER
	public function Footer()
		{
		// POSITION AT 30 MM FROM BOTTOM
		$this->SetY(-30);
		// SET FONT
		$this->SetFont('freeserif', '', 7);
		// PAGE NUMBER
		include( PATH_MAS . 'pdf.php' );
		ob_clean();
		ob_start(NULL, 0);
			?>
			<table style="width:100%; padding-left:3px;">
				<tr width="16%">
					<td style="background-color:silver; color:white">
					<span style="font-size: 150%;"><?php echo $settings_pdf['company_name']['value'] ?></span>
					<?php
					echo $settings_pdf['company_address']['value'];
					?>
					</td>
					<td width="16%;">
					<?php
					echo $settings_pdf['manager']['name'];
					echo $settings_pdf['manager']['value'];
					?>
					</td>
					<td width="14%" style="border-left: 1px solid red;">
					<?php
					echo $settings_pdf['contacts']['name'];
					echo $settings_pdf['contacts']['value'];
					?>
					</td>
					<td width="14%" style="border-left: 1px solid red">
					<?php
					echo $settings_pdf['bank_info']['name'];
					echo $settings_pdf['bank_info']['value'];
					?>
					</td>
					<td width="26%" style="border-left: 1px solid red">
					BIC код: UNCRBGSF <br>
					Сметка в лева: BG39UNCR700015201063 <br>
					Сметка в евро: BG55UNCR7000152010635 <br>
					</td>
				</tr>
			</table>
			<div style="background-color:red;">
				<span style="font-size: 150%; background-color:white; text-align:right;"> <?php echo $this->getAliasNumPage() . ' от ' . $this->getAliasNbPages() ?> </span>
			</div>

		<?php
		//CLOSE AND OUTPUT PDF DOCUMENT
		$footer = ob_get_contents();
		ob_end_clean();

		$this->writeHTML($footer, false, true, false, true);
		}
	}
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	?>

	<table>
		<tr>
			<td width="80%">
			<?php
			if ( $data['header']['title'] )
				{
				foreach ( $data['header']['title'] as $k => $v )
					{
					?>
						<h1><?php echo $v ?></h1>
					<?php
					}
				}
			else
				{
			?>
				<div></div>
				<div></div>
				<div></div>
			<?php
				}

				foreach ( $data['header']['address'] as $k => $v )
					{
					?>
					<span>&#9899; <?php echo $v ?> </span>
				<?php
					}
				?>
			</td>
			<td width="20%" ><img src="<?php echo $data['header']['logo'] ?>" style="width:100px;" alt=""></td>
		</tr>
	</table>

	<?php
	//CLOSE AND OUTPUT PDF DOCUMENT
	$header = ob_get_contents();
	ob_end_clean();

	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	//HEADER SETTINGS
	$pdf->setHeaderMargin($data['header']['margin_top']);
	$pdf->setHeaderData($ln='', $lw=0, $ht='', $header, $tc=array(0,0,0), $lc=array(0,0,0));

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
	// margins after first page
	$pdf->SetAutoPageBreak(TRUE, 30);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set font
	$pdf->SetFont($data['doc_style']['font'], $data['doc_style']['font_style'], $data['doc_style']['font_size']);

	// add a page
	$pdf->AddPage();

	$pdf->SetY($data['doc_style']['main_data_padding_top']);

?>
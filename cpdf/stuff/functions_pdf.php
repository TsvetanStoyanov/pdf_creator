<?php

// // TITLE TOP
// $data['main']['title'] = 'Плесио Компютърс ЕАД ';
// $data['main']['doc_type'] = $data['doc_type'];
// $data['main']['offer_id'] = 12762;
// $data['main']['created_by'] = 'Кадрие Караахмед';
// $data['main']['project_id'] = 12762;
// $data['main']['date_added'] = '27.01.2021';
function document_desc($data)
	{
	// DELETE THE BUFFER
	ob_clean();
	?>
	<table>
		<tr>
			<td colspan="2">
				<p style="font-size:160%">До: <b><?php echo $data['title'] ?></b></p><br>
			</td>
		</tr>
		<tr>
			<td width="65%">
				<h1><?php echo get_doc_title($data['doc_type']) ?> №: <?php echo $data['offer_id'] ?></h1>
			</td>
			<td width="35%" >
				<div style="font-size:12px">
					<?php echo get_doc_title($data['doc_type']) ?> №: <b><?php echo $data['offer_id'] ?></b><br>
					Съставил: <b><?php echo $data['created_by'] ?></b><br>
					Проект №: <b><?php echo $data['project_id'] ?></b><br>
					Дата: <b><?php echo $data['date_added'] ?></b><br>
				</div>
			</td>
		</tr>
	</table>
	<?php
	//Close and output PDF document
	$document_desc = ob_get_contents();
	ob_end_clean();

	return $document_desc;
	}

function doc_creator($data)
	{
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	// IF USE CUSTOM HEADERS NEEDS ob_start
	ob_start(NULL, 0);
	?>
	<table>
		<tbody>
			<tr>
				<!-- <td width="60%"></td> -->
				<td>С уважение, <br>
					<?php echo $data['doc_creator']['name'] ?><br>
					<?php echo $data['doc_creator']['company_name'] ?><br>
				</td>
				<td></td>

			</tr>
			<tr>
				<td></td>
				<td>/ подпис и печат / </td>
			</tr>
		</tbody>
	</table>
	<?php
	//Close and output PDF document
	$doc_creator = ob_get_contents();
	ob_end_clean();

	return $doc_creator;
	}


function stock_recipe_form()
	{
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	// IF USE CUSTOM HEADERS NEEDS ob_start
	ob_start(NULL, 0);
	?>
	<div>
		Стоката приел /име и фамилия/ :
		<hr>
	</div>
	<table style="border-spacing: 15px;">
		<tbody>
			<tr>
				<td>Стоката приел:</td>
				<td>Стоката предал:</td>
			</tr>
			<tr>
				<td style="text-align:center; font-size: 80%;">/ подпис и печат /</td>
				<td style="text-align:center; font-size: 80%;">/ подпис и печат /</td>
			</tr>
		</tbody>
	</table>
	<?php
	//Close and output PDF document
	$doc_creator = ob_get_contents();
	ob_end_clean();

	return $doc_creator;
	}

	// !
	// //INVOICE DATA
	// $data['main']['recipient_name'] = 'Магнум 7 ООД';
	// $data['main']['recipient_eik'] = 131106675;
	// $data['main']['recipient_vat'] = 'BG';
	// $data['main']['type'] = $data['doc_type'];
	// $data['main']['inv_id'] = 165132165;
	// $data['main']['inv_date'] = '27.01.2021';
	// $data['main']['inv_location'] = 'София';
	// $data['main']['contractor_name'] = 'Монитор 1 МВ ООД';
	// $data['main']['contractor_eik'] = 201579958;
	// $data['main']['contractor_vat'] = 'BG';
	// $data['main']['recipient_address'] = 'София 1618 София бул. Никола Петков 72';
	// $data['main']['client_branch'] = 'Кауфланд';
	// $data['main']['contractor_address'] = 'гр.София, 1303 София, ул. Средна гора 94';
	// $data['main']['contractor_bank'] = 'УниКредит Булбанк';
	// $data['main']['contractor_bic'] = 'UNCRBG';
	// $data['main']['contractor_bank_account'] = 'BG39UNCR70001520106350';


function invoice($data_full, $lang)
	{
	$data = $data_full['main']['top'];
	$doc_lang = $data_full['doc_lang'];
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	// IF USE CUSTOM HEADERS NEEDS ob_start
	ob_start(NULL, 0);

	?>
	<table style="border: 1px solid black;border-spacing: 5px;" >
		<tbody>
			<tr>
				<td style="border-top:1px solid black; border-left:1px solid black; border-right:1px solid black">
				<?php echo $lang[ $doc_lang ][ 'recipient_name' ] ?> <br>
				<b><?php echo $data['recipient_name'] ?></b><br>
				<br>
				<?php echo $lang[ $doc_lang ][ 'recipient_eik' ] ?> <b><?php echo $data['recipient_eik'] ?></b><br>
				<?php echo $lang[ $doc_lang ][ 'recipient_vat' ] ?> <b><?php echo $data['recipient_vat'] . $data['recipient_eik'] ?></b><br>
				</td>
				<td colspan="2" style="text-align:center; border: 1px solid black">
				 	<div style="font-size:150%; border:1px solid black; background-color: #D3D3D3 "><b><?php echo get_doc_title($data['type'])  ?></b></div>
					 <?php echo $lang[ $doc_lang ][ 'inv_id' ] . ' ' . $lang[ $doc_lang ][ 'inv_date' ] ?> <br>
					 <?php echo $data['inv_id'] ?> <?php echo $data['inv_date'] ?> <br>
					 <br>
					 <?php echo $lang[ $doc_lang ][ 'inv_location' ] ?> <b><?php echo $data['inv_location'] ?></b>
				 </td>
				<td style="border-top:1px solid black; border-left:1px solid black; border-right:1px solid black">
					<?php echo $lang[ $doc_lang ]['contractor_name'] ?> <br>
					<b><?php echo $data['contractor_name'] ?></b><br>
					<br>
					<?php echo $lang[ $doc_lang ]['contractor_eik'] ?><b><?php echo $data['contractor_eik'] ?></b><br>
					<?php echo $lang[ $doc_lang ]['contractor_vat'] ?> <b><?php echo $data['contractor_vat'] . $data['contractor_eik'] ?></b><br>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black">

				<?php echo $lang[ $doc_lang ]['recipient_address'] ?> <b><?php echo $data['recipient_address'] ?><br></b>
				<br>
				<?php echo $lang[ $doc_lang ]['client_branch'] ?> <b><?php echo $data['client_branch'] ?></b>

				</td>
				<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black;">
				<?php echo $lang[ $doc_lang ]['contractor_address'] ?> <b><?php echo $data['contractor_address'] ?></b> <br>
				<?php echo $lang[ $doc_lang ]['contractor_bank'] ?> <b><?php echo $data['contractor_bank'] ?></b> <br>
				<?php echo $lang[ $doc_lang ]['contractor_bic'] ?> <b><?php echo $data['contractor_bic'] ?></b> <br>
				<?php echo $lang[ $doc_lang ]['contractor_bank_account'] ?> <b><?php echo $data['contractor_bank_account'] ?></b>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<br>
	<?php
	//Close and output PDF document
	$invoice = ob_get_contents();
	ob_end_clean();
	return $invoice;
	}




// 1 proform
// 2 invoice
// 3 credit
// 4 debit
// 5 order
// 6 offer
// 7 brigade
// 8 stock recipe
function get_doc_title($type)
	{
	$data = array();
	$data[1] = 'Проформа Фактура';
	$data[2] = 'Фактура ОРИГИНАЛ';
	$data[3] = 'Кредитно известие';
	$data[4] = 'Дебит';
	$data[5] = 'Поръчка';
	$data[6] = 'Оферта';
	$data[7] = 'Поръчка към бригада';
	$data[8] = 'Стокова разписка';

	foreach ( $data as $k => $v )
		{
		if ( $type == $k )
			{
			return $v;
			}
		}
	}



	// $data = array();
	// $data['doc_type'] = 6;
	// $data['edit'] = 1;
	// $data['doc_style']['main_data_padding_top'] = 50;
	// $data['doc_style']['font'] = 'freeserif';
	// $data['doc_style']['font_style'] = '';
	// $data['doc_style']['font_size'] = 10;
	// $data['header']['type'] = 1; // 1 with header // 0 no header
	// $data['header']['margin_top'] = 10;
	// $data['header']['logo'] = PATH_ADMIN .'velko' . DS . 'logo.jpg';
	// $data['header']['title'][1] = 'J Willibald GmbH';
	// $data['header']['title'][2] = 'Frau Roswitha Wendland';
	// $data['header']['address'][1] = 'Монитор 1 МВ ООД';
	// $data['header']['address'][2] = '1303 София';
	// $data['header']['address'][3] = 'ул. Средна гора 94';

	// // BRIGADE
	// $data['main']['project_number'] = 165163;
	// $data['main']['project_name'] = 'test';
	// $data['main']['project_name'] = 'test';
	// $data['main']['client_name'] = 'test';
	// $data['main']['branch_id'] = 'test';
	// $data['main']['client_branch_id'] = 'test';
	// $data['main']['client_machinary'] = 'test';
	// $data['main']['client_machinary_id'] = 'test';
	// $data['main']['contact_person'] = 'test';
	// $data['main']['date_deadline'] = 'test';
	// $data['main']['desc'] = 'test';
	// $data['main']['leading'] = 'test';
	// $data['main']['coordinator'] = 'test';
	// $data['main']['mounting_group'] = 'test';
	// $data['main']['estimated_cost'] = 'test';


	// $data['main']['title'] = 'Плесио Компютърс ЕАД ';
	// $data['main']['doc_type'] = $data['doc_type'];
	// $data['main']['offer_id'] = 12762;
	// $data['main']['created_by'] = 'Кадрие Караахмед';
	// $data['main']['project_id'] = 12762;
	// $data['main']['date_added'] = '27.01.2021';


	// $data['table']['field'][0]['article'] = 'Крак Н1070мм, с две муфи, хром';
	// $data['table']['field'][0]['qty'] = 4;
	// $data['table']['field'][0]['unit'] = 14;
	// $data['table']['field'][0]['price'] = 270;

	// $data['table']['field'][1]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['table']['field'][1]['qty'] = 4;
	// $data['table']['field'][1]['unit'] = 16;
	// $data['table']['field'][1]['price'] = 270;

	// $data['table']['field'][2]['article'] = 'Транспорт монтажна група-София-Метро Пловдив 1-София';
	// $data['table']['field'][2]['qty'] = 4;
	// $data['table']['field'][2]['unit'] = 16;
	// $data['table']['field'][2]['price'] = 270;

	// $data['table']['field'][3]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['table']['field'][3]['qty'] = 4;
	// $data['table']['field'][3]['unit'] = 16;
	// $data['table']['field'][3]['price'] = 270;


	// $data['table']['columns'][1]['name'] = 'Стока / Артикулен No';
	// $data['table']['columns'][1]['width'] = 48;
	// $data['table']['columns'][2]['name'] = 'Кол';
	// $data['table']['columns'][2]['width'] = 16;
	// $data['table']['columns'][3]['name'] = 'Ед. цена';
	// $data['table']['columns'][3]['width'] = 16;
	// $data['table']['columns'][4]['name'] = 'Цена';
	// $data['table']['columns'][4]['width'] = 16;
	// $data['table']['settings']['font'] = 12;
	// $data['table']['settings']['hide_numbers'] = 0; // not required
	// $data['table']['settings']['calc_totals'] = 0; // not required
	// $data['table']['settings']['calc_qty'] = 0; // not required

	// $data['main']['billing_address'] = 'гр.София, 1303 София, ул. Средна гора 94';
	// $data['main']['payment_method'] = 2;
	// $data['main']['delivery_time'] = 'след писмена поръчка и допълнителна уговорка';
	// $data['main']['validity'] = '02.04.2021';

	// $data['main']['doc_creator']['name'] = 'Кадрие Караахмед';
	// $data['main']['doc_creator']['company_name'] = 'Монитор 1 МВ ООД';


function create_pdf($data)
	{
	// Include the main TCPDF library (search for installation path).
	require_once(PATH_CORE_LIB . 'tcpdf_new' . DS . 'tcpdf.php');

	// INCLUDE LANG PACK
	include_once( PATH_STUFF . 'cpdf'. DS .'lang.php' );

	//INCLUDE HEADER
	$header_type = ( $data['header']['type'] == 1 ) ? 'header.php' : 'header_none.php' ;
	require_once(PATH_STUFF . 'cpdf' . DS . $header_type );

	// DOCUMENT INFORMATION
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('V Systems LTD');
	$pdf->SetTitle(get_doc_title($data['doc_type']));
	$pdf->SetSubject(get_doc_title($data['doc_type']));
	// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

	// 1 PROFORM
	if ( $data['doc_type'] == 1 )
		{

		}
	// 2 INVOICE 3 CREDIT
	else if ( $data['doc_type'] == 2 || $data['doc_type'] == 3 )
		{
		$data = edit_pdf($data, $lang);
		$html .= invoice($data, $lang);
		$html .= table_creator($data['main']['table']);
		$html .= invoice_signatures($data['main']['top']);
		}
	// 4 DEBIT
	else if ( $data['doc_type'] == 4 )
		{

		}
	// 5 ORDER
	else if ( $data['doc_type'] == 5 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		$html .= document_desc($data['main']['top']);
		$html .= '<div>С настоящото Ви поръчваме съгласно договорените търговски условия, както следва :</div>';
		$html .= table_creator($data['main']['table']);
		$html .= '<br><table>
						<tr>
							<td width="60%">Адрес за фактуриране: ' . $data['main']['billing_address'] . ' <br>
							Моля да ни потвърдите настоящата поръчка</td>
							<td width="40%"></td>
						</tr>
						<tr>
							<td width="60%"></td>
							<td width="40%">' . doc_creator($data['main']) . '</td>
						</tr>
					</table>';
		}

		// 6 offer
	else if ( $data['doc_type'] == 6 )
		{

		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		// PAYMENT METHOTDS
		$payment_method = array();
		$payment_method[1] = 'По банка';
		$payment_method[2] = 'С карта';
		$payment_method[3] = 'В брой';

		foreach ( $payment_method as $k => $v )
			{
			if ( $data['main']['payment_method'] == $k )
				$payment_result = $v;
			}


		$html .= document_desc($data['main']['top']);
		$html .= table_creator($data['main']['table']);

		$html .= '<br><table>
						<tr>
							<td colspan="2">* В офертата не са включени транспортни разходи за доставка на материалите от производител до България. Същите ще Ви бъдат начислени допълнитено, след като производителят ни подаде точните размери на пратката <br><br>
							Предложените цени са НЕТО(без ДДС), в лв. <br>
							Начин на плащане: <b>' . $payment_result . '</b><br>
							Условия за доставка:<b> '. $data['main']['delivery_time'] .' </b><br>
							Валидност:<b> ' . $data['main']['validity'] . '</b><br>
							<div>За допълнителни въпроси сме с удоволствие на Ваше разположение</div>
							</td>
						</tr>
						<tr>
							<td width="60%"></td>
							<td width="40%">' . doc_creator($data['main']) . '</td>
						</tr>
					</table><br>';
		}
		// 7 BRIGADE
	else if ( $data['doc_type'] == 7 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		$html =  brigade($data, $lang);
		}
		// 8 STOCK RECIPE
	else if ( $data['doc_type'] == 8 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);
		$html .= document_desc($data['main']['top']);
		$html .= table_creator($data['main']['table']);
		$html .= stock_recipe_form();

		}
	ob_end_clean();
	// print a block of text using Write()
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->Output('Order_to_the_brigade.pdf', 'I');
	}



?>

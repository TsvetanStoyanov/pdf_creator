<?php
	// $data = array();
	// $data['doc_type'] = 5; // 1 PROFORM / 2 INVOICE / 3 CREDIT / 4 DEBIT / 5 ORDER / 6 OFFER / 7 BRIGADE / 8 STOCK RECIPE
	// $data['edit'] = 1; // ALLOW EDIT BEFORE CREATE PDF
	// $data['doc_lang'] = 'en';
	// $data['doc_style']['main_data_padding_top'] = 50; //PADDING FROM TOP OF THE PAPER
	// $data['doc_style']['font'] = 'freeserif';
	// $data['doc_style']['font_style'] = ''; // b - bold, i - italic
	// $data['doc_style']['font_size'] = 10;
	// $data['header']['type'] = 1; // 1 with header // 0 no header
	// $data['header']['margin_top'] = 10; // ADJUST MARGIN HEADER
	// $data['header']['logo'] = PATH_ADMIN .'velko' . DS . 'logo.jpg';
	// // $data['header']['title'][1] = 'J Willibald GmbH';
	// // $data['header']['title'][2] = 'Frau Roswitha Wendland';
	// $data['header']['address'][1] = 'Монитор 1 МВ ООД';
	// $data['header']['address'][2] = '1303 София';
	// $data['header']['address'][3] = 'ул. Средна гора 94';

	// // TITLE TOP
	// $data['main']['top']['title'] = 'Плесио Компютърс ЕАД ';
	// $data['main']['top']['doc_type'] = $data['doc_type'];
	// $data['main']['top']['offer_id'] = 12762;
	// $data['main']['top']['created_by'] = 'Кадрие Караахмед';
	// $data['main']['top']['project_id'] = 1623;
	// $data['main']['top']['date_added'] = '27.01.2021';

	// // BRIGADE
	// $data['main']['top']['project_number'] = 165163;
	// $data['main']['top']['project_name'] = 'test';
	// $data['main']['top']['project_name'] = 'test';
	// $data['main']['top']['client_name'] = 'Контрагент';
	// $data['main']['top']['client_branch_id'] = 'test321';
	// $data['main']['top']['client_branch'] = 'test123';
	// $data['main']['top']['client_machinary'] = 'test';
	// $data['main']['top']['client_machinary_id'] = 'test';
	// $data['main']['top']['contact_person'] = 'test';
	// $data['main']['top']['date_deadline'] = 'test';
	// $data['main']['top']['desc'] = 'test';
	// $data['main']['top']['leading'] = 'test';
	// $data['main']['top']['coordinator'] = 'test';
	// $data['main']['top']['mounting_group'] = 'test';
	// $data['main']['top']['estimated_cost'] = 'test';

	// // TABLE SETTINGS
	// $data['main']['table']['columns'][1]['name'] = 'Стока / Артикулен No';
	// $data['main']['table']['columns'][1]['width'] = 80;
	// $data['main']['table']['columns'][2]['name'] = 'Кол';
	// $data['main']['table']['columns'][2]['width'] = 17;

	// $data['main']['table']['settings']['font'] = 12;
	// $data['main']['table']['settings']['hide_numbers'] = 0; // not required 1/ width:3%
	// $data['main']['table']['settings']['calc_totals'] = 0; // not required
	// $data['main']['table']['settings']['calc_qty'] = 1; // not required
	// // TABLE DATA
	// $data['main']['table']['field'][0]['article'] = 'Крак Н1070мм, с две муфи, хром';
	// $data['main']['table']['field'][0]['qty'] = 3;

	// $data['main']['table']['field'][1]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['main']['table']['field'][1]['qty'] = 5;

	// $data['main']['table']['field'][2]['article'] = 'Транспорт монтажна група-София-Метро Пловдив 1-София';
	// $data['main']['table']['field'][2]['qty'] = 1;

	// $data['main']['table']['field'][3]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['main']['table']['field'][3]['qty'] = 7;


function cpdf_create($data)
	{
	// INCLUDE THE MAIN TCPDF LIBRARY (SEARCH FOR INSTALLATION PATH).
	require_once(PATH_CORE_LIB . 'tcpdf_new' . DS . 'tcpdf.php');

	// INCLUDE LANG PACK
	include_once( PATH_STUFF . 'cpdf'. DS .'lang.php' );

	//INCLUDE HEADER CUSTOM HEADERS
	if ( $data['header']['type'] )
		{
		$file_name = PATH_ADMIN . DS . 'stuff' . DS . 'cpdf' . DS . 'custom_header_' . $data['header']['type'] . '.php';
		if ( !file_exists($file_name) )
			{
			echo 'cpdf_create() > CANNOT FIND CUSTOM HEADER FILE: ' . $file_name;
			exit;
			}
		require_once($file_name );
		}
	else
		require_once(PATH_CORE . 'cpdf' . DS . 'header_none.php' );

	// DOCUMENT INFORMATION
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('V Systems LTD');
	$pdf->SetTitle(get_doc_title($data['doc_type']));
	$pdf->SetSubject(get_doc_title($data['doc_type']));
	// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');


	// 1 PROFORM 2 INVOICE 3 CREDIT 4 DEBIT
	if ( in_array($data['doc_type'], array(1, 2, 3, 4)) )
		{

		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);


		$html .= invoice($data, $lang);
		$html .= cpdf_table_creator($data['main']['table']);
		$html .= invoice_signatures($data['main']['top']);

		}
	// 5 ORDER
	else if ( $data['doc_type'] == 5 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		$html .= document_desc($data['main']['top']);
		$html .= '<div>С настоящото Ви поръчваме съгласно договорените търговски условия, както следва :</div>';
		$html .= cpdf_table_creator($data['main']['table']);
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
		// 6 OFFER
	else if ( $data['doc_type'] == 6 )
		{

		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		// PAYMENT METHOTDS
		$payment_method = array();
		$payment_method[1] = 'В брой';
		$payment_method[2] = 'По банка';
		$payment_method[3] = 'С карта';
		$payment_method[4] = 'EasyPay';

		foreach ( $payment_method as $k => $v )
			{
			if ( $data['main']['payment_method'] == $k )
				$payment_result = $v;

			}


		$html .= document_desc($data['main']['top']);
		$html .= cpdf_table_creator($data['main']['table']);

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
							<td width="40%">' . doc_creator($data['main']['doc_creator']) . '</td>
						</tr>
					</table><br>';
		}
		// 7 STOCK RECIPE
	else if ( $data['doc_type'] == 7 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		$html .= document_desc($data['main']['top']);
		$html .= cpdf_table_creator($data['main']['table']);
		$html .= stock_recipe_form();
		}
		// 8 BRIGADE
	else if ( $data['doc_type'] == 8 )
		{
		if ( $data['edit'] == 1 )
			$data = edit_pdf($data, $lang);

		$html =  brigade($data, $lang);

		}
	ob_end_clean();
	// print a block of text using Write()
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->Output('Order_to_the_brigade.pdf', 'I');
	}

	// // TABLE SETTINGS
	// $data['main']['table']['columns'][1]['name'] = 'Стока / Артикулен No';
	// $data['main']['table']['columns'][1]['width'] = 48;
	// $data['main']['table']['columns'][2]['name'] = 'Кол';
	// $data['main']['table']['columns'][2]['width'] = 16;
	// $data['main']['table']['columns'][3]['name'] = 'Ед. цена';
	// $data['main']['table']['columns'][3]['width'] = 16;
	// $data['main']['table']['columns'][4]['name'] = 'Цена';
	// $data['main']['table']['columns'][4]['width'] = 16;
	// $data['main']['table']['settings']['font'] = 12;
	// $data['main']['table']['settings']['hide_numbers'] = 0; // not required
	// $data['main']['table']['settings']['calc_totals'] = 1; // not required
	// $data['main']['table']['settings']['calc_qty'] = 1; // not required
	// // TABLE DATA
	// $data['main']['table']['field'][0]['article'] = 'Крак Н1070мм, с две муфи, хром';
	// $data['main']['table']['field'][0]['qty'] = 4;
	// $data['main']['table']['field'][0]['unit'] = 14;
	// $data['main']['table']['field'][0]['price'] = 270;

	// $data['main']['table']['field'][1]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['main']['table']['field'][1]['qty'] = 4;
	// $data['main']['table']['field'][1]['unit'] = 16;
	// $data['main']['table']['field'][1]['price'] = 270;

	// $data['main']['table']['field'][2]['article'] = 'Транспорт монтажна група-София-Метро Пловдив 1-София';
	// $data['main']['table']['field'][2]['qty'] = 4;
	// $data['main']['table']['field'][2]['unit'] = 16;
	// $data['main']['table']['field'][2]['price'] = 270;

	// $data['main']['table']['field'][3]['article'] = 'Играждане на парапет с дължина 10,5м на "Вход-Клиенти"';
	// $data['main']['table']['field'][3]['qty'] = 4;
	// $data['main']['table']['field'][3]['unit'] = 16;
	// $data['main']['table']['field'][3]['price'] = 270;

function cpdf_table_creator($data)
	{
	include( PATH_CORE . 'number_functions.php' );

	$html = '';
	$html .= '<table style="border-top: 1px solid black; border-bottom: 1px solid black; font-size:'. $data['settings']['font'] .'px; width:100%;">';
	$html .= '<tr>';
	if ( !$data['settings']['hide_numbers'] )
		$html .= '<th style="border-bottom: 1px solid black;width:3%">№</th>';

	foreach ( $data['columns'] as $k => $v )
		{
		$html .= '<th style=" border-bottom: 1px solid black;width:' . $v['width'] . '%">' . $v['name'] . '</th>';
		}
	$html .= '</tr>';

	$i = 1;

	if ( $data['settings']['calc_totals'] )
		{
		$total_no_vat = 0;
		$vat = 0.20;
		}

	// GET ALL PRODUCTS
	if ( $data['field'] )
		{
		foreach ( $data['field'] as $product_key => $product_data )
			{
			$html .= '<tr>';
			if ( !$data['settings']['hide_numbers'] )
				{
				$html .= '<td>' . $i . '</td>';
				$i++;
				}
			// CALC PRICE
			$total_no_vat += $product_data['price'];
			// CALC QTY
			$total_qty += $product_data['qty'];

			foreach ( $product_data as $k => $v )
				{
				$html .= '<td>' . $v . '</td>';
				}
			$html .= '</tr>';
			}
		}

	$html .= '</table>';
	if ( $data['settings']['calc_totals'] )
		{
		$vat_result = number_format((float)$total_no_vat * $vat, 2, '.','');
		$total = number_format((float) $total_no_vat + $vat_result, 2, '.','');
		$html .= '<div style="text-align:right">ДАНЪЧНА ОСНОВА: '. number_format((float)$total_no_vat, 2, '.','')  .' <br>
		ДДС 20%: ' . $vat_result . '<br>
		ОБЩА СТОЙНОСТ: '. $total .' <hr>
		</div>'. 'Словом: ' . toSlovom($total, $Gender, $caps) .'<br>';
		}

	if ( $data['settings']['calc_qty'] )
		$html .= 'Сумарно количество: '. $total_qty .' <br>';


	return $html;
	}


// EDIT ALL INPUTS BEFORE CREATING PDF
function edit_input_create($data_inputs)
	{
		global $invoice, $log;
	$doc_lang = $data_inputs['doc_lang'];
	$lang_data = $data_inputs['lang_data'];
	$key = $data_inputs['key'];

	foreach ( $data_inputs['inputs'] as $k => $v )
		{
		// HIDE/MODIFY FIELDS
		?>
		<fieldset class=" autosize left <?php echo ( $k == 'type' || $k == 'doc_type' ) ? 'hide' : '' ; ?>">
			<legend><?php echo $lang_data[ $doc_lang ][ $k ] ?></legend>
			<?php
			if ( $k == 'note' )
				{
				?>
				<textarea name="<?php echo $key ?>[<?php echo $k ?>]" rows="2"  ><?php echo $v ?></textarea>
				<?php
				}
			else
				{
				?>
				<input name="<?php echo $key ?>[<?php echo $k ?>]" value="<?php echo $v ?>" class="calc" style="margin: -10px;" type="text">
				<?php
				}
			?>
		</fieldset>
		<?php
		}
	}
// EDIT ALL INPUTS SAVE
function edit_input_save($data, $key)
	{
	if ( $_POST[ $key ] )
		{
		foreach ( $data as $k => $v )
			{
			$data[ $k ] = $_POST[ $key ][ $k ];
			}
		}
	return $data;
	}

// EDIT ALL IMPUTS AND TABLES BEFORE CREATING PDF
function edit_pdf($data_all, $lang)
	{
	$data = $data_all['main'];
	$doc_lang = $data_all['doc_lang'];

	if ( !$_POST['go'] )
		{
		?>
		<head>
			<link href="/public/_core/libraries/roboto/roboto.css" rel="stylesheet">
			<link rel="stylesheet" href="/public/_core/libraries/pure-release-1.0.0/pure-min.css">
			<link type="text/css" href="/public/_core/frame.css" rel="stylesheet">
			<link rel="stylesheet" href="/public/_core/admin.css">
			<link rel="stylesheet" href="/public/_core/libraries/fontawesome-free-5.15.2-web/css/all.min.css">
		</head>

		<script type="text/javascript">
		function close_tap()
			{
			window.close()
			}
		</script>

		<div class="box" >

		<h2 class="center"><?php echo get_doc_title($data_all['doc_type']) ?></h2>

			<form method="POST" action="" enctype="multipart/form-data">
				<?php

				// TOP INPUTS
				$data_inputs = array();
				$data_inputs['lang_data'] = $lang;
				$data_inputs['doc_lang'] = $doc_lang;
				$data_inputs['key'] = 'top';
				$data_inputs['inputs'] = $data[ $data_inputs['key'] ];

				edit_input_create( $data_inputs );

				// GENERATE TABLE PRODUCTS
				if ( is_array($data['table']['columns']) AND is_array($data['table']['field']) )
					{
					?>
					<table width="100%" id="XXXXXX" class="XXXXXX" border="1">
					<caption><b>Продукти</b></caption>
						<thead>
							<tr>
						<?php
						// TABLE COLUMNS
						foreach ( $data['table']['columns'] as $column_key => $column_data )
							{
							?>
							<th width="<?php echo $column_data['width'] ?>%"><?php echo $column_data['name'] ?></th>
							<?php
							}
							?>
							</tr>
						</thead>
						<tbody>
						<?php
						// TABLE ROWS
						foreach ( $data['table']['field'] as $row_key => $row_data )
							{
							echo '<tr>';
							foreach ( $row_data as $field_name => $value )
								{
								//NOT EDITABLE PRICE
								$readonly = ( $field_name == 'price' ) ? 'readonly' : '' ;
								?>
								<td>
									<input name="table[<?php echo $row_key ?>][<?php echo $field_name ?>]" value="<?php echo $value ?>" <?php echo $readonly ?> style="width:100%" type="text" >
								</td>
								<?php
								}
							echo '</tr>';
							}
						?>
						</tbody>
					</table>
					<?php
					}
				?>
				<button name="go" id="go" class="pure-button btn_save" value="<?php echo $data_all['doc_id'] ?>" type="submit"><i class="fas fa-file-pdf"></i> Създай PDF</button> /
				<a class="pure-button btn_delete" onclick="close_tap()"><i class="fa fa-backward mr10"></i> Обратно</a>
			</form>
		</div>
		<?php
		exit;
		}
	else
		{
		// MAIN > TOP
		$data['top'] = edit_input_save($data['top'], 'top');

		if ( $_POST['table'] )
			{
			foreach ( $_POST['table'] as $row_key => $row_data )
				{
				foreach ( $row_data as $field_name => $v )
					{
					$data['table']['field'][ $row_key ][ $field_name ] = $_POST['table'][ $row_key ][ $field_name ];
					}
				}
			}
		$data_all['main'] = $data;
		return $data_all;
		}
	}
?>
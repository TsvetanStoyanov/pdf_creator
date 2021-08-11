<?php

require_once(PATH_CORE . 'cpdf' . DS . 'cpdf_core.php' );
require_once(PATH_CORE . 'cpdf' . DS . 'cpdf_docs.php' );

require_once(PATH_CORE_CLASSES . 'class.invoice.php' );
require_once(PATH_CORE_CLASSES . 'class.client.php' );
require_once(PATH_CORE_CLASSES . 'class.project.php' );

require_once(PATH_MAS . 'pdf.php' );


if ( $_POST['go'] )
	$_GET['doc_id'] = $_POST['go'];
// SECURE
$_GET['doc_id'] = (int)$_GET['doc_id'];



if ( $_GET['doc_id'] )
	{
	// get doc from db
	$invoice->load($_GET['doc_id']);

	// CONVERT DATE
	$data_date = array();
	$data_date['from'] = 'Y-m-d';
	$data_date['date'] = $invoice->prop('date_issued');
	$data_date['to'] = 'd.m.Y';
	$converted_date = date_convert($data_date);

	// CONVERT ID TO NAME CLIENT
	$client_data = $invoice->get_foreign('client', 'client_id');

	$products_db = $invoice->unzip_data($_GET['doc_id']);

	// PREPARE $data
	$data = array();
	$data['doc_id'] = $invoice->prop('id');
	$data['doc_type'] = $invoice->prop('type');
	$data['edit'] = $invoice->prop('edit');
	$data['doc_lang'] = $invoice->prop('lang');

// d($invoice->prop('lang'), 1);

	$data['doc_style']['main_data_padding_top'] = 50;
	$data['doc_style']['font'] = 'freeserif';
	$data['doc_style']['font_style'] = '';
	$data['doc_style']['font_size'] = 10;

	if ( $invoice->prop('type') == 5 || $invoice->prop('type') == 6 )
		$data['header']['type'] = 1; // 1 with header // 0 no header;
	else
		$data['header']['type'] = 0;

	$data['header']['margin_top'] = 10;
	$data['header']['logo'] = PATH_ADMIN .'velko' . DS . 'logo.jpg';
	// $data['header']['title'][1] = 'J Willibald GmbH';
	// $data['header']['title'][2] = 'Frau Roswitha Wendland';
	$data['header']['address'][1] = 'Монитор 1 МВ ООД';
	$data['header']['address'][2] = '1303 София';
	$data['header']['address'][3] = 'ул. Средна гора 94';

	$data['main']['payment_method'] = $invoice->prop('payment_method');

	// TITLE TOP
	if ( in_array($invoice->prop('type'), array(1, 2, 3, 4)) )
		{
		$data['main']['top']['inv_location'] = $invoice->prop('deal_location');
		$data['main']['top']['contractor_name'] = $settings_pdf['company_eik']['value'];
		$data['main']['top']['contractor_eik'] = $settings_pdf['company_vat']['value'];

		$data['main']['top']['type'] = $data['doc_type'];
		$data['main']['top']['inv_id'] = $_GET['doc_id'];
		$data['main']['top']['inv_date'] = $converted_date;

		$data['main']['top']['recipient_name'] = $client_data['name'];
		$data['main']['top']['recipient_eik'] = $invoice->prop('client_name');
		$data['main']['top']['recipient_vat'] = $invoice->prop('client_uic');

		$data['main']['top']['recipient_address'] = $invoice->prop('client_address');
		$data['main']['top']['client_branch'] = $invoice->client_branch_name($_GET['doc_id']);
		$data['main']['top']['note'] = $invoice->prop('note');

		$data['main']['top']['contractor_vat'] = 'BG';
		$data['main']['top']['contractor_address'] = $settings_pdf['full_address']['value'];
		$data['main']['top']['contractor_bank'] = $settings_pdf['bank']['value'];
		$data['main']['top']['contractor_bic'] = $settings_pdf['bic']['value'];
		$data['main']['top']['contractor_bank_account'] = $settings_pdf['bank_id']['value'];
		}
	else if ( in_array($invoice->prop('type'), array(5, 6, 7)) )
		{
		$data['main']['top']['title'] = $client_data['name'];
		$data['main']['top']['doc_type'] = $data['doc_type'];
		$data['main']['top']['offer_id'] = $_GET['doc_id'];
		$data['main']['top']['created_by'] = $invoice->prop('issued_by_user');
		$data['main']['top']['project_id'] = $invoice->prop('number');
		$data['main']['top']['date_added'] = $converted_date;
		$data['main']['top']['client_name'] = $invoice->prop('client_name');
		}



	// TABLE SETTINGS
	if ( in_array($invoice->prop('type'), array(1, 2, 3, 4, 5, 6)) )
		{
		$column_1_width = 70;
		$column_2_width = 10;
		$column_3_width = 10;
		$column_4_width = 10;
		}
	else
		{
		$column_1_width = 85;
		$column_2_width = 15;
		}




	$data['main']['table']['columns'][1]['name'] = 'Стока / Артикулен No';
	$data['main']['table']['columns'][1]['width'] = $column_1_width;
	$data['main']['table']['columns'][2]['name'] = 'Кол';
	$data['main']['table']['columns'][2]['width'] = $column_2_width;

	// ADD ROWS IN TABLE ON 1 Proforma, 2 invoice, 3 credit, 4 debit, order
if ( in_array($invoice->prop('type'), array(1, 2, 3, 4, 5, 6)) )
	{
	$data['main']['table']['columns'][3]['name'] = 'Ед.цена';
	$data['main']['table']['columns'][3]['width'] = $column_3_width;
	$data['main']['table']['columns'][4]['name'] = 'Обща цена';
	$data['main']['table']['columns'][4]['width'] = $column_4_width;
	}

	$data['main']['table']['settings']['font'] = 12;
	$data['main']['table']['settings']['hide_numbers'] = 0; // not required 1/ width:3%

	// SHOW TOTAL PRICE
if ( in_array($invoice->prop('type'), array(1, 2, 3, 4, 5, 6)) )
	$data['main']['table']['settings']['calc_totals'] = 1; // not required
else
	$data['main']['table']['settings']['calc_totals'] = 0; // not required


	$data['main']['table']['settings']['calc_qty'] = 1; // not required

	// SHOW PRODUCTS IN TALBE
	foreach ( $products_db['products'] as $k => $v )
		{
		$data['main']['table']['field'][$k]['article'] = $v['name'];
		$data['main']['table']['field'][$k]['qty'] = $v['qty'];

		// if ( in_array($invoice->prop('type'), array(1, 2, 3, 4, 5, 6)) )
		if ( $invoice->prop('type') != 7 )
			{
			$data['main']['table']['field'][$k]['price_single'] = $v['price_single'];
			$data['main']['table']['field'][$k]['price'] = $v['price'];
			}
		}

	// DISCOUNT
	$data['main']['table']['discount'] = $invoice->prop('discount');
	$data['main']['table']['total_after_discount'] = $invoice->prop('total_after_discount');



	if ( $invoice->prop('type') == 6 )
		{
		$data['main']['doc_creator']['name'] = $invoice->prop('issued_by_user');
		$data['main']['doc_creator']['company_name'] = 'Монитор 1 МВ ООД';
		}
// d($data, 1);
	cpdf_create($data);

	}
?>
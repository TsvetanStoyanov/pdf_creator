<?php
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
	$data[7] = 'Стокова разписка';
	$data[8] = 'Поръчка към бригада';

	foreach ( $data as $k => $v )
		{
		if ( $type == $k )
			{
			return $v;
			}
		}
	}

	// $doc = array();
	// $doc['doc_creator']['name'] = 'Кадрие Караахмед';
	// $doc['doc_creator']['company_name'] = 'Монитор 1 МВ ООД';

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
				<td>С уважение, <br>
					<?php echo $data['name'] ?><br>
					<?php echo $data['company_name'] ?><br>
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



// // TITLE TOP
// $data['main']['title'] = 'Плесио Компютърс ЕАД ';
// $data['main']['doc_type'] = $data['doc_type'];
// $data['main']['offer_id'] = 12762;
// $data['main']['created_by'] = 'Кадрие Караахмед';
// $data['main']['project_id'] = 12762;
// $data['main']['date_added'] = '27.01.2021';
function document_desc($data)
	{
	// d($data, 1);
	// DELETE THE BUFFER
	ob_clean();

	?>
	<table>
		<tr>
			<td colspan="2">
				<p style="font-size:160%">До: <b><?php echo $data['title'] ?></b><br>На вниманието на: <?php echo $data['client_name'] ?></p>
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
	//CLOSE AND OUTPUT PDF DOCUMENT
	$doc_creator = ob_get_contents();
	ob_end_clean();

	return $doc_creator;
	}

	// //INVOICE DATA
	// $data['main']['top']['recipient_name'] = 'Магнум 7 ООД';
	// $data['main']['top']['recipient_eik'] = 131106675;
	// $data['main']['top']['recipient_vat'] = 'BG';
	// $data['main']['top']['type'] = $data['doc_type'];
	// $data['main']['top']['inv_id'] = 165132165;
	// $data['main']['top']['inv_date'] = '27.01.2021';
	// $data['main']['top']['inv_location'] = 'София';
	// $data['main']['top']['contractor_name'] = 'Монитор 1 МВ ООД';
	// $data['main']['top']['contractor_eik'] = 201579958;
	// $data['main']['top']['contractor_vat'] = 'BG';
	// $data['main']['top']['recipient_address'] = 'София 1618 София бул. Никола Петков 72';
	// $data['main']['top']['client_branch'] = 'Кауфланд';
	// $data['main']['top']['contractor_address'] = 'гр.София, 1303 София, ул. Средна гора 94';
	// $data['main']['top']['contractor_bank'] = 'УниКредит Булбанк';
	// $data['main']['top']['contractor_bic'] = 'UNCRBG';
	// $data['main']['top']['contractor_bank_account'] = 'BG39UNCR70001520106350';

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
				<?php echo $lang[ $doc_lang ][ 'recipient_vat' ] ?> <b><?php echo $data['recipient_vat'] ?></b><br>
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


	// $data = array();
	// $data['date_event'] = '32.01.2021';
	// $data['payment_method'] = 'По сметка';
	// $data['payment_term'] = '10.06.2021';
	// $data['recipient'] = 'Тройчо Кораков';

function invoice_signatures($data)
	{
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	// IF USE CUSTOM HEADERS NEEDS ob_start
	ob_start(NULL, 0);
	?>
	<br>
	<table border="0">
		<tbody>
			<tr>
				<td colspan="4">Дата на данъчното събитие <b><?php echo $data['date_event'] ?></b> </td>
			</tr>
			<tr>
				<td colspan="4">Начин на плащане: <b><?php echo $data['payment_method'] ?></b> </td>
			</tr>
			<tr>
				<td colspan="4">Срок за плащане <b><?php echo $data['payment_term'] ?></b><br> </td>
			</tr>
			<tr>
				<td colspan="2">
					<b>За получателя:</b><br>
					<span style="font-size:70%">Подпис на лицето, отговорно _____________________</span> <br>
					<span style="font-size:70%">за осъществяването на <b style="font-size: 130%"> <?php echo $data['recipient'] ?></b> <br>
						стопанската операция:  <br>
						<div style="text-align:center">_____________________</div>
					</span>
				</td>
				<td colspan="2">
					<br>
					<b>За изпълнителя:</b><br>
					<span style="font-size:70%">Подпис на лицето, отговорно _____________________</span> <br>
					<span style="font-size:70%">за осъществяването на <b style="font-size: 130%"> <?php echo $data['contractor'] ?></b> <br>
						стопанската операция:  <br>
						<div style="text-align:center">_____________________</div>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	//Close and output PDF document
	$sign_result = ob_get_contents();
	ob_end_clean();
	return $sign_result;
	}

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

function brigade($data, $lang)
	{
	// SET SOME TEXT TO PRINT
	// DELETE THE BUFFER
	ob_clean();
	// IF USE CUSTOM HEADERS NEEDS ob_start
	ob_start(NULL, 0);
	?>
	<div><?php echo get_doc_title($data['doc_type']) ?></div>
	<div>
		<?php echo $lang[$data['doc_lang']]['project_id'] ?>  <b> <?php echo $data['main']['top']['project_number'] ?> </b><br>
		<?php echo $lang[$data['doc_lang']]['project_name'] ?> <b> <?php echo $data['main']['top']['project_name'] ?> </b><br>
		<?php echo $lang[$data['doc_lang']]['project_reason'] ?> <b> <?php echo $data['main']['top']['project_name'] ?> </b>
	</div>
	<div>
		<?php echo $lang[$data['doc_lang']]['client_name'] ?> <b><?php echo $data['main']['top']['client_name'] ?></b> <br>
		<table width="100%" border="0">
			<tr>
				<td width="30%" > <?php echo $lang[$data['doc_lang']]['client_branch_id'] ?> <b><?php echo $data['main']['top']['client_branch_id'] ?></b></td>
				<td width="70%"><?php echo $lang[$data['doc_lang']]['client_branch_name'] ?> <b><?php echo $data['main']['top']['client_branch'] ?></b></td>
			</tr>
		</table>

	<?php echo $lang[$data['doc_lang']]['client_machinary'] ?> <b><?php echo $data['main']['top']['client_machinary'] ?></b><br>
	<?php echo $lang[$data['doc_lang']]['client_machinary_id'] ?> <b><?php echo $data['main']['top']['client_machinary_id'] ?></b><br>
	<?php echo $lang[$data['doc_lang']]['contact_person'] ?><b><?php echo $data['main']['top']['contact_person'] ?></b>
	</div>

	<div>
		<?php echo $lang[$data['doc_lang']]['date_deadline'] ?> <b><?php echo $data['main']['top']['date_deadline'] ?></b><br>
		<?php echo $lang[$data['doc_lang']]['desc'] ?> <br>
		<b><?php echo $data['main']['top']['desc'] ?></b><br>
	</div>

	<div>
		<table width="100%" border="0">
			<tr>
				<td><?php echo $lang[$data['doc_lang']]['leading'] ?> <b><?php echo $data['main']['top']['leading'] ?></b></td>
				<td><?php echo $lang[$data['doc_lang']]['coordinator'] ?> <b><?php echo $data['main']['top']['coordinator'] ?></b></td>
			</tr>
		</table>
		<br>
		<?php echo $lang[$data['doc_lang']]['mounting_group'] ?><br>
		<b><?php echo $data['main']['top']['mounting_group'] ?></b><br>
		<?php echo $lang[$data['doc_lang']]['estimated_cost'] ?> <b><?php echo $data['main']['top']['estimated_cost'] ?></b>
	</div>

	<?php
	//Close and output PDF document
	$brigade_result = ob_get_contents();
	// d($brigade_result, 1);
	ob_end_clean();
	return $brigade_result;
	}



?>
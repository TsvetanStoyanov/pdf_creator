var $counter = 0;
var $total_row = 0;
var $calc = {};




function calc()
	{
	$calc = {};
	$calc.total_no_vat = 0;

	var $elements = $('.products_rows');
	$.each($elements, function($k, $v)
		{
		var $tr_id = $( $v ).prop('id');
		var $row_id = pstr_replace('product_row_', '', $tr_id);
		var $total_row_no_vat = pfloat( $('#product_qty_' + $row_id).val() ) * pfloat( $('#product_price_single_' + $row_id).val() );
		$calc.total_no_vat += $total_row_no_vat;

		$('#product_price_' + $row_id).val( $total_row_no_vat.toFixed(2) );
		});

	// calc with/out vat
	calc_totals();


	// FILL TABLE AND INPUTS
	$('#vat_amount_js').html( $calc.vat_amount.toFixed(2) );
	$('#total_no_vat').val( $calc.total_no_vat.toFixed(2) );
	$('.total_no_vat_html').html( $calc.total_no_vat.toFixed(2) );
	$('#total_vat_js').html( $calc.total_with_vat.toFixed(2) );

	// CONVERT NUMBER TO WORDS PRICE
	$total_in_numbers = toSlovomLeva($calc.total_with_vat, 0);

	$total_in_words = pstr_replace('currency', $('#currency option:selected').html(), $total_in_numbers)

	if ( $('#currency option:selected').val() == 1 )
		$total_in_words = pstr_replace('coins', 'стотинки', $total_in_words).toLowerCase();
	else if ( $('#currency option:selected').val() == 2 )
		$total_in_words = pstr_replace('coins', 'цента', $total_in_words).toLowerCase();
	else if ( $('#currency option:selected').val() == 3 )
		$total_in_words = pstr_replace('coins', 'евроцента', $total_in_words).toLowerCase();

	$('#total_with_words').html( $total_in_words );
	}

function calc_totals()
	{
	// CALC PERCENTAGES
	$calc.vat_percent = pfloat($('#vat_percent').val()) / 100;

	// DISCOUNT
	$calc.total_no_vat_discount = calc_discount($calc.total_no_vat);
	$calc.vat_amount = $calc.total_no_vat_discount * $calc.vat_percent;

	$calc.total_with_vat = $calc.total_no_vat_discount + $calc.vat_amount;

	$('input[name="vat_amount"]').val( $calc.vat_amount.toFixed(2) );
	$('input[name="total_amount"]').val( $calc.total_with_vat.toFixed(2) );
	$('input[name="total_after_discount"]').val( $calc.total_with_vat.toFixed(2) );

	}

function calc_discount($total_no_vat)
	{
	var $discount = pfloat( $('#discount').val() );
	if ( !$discount )
		return $total_no_vat;

	var $discount_type = $( "#discount_type" ).val();

	if ( $discount_type == '1' ) // PERCENT
		return $total_no_vat * ( 1 - ($discount / 100) );
	else if ( $discount_type == '2' ) // AMOUNT
		return $total_no_vat - $discount;

	alert('calc_discount() > $discount_type is wrong');
	}

// ADD NEW PRODUCT ROW IN TABLE
function project_add_row($data = 0)
	{
	var $template = $('#project_template').html();
	$counter++;

	// REPLACE TAGS FROM TEMPLATE
	var $table_row = pstr_replace('{row}', $counter, $template);
	$table_row = pstr_replace('{tr_class}', 'products_rows', $table_row);

	$table_row = pstr_replace('{operations}', '<i class="fas fa-trash"></i>', $table_row);

	if ( $data )
		{
		$table_row = pstr_replace('{name}', $data.name, $table_row);
		$table_row = pstr_replace('{qty}', $data.qty, $table_row);
		$table_row = pstr_replace('{price_single}', $data.price_single, $table_row);
		$table_row = pstr_replace('{price}', $data.price, $table_row);
		}
	else
		{
		$table_row = pstr_replace('{name}', '', $table_row);
		$table_row = pstr_replace('{qty}', '', $table_row);
		$table_row = pstr_replace('{price_single}', '', $table_row);
		$table_row = pstr_replace('{price}', '', $table_row);
		}

	$("#project_body").append($table_row);
	bind_calc();
	}

function bind_calc()
	{
	$(document).delegate(".calc", "change keyup", function(event)
		{
		calc();
		calc_totals();
		});
	}
function project_add_row_click()
	{
	project_add_row();
	calc();
	}
function project_delete_row($id)
	{
	$('#product_row_' + $id).remove();
	calc();
	}
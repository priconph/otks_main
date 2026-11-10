/* Note: you need to call jquery or other library for these to work */

/* Call basic ajax for submit */
function call_ajax(data, handler, fn) {
    data = $.param(data);
    $.ajax({
        type: "post",
        dataType: "json",
        data: data,
        url: handler,
        success: function (result) {
            fn(result);
        },
        error: function (result) {
            alert('error ajax');
        }
    });
}

function call_ajax_serialize(data, serialized_data, handler, fn) {
    data = $.param(data) + '&' + serialized_data;
    $.ajax({
        type: "post",
        dataType: "json",
        data: data,
        url: handler,
        success: function (result) {
            fn(result);
        },
        error: function (result) {
            alert('error ajax');
        }
    });
}

function create_table(table_id, table_class, array_theader, array_tbody) {
    var html = '<table id="' + table_id + '" class="' + table_class + '">';
    /* Generate table header */
	html += '	<thead>';
	for(x=0;x<array_theader.length;x++){
		html += '	<th>' + array_theader[x] + '</th>';
    }
	html += '	</thead>'
	/* Generate table body */
	html += '	<tbody>';
	for(x=0;x<array_theader.length;x++){
		html += '	<td>' + array_tbody[x] + '</td>';
    }
	html += '	</tbody>';
	html += '</table>';
	return html;
}

/* kulang pa ito need mo i return as array para yun na yung magiging value nung global na array. saka mo na ayusin */
function add_remove_check_uncheck_value(table_id,chk_box_class,array_name,value){
	$('#'+table_id+' tbody tr').each(function(){
		if($(this).find('td:eq(0) .'+chk_box_class).prop('checked')){
			/* check if checked values exist on array, add if not exist */
			var value = $(this).find('td:eq(1)').text();
			// var check_exist = jQuery.inArray(new_empno,array_name);
			var check_exist = check_exist_on_array(value,array_name);
			if(check_exist != 1){
				array_name.push(value);
			}
		}else{
			/* check if none checked values exist on array, remove if it exist */
			var value = $(this).find('td:eq(1)').text();
			remove_array_value(value,array_name);
		}
	});
}

function check_exist_on_array(value,array_name){
	for(x=0;x<array_name.length;x++){
		if(value == array_name[x]){
			return 1;
		}
	}
	return 0;
}

function remove_array_value(removeItem,array_name){
	array_name = jQuery.grep(array_name, function(value) {
	  return value != removeItem;
	});
}


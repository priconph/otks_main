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
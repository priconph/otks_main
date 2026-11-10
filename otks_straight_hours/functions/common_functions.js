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
            // alert('error ajax');
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
            // alert('error ajax');
        }
    });
}


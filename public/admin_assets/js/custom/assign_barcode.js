$(function() {
    var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);
});


flatpickr("#date_range", {
    mode: "range",
    onChange:function(){
        var date_range = $('#date_range').val();
    }
});

if ($.fn.DataTable.isDataTable('#assign_barcode')) {
    $('#assign_barcode').DataTable().destroy();
}

var table = $('#assign_barcode').DataTable({
    processing: true,
    serverSide: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    ajax : {
        url:  site_url + "admin/barcode",
        method: "get",
        data: function(d) {
            d.date_range = $('#date_range').val();
        }
    },
    columns: [
        { data: 'row', name: 'row',
            render: function(data, type, row, meta)
            {
                return meta.row + 1;
            }
        },
        { data: 'assign_to', name: 'assign_to' },
        { data: 'wheeler_type', name: 'wheeler_type' },
        { data: 'count', name: 'count' },
        { data: 'created_at', name: 'created_at' },
        { data: 'downlaod', name: 'downlaod' },
    ],
    pageLength : 10,
    rowCallback: function(row, data, index) {
        var api = this.api();
        var pageNumber = api.page.info().page;
        var rowIndex = index + 1 + pageNumber * api.page.len();
        $('td:eq(0)', row).html(rowIndex);
    }
});

$('.filter').click(function refreshData() {
    table.ajax.reload();
});

$('#wheeler_type,#assign_to').change(function () {
    checkcount();
});

$("#barcode_frm").validate({
    rules: {
        assign_to: {
            required: true
        },
        status: {
            required: true,
        },
        count: {
            required: true,
        },
    },
    messages: {
        assign_to: {
            required: "Please select user",
        },
        status: {
            required: "Please select status",
        },
        count: {
            required: "Please enter total barcode",
        }
    },

    submitHandler: function(form) {
        form.submit();
    }
});

$(document).ready(function() {
    $('#count').on('input', function() {
        var maxLimit = $('#total_barcode').val();
        var enteredValue = parseInt($(this).val());
        if (enteredValue > maxLimit) {
            $(this).val('');
        }
    });

    $('#assign_to').change(function() {
        var selectedUserRole = $(this).find('option:selected').data('role');
        if (selectedUserRole === 'FRANCHISE_PARTNER') {
            $('#priceInput').show();
        } else {
            $('#priceInput').hide();
        }
    });
});

function checkcount()
{
    $assign_to = $('#assign_to').val();
    $wheeler_type = $('#wheeler_type').val();
    $.ajax({
        url: site_url + 'admin/barcode_total',
        method: "POST",
        data : {
            'assign_to' : $assign_to,
            'wheeler_type' : $wheeler_type
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var TotalBarcode = response.TotalBarcode;
            $('#total_barcode').val(TotalBarcode);
            if(( TotalBarcode != 0 )){
                $("#barcode_msg").text("Barcode Available - "+TotalBarcode+" ");
                $("#barcode_msg").show();
                $("#assign_btn"). attr("disabled", false);
                $("#count").removeAttr( "disabled" );
            }else{
                $("#barcode_msg").text("Out of Stock");
                $("#barcode_msg").show();
                $("#assign_btn"). attr("disabled", true);
                $("#count").attr("disabled", "disabled");
            }
        }
    });
}

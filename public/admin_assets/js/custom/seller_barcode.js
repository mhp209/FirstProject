$(document).ready(function(){
    if ($.fn.DataTable.isDataTable('#seller_barcode_table')) {
        $('#seller_barcode_table').DataTable().destroy();
    }

    var seller_barcode_table = $('#seller_barcode_table').DataTable({
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
            { data: 'checkbox', name: 'checkbox' },
            { data: 'barcode', name: 'barcode' },
            { data: 'customer', name: 'customer'},
            { data: 'mobile', name: 'mobile'},
            { data: 'email', name: 'email'},
            { data: 'status', name: 'status' }
        ],
        pageLength : 10
    });

    $('.filter').click(function refreshData() {
        table.ajax.reload();
        seller_barcode_table.ajax.reload();
    });

    $('body').on('click', '#add_cust_del', function() {

        var selectedBarcodes = [];
        console.log(selectedBarcodes);

        $('input[type="checkbox"]:checked').each(function () {
            selectedBarcodes.push($(this).attr('id'));
            console.log(selectedBarcodes);
        });

        if (selectedBarcodes.length === 0) {
            alert('Please select at least one barcode.');
            return; // Stop execution if no barcodes are selected
        }

        barcodes = selectedBarcodes.join(', ');
        $.ajax({
            type: 'POST',
            url: site_url +'admin/set-barcode',
            data: { barcodes : barcodes },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                window.location.href = site_url +'admin/set-cust_del';
            },
            error: function () {
                alert('Error storing selected barcodes.');
            }
        });

    });

});

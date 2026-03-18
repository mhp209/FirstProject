// $("#table").DataTable({
//     paging: false,
//     responsive : true,
//     ordering : false,
//     columnDefs: [{
//     orderable: false,
//     targets: "no-sort"
//     }]
// });
$( document ).ready(function() {
$('#order-responsive-datatable').DataTable({
    "searching": true,
    "pageLength": 10,
    "language": {
        "search": "Search: ",
        "paginate": {
            "previous": "Previous",
            "next": "Next"
        }
    }
});

flatpickr("#date_range", {
        mode: "range",
        onChange:function(){
            var date_range = $('#date_range').val();
        }
    });

    if ($.fn.DataTable.isDataTable('#datatable')) {
        $('#datatable').DataTable().destroy();
    }

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive : true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        ajax : {
            url:  site_url + "admin/order/list",
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
            { data: 'order_id', name: 'order_id' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'discount', name: 'discount' },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'option', name: 'option' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
            { data: 'order_from', name: 'order_from' },
            { data: 'action', name: 'action' }
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

    $(".export").click(function (e) {
        var date_range = $('#date_range').val();
        $.ajax({
            url: site_url + 'admin/order/export',
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                date_range: date_range,
            },
            success: function (response) {
                // console.log(response);
                if (response.status === 'success') {
                    var fileName = response.fileName;
                    var downloadLink = document.createElement('a');
                    downloadLink.href = site_url + 'storage/app/public/' + fileName; // Adjust the URL as needed
                    downloadLink.download = fileName;
                    downloadLink.click();
                    sessionStorage.removeItem('fileName');

                    $.ajax({
                        url: site_url + 'admin/delete_file',
                        type: 'POST',
                        data: {
                            fileName: fileName,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // console.log(response);
                            if (response.status === 'success') {
                                // console.log('File deleted successfully');
                            } else {
                                console.error('Error deleting file: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX request failed: ' + error);
                        }
                    });
                } else {
                    // console.error('Export failed: ' + response.message);
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed: ' + error);
            }
        });
    });


});

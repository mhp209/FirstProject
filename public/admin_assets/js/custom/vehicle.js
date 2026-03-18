$( document ).ready(function() {

    $('#vehicle-responsive-datatable').DataTable({
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
        responsive: true,
        processing: true,
        serverSide: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        ajax : {
            url:  site_url + "admin/vehicles",
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
            { data: 'owner_name', name: 'owner_name' },
            { data: 'barcode', name: 'barcode' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'vehicle_no', name: 'vehicle_no' },
            { data: 'company', name: 'company' },
            { data: 'created_at', name: 'created_at' },
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

    $('body').on('click', '.view_vehicle', function () {
        var Id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: site_url +'admin/view-vehicle/'+ Id,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('.ModalHeader').html("Vehicle Details");
                $('#ModalBody').html(data.page);
                $('#Model').modal('show');
            }
        });
    });
});

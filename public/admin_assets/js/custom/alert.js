$('body').on('click', '.view_alert', function () {
    var Id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: site_url +'admin/view-alert/'+ Id,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('.ModalHeader').html("SMS Alert");
            $('#ModalBody').html(data.page);
            $('#Model').modal('show');
        }
    });
});

$(document).ready(function(){

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
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        ajax : {
            url:  site_url + "admin/alert/list",
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
            { data: 'vehicle_no', name: 'vehicle_no' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'type', name: 'type' },
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
});

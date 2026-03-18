$( document ).ready(function() {
    $('#roles-responsive-datatable').on('click', '.delete', function() {
        if (confirm("Are you sure you want to remove this?")) {
            var delete_url = $(this).data('href');
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    // console.log(response);
                    location.reload();
                },
                error: function(response) {
                    // console.error(response);
                    location.reload();
                }
            });
        }
    });

    $('#roles-responsive-datatable').on('click', '.status', function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');
        var confirmMessage = status === '0' ? 'Are you sure you want to deactivate this item?' : 'Are you sure you want to activate this item?';
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + 'admin/roles-status',
                type: 'POST',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    id: id,
                    status: status,
                },
                success: function(response) {
                    // alert(response);
                    // console.log(response);
                    location.reload();
                },
                error: function(response) {
                    // console.error(response);
                    location.reload();
                }
            });
        }
    });

    $("#roles_validate").validate({
        rules: {
            name: {
                required: true,
            },
            alias: {
                required: true,
                noSpaces: true,
            },
        },
        messages: {
            name: {
                required: "Please enter name",
            },
            alias: {
                required: "Please enter alias",
                noSpaces: "Name should not contain spaces"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

});

$(document).ready(function() {
    $('#roles-responsive-datatable').DataTable({
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
});

ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } );


$(function() {
    var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);
});

$(document).ready(function() {
    $('#products-responsive-datatable').DataTable({
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

$( document ).ready(function() {
    $('#products-responsive-datatable').on('click', '.delete', function() {
        if (confirm("Are you sure you want to remove this?")) {
            var delete_url = $(this).data('href');
            $.ajax({
                url: delete_url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    location.reload();
                },
                error: function(response) {
                    console.error(response);
                    location.reload();
                }
            });
        }
    });

    $('#products-responsive-datatable').on('click', '.status', function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');
        var confirmMessage = status === '0' ? 'Are you sure you want to deactivate this item?' : 'Are you sure you want to activate this item?';
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + 'admin/products-status',
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
                    alert(response);
                    // console.log(response);
                    location.reload();
                },
                error: function(response) {
                    console.error(response);
                    location.reload();
                }
            });
        }
    });

    $("#products_validate").validate({
        rules: {
            name: {
                required: true,
                noSpaces: true,
            },
            price: {
                required: true,
                noSpaces: true,
            },
        },
        messages: {
            name: {
                required: "Please enter your product name",
                noSpaces: "Name should not contain spaces"
            },
            price: {
                required: "Please enter product price",
                noSpaces: "Name should not contain spaces"
            },
        },

        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#safety-option-responsive-datatable').on('click', '#reason_data_info', function() {
        var id = $(this).data('id');
        $.ajax({
            url: site_url + 'admin/reason-data-info/' + id,
            type: 'GET',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $('#messageDataContainer').html(response.html);
                // console.log(response);
                // location.reload();
            },
            error: function(response) {
                console.error(response);
                // location.reload();
            }
        });
    });
});

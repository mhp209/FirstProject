$( document ).ready(function() {

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
            url:  site_url + "admin/generate_barcode",
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
            { data: 'barcode', name: 'barcode' },
            { data: 'type', name: 'type' },
            { data: 'wheeler_type', name: 'wheeler_type' },
            { data: 'linked', name: 'linked'},
            { data: 'customer', name: 'customer' },
            { data: 'assign_to', name: 'assign_to' },
            { data: 'uploaded_by', name: 'uploaded_by' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' }
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

    // end generate barcode


    $(function() {
        var timeout = 3000; // in miliseconds (3*1000)
        $('.alert').delay(timeout).fadeOut(300);
    });

    // $('.dropdown').on('click', '.status', function() {
    $(document).on('click', '.status', function(e) {
        var id = $(this).data('id');
        var status = $(this).attr('value');
        var confirmMessage = status === '1' ? 'Are you sure you want to active this barcode ?' : 'Are you sure you want to inactive this barcode ?';
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + 'admin/barcode-status',
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



    $("#barcode_gen").validate({
        rules: {
            number: {
                required: true,
            },
            type: {
                required: true,
            }
        },
        messages: {
            number: {
                required: "Please enter number",
            },
            type: {
                required: "Please select barcode type",
            }
        },

        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#form_register").validate({
        rules: {
            first_name: {
                required: true,
                noSpaces: true,
            },
            last_name: {
                required: true,
                noSpaces: true,
            },
            email: {
                required: true,
                noSpaces: true,
                email: true,
            },
            password: {
                required: true,
                noSpaces: true,
                minlength: 8
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                noSpaces: "Name should not contain spaces"
            },
            last_name: {
                required: "Please enter your last name",
                noSpaces: "Name should not contain spaces"
            },
            email: {
                required: "Please enter email address",
                noSpaces: "Name should not contain spaces",
                email: "Please enter valid email address"
            },
            password: {
                required: "Please enter password",
                noSpaces: "Password should not contain spaces",
                minlength: "Your password must be at least 8 characters long",
            },
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Your mobile number must be at least 10 characters long",
                maxlength: "Your mobile number must be at least 10 characters long",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-control').after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-control').addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-control').removeClass('has-error').addClass('has-success');
            $(element).closest('.form-control').next('label.error').remove();
        },

        submitHandler: function (form) {
            if($("#form_register").valid()) {
                form.submit();
            }
        }
    });

    if (fileName) {
        var downloadLink = document.createElement('a');
        downloadLink.href = site_url + 'storage/app/public/' + fileName; // Adjust the URL as needed
        downloadLink.download = fileName;
        downloadLink.click();
        // {{ session()->forget('fileName') }}


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

        sessionStorage.removeItem('fileName');
        // console.log('Session cleared successfully');
    }
});

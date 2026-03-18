$( document ).ready(function() {


    $('#date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));

        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        $('#datatable tbody tr').each(function() {
            var date = $(this).find('td:nth-child(4)').text();
            if (moment(date, 'YYYY-MM-DD').isBetween(startDate, endDate, null, '[]')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#datatable tbody tr').show();
    });


    $('#insurance-responsive-datatable').on('click', '.delete', function() {
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
                    console.error(response);
                    location.reload();
                }
            });
        }
    });

    $('#insurance-responsive-datatable').on('click', '.status', function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');
        var confirmMessage = status === '0' ? 'Are you sure you want to deactivate this item?' : 'Are you sure you want to activate this item?';
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + 'admin/insurance-status',
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
                    console.error(response);
                    location.reload();
                }
            });
        }
    });

    $("#insurance_validate").validate({
        rules: {
            name: {
                required: true,
            },
            alias: {
                required: true,
                noSpaces: true,
            },
            image: {
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
            image: {
                required: "Please enter image",
                noSpaces: "Name should not contain spaces"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $("#insurance_qut_frm").validate({
        errorElement:'div',
        rules: {
            insurance_alias: {
                required: true,
            },
            first_name: {
                required: true,
                noSpaces: true,
            },
            last_name: {
                required: true,
                noSpaces: true,
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
            }
        },
        messages: {
            insurance_alias: {
                required: "Please select insurance alias",
            },
            first_name: {
                required: "Please enter your first name",
                noSpaces: "Name should not contain spaces"
            },
            last_name: {
                required: "Please enter your last name",
                noSpaces: "Name should not contain spaces"
            },
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            email: {
                required: "Please enter email",
            }
        },
        submitHandler: function (form) {
            if($("#insurance_qut_frm").valid()) {
                form.submit();
            }
        }
    });

});

$(document).ready(function() {
    $('#insurance-responsive-datatable').DataTable({
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

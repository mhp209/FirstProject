$(document).ready(function() {
    getchchangevalue();
});
$("#promocode_form").validate({
    rules: {
        assign_for: {
            required: true,
        },
        assign_to: {
            required: true,
        },
        code: {
            required: true,
        },
        discount_type: {
            required: true,
        },
        // discount_flat: {
        //     required: true,
        // },
        minimum_type: {
            required: true,
        },
        minimum_value: {
            required: true,
        },
        status: {
            required: true,
        },
        description: {
            required: true,
        },

    },
    messages: {
        assign_for: {
            required: "Please select discount for",
        },
        assign_to: {
            required: "Please select assign promocode",
        },
        code: {
            required: "Please enter code",
        },
        discount_type: {
            required: "Please select discount",
        },
        // discount_flat: {
        //     required: "Please enter discount value",
        // },
        minimum_type: {
            required: "Please select minimum type",
        },
        minimum_value: {
            required: "Please enter minimum value",
        },
        status: {
            required: "Please select status",
        },
        description: {
            required: "Please enter description",
        }

    },

    submitHandler: function(form) {
        form.submit();
    }
});

$('#promocode-responsive-datatable').on('click', '.delete', function() {
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

$('#promocode-responsive-datatable').on('click', '.status', function() {
    var id = $(this).data('id');
    var status = $(this).attr('value');
    var confirmMessage = status === '0' ? 'Are you sure you want to deactivate this item?' : 'Are you sure you want to activate this item?';
    if (confirm(confirmMessage)) {
        $.ajax({
            url: site_url + 'admin/promocode-status',
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

$('#discount_type').on('change', function() {
    getchchangevalue();
});

function getchchangevalue() {
    if ($('#discount_type').val() == 'per') {
        $("#discount_value_per").show();
        $("#discount_value_flat").hide();
    } else {
        $("#discount_value_flat").show();
        $("#discount_value_per").hide();
    }

}



$(document).ready(function () {
    function assignPromocode(assignFor){
        // var assignFor = $(this).val();
        $.ajax({
            url: site_url +'admin/assign/promocode',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                assign_for: assignFor
            },
            success: function (response) {
                var adminSelect = $('#assign_to');
                adminSelect.empty();
                if (response.admins.length > 0) {
                    $('#assignPromocode').show();
                    adminSelect.append('<option value=""> Please Select a ' + $('#assign_for').val() + ' </option>');
                    $.each(response.admins, function (index, admin) {
                        var option = '<option value="' + admin.id + '">' + admin.name + '</option>';
                        adminSelect.append(option);
                    });
                    $('select[name^="assign_to"] option[value=' + assign_to + ']').attr("selected", "selected");
                } else {
                    $('#assignPromocode').hide();
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

    }
    var selectedType = $('#assign_for').val();
    // var selectedAdminId = $('#assign_to').val();
    assignPromocode(selectedType);


    $('#assign_for').change(function () {
        var assignFor = $(this).val();
        assignPromocode(assignFor);
    });
});

$(document).ready(function() {
    $('#promocode-responsive-datatable').DataTable({
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


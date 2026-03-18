$( document ).ready(function() {

    flatpickr("#date_range", {
        mode: "range",
        onChange:function(){
            var date_range = $('#date_range').val();
        }
    });

    if ($.fn.DataTable.isDataTable('#users-responsive-datatable')) {
        $('#users-responsive-datatable').DataTable().destroy();
    }

    var table = $('#users-responsive-datatable').DataTable({
        processing: true,
        serverSide: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        ajax : {
            url:  site_url + "admin/front_users",
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
            { data: 'name', name: 'name' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
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

   // -------Admin Users-----------------------------------------------------------------

    if ($.fn.DataTable.isDataTable('#admin-responsive-datatable')) {
        $('#admin-responsive-datatable').DataTable().destroy();
    }

    var table1 = $('#admin-responsive-datatable').DataTable({
        processing: true,
        serverSide: true,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        ajax : {
            url:  site_url + "admin/users",
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
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
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
        table1.ajax.reload();
    });

    /*=================== Division Delete Ajax Call ====================== */
    $('#admin-responsive-datatable').on('click', '.delete', function() {
        if (confirm("Are you sure you want to remove this?")) {
            var delete_url = $(this).data('href');
            $.ajax({
                url: delete_url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    location.reload();
                }
            });
        }
    });

    $('#admin-responsive-datatable').on('click', '.status', function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');
        var confirmMessage = status === '0' ? 'Are you sure you want to deactivate this item?' : 'Are you sure you want to activate this item?';
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + 'admin/admin-status',
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
                    location.reload();
                },
                error: function(response) {
                    console.error(response);
                    location.reload();
                }
            });
        }
    });

    $("#users_validate").validate({
        rules: {
            first_name: {
                required: true,
                noSpaces: true,
                specialChars: true,
            },
            last_name: {
                required: true,
                noSpaces: true,
                specialChars: true,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                minlength: {
                    depends: function (element) {
                      return $("#form_type").val() === "add";
                    },
                    param: 8, // Minimum length of 8 characters
                  },
                noSpaces: {
                    depends: function (element) {
                        return $("#form_type").val() === "add";
                    },
                },
                required: {
                    depends: function (element) {
                        return $("#form_type").val() === "add";
                    },
                },
            },
            mobile_number: {
                noSpaces: true,
                minlength: 10,
                maxlength: 10,
            },
            whats_no:{
                noSpaces: true,
                minlength: 10,
                maxlength: 10,
            },
            role : {
                required: true,
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                noSpaces: "This field should not contain spaces."
            },
            last_name: {
                required: "Please enter your last name",
                noSpaces: "This field should not contain spaces."
            },
            email: {
                required: "Please enter email address",
                email: "Please enter Valid Email Address",
            },
            password: {
                required: "Please enter password",
                minlength: "Your password must be at least 8 characters long",
                noSpaces: "Password should not contain spaces",
            },
            mobile_number: {
                minlength: "Your mobile number must be at least 10 characters long",
                maxlength: "Your mobile number must be at least 10 characters long",
            },
            whats_no: {
                minlength: "Your mobile number must be at least 10 characters long",
                maxlength: "Your mobile number must be at least 10 characters long",
            },
            role : {
                required: "Please select role",
            }
        },

        submitHandler: function(form) {
            form.submit();
        }
    });
});

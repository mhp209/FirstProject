$(document).ready(function () {
    $(function () {
        var timeout = 3000; // in miliseconds (3*1000)
        $(".alert").delay(timeout).fadeOut(300);
    });

    flatpickr("#date_range", {
        mode: "range",
        onChange: function () {
            var date_range = $("#date_range").val();
        },
    });

    if ($.fn.DataTable.isDataTable("#datatable")) {
        $("#datatable").DataTable().destroy();
    }

    var table = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        ajax: {
            url: site_url + "admin/reassign/list",
            method: "get",
            data: {
                // console.log(code);
                code: code,
            },
            error: function (xhr, error, thrown) {
                console.error("DataTables error:", error);
                console.error("Response:", xhr.responseText);
            },
        },
        columns: [
            {
                data: "checkbox",
                name: "checkbox",
                title: '<input type="checkbox" id="selectAll">',
                orderable: false,
            },
            { data: "barcode", name: "barcode" },
            { data: "created_at", name: "created_at" },
        ],
        pageLength: 10,
    });

    $('#selectAll').on("click", function(event){
        $('input[type="checkbox"]:not([disabled])').prop('checked', $(this).prop("checked"))

    });

    $(".filter").click(function refreshData() {
        table.ajax.reload();
    });


    $("#barcode_gen").validate({
        rules: {
            type: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            type: {
                required: "Please select user",
            },
            status: {
                required: "Please select status",
            },
        },

        submitHandler: function (form) {
            form.submit();
        },
    });

});

$(document).ready(function() {
    $('#updateBtn').click(function() {
        var selectedtype = $('#type').val();
        var status = $('#status').val();
        var price = $('#price').val();
        var selectedValues = [];
        console.log(selectedValues);

        $('input[type="checkbox"]:checked').each(function () {
            selectedValues.push($(this).attr('id'));
        });

        if (selectedValues.length === 0) {
            alert('Please select at least one barcode.');
            return; // Stop execution if no barcodes are selected
        }

        console.log(selectedValues);
        // Send selectedValues to the server via AJAX
        $.ajax({
            url: site_url +'admin/barcode/reassign', // Your server-side endpoint for updating the database
            method: 'POST',
            data: {
                selectedtype: selectedtype,
                selectedValues: selectedValues,
                status : status,
                price : price,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    window.location.href = response.redirect;
                } else {
                    console.log(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });
});


$(document).ready(function () {
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
            url: site_url + "admin/emergency",
            method: "get",
            data: function (d) {
                d.date_range = $("#date_range").val();
            },
        },
        columns: [
            {
                data: "row",
                name: "row",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            { data: "caller_name", name: "caller_name" },
            { data: "caller_number", name: "caller_number" },
            { data: "vehicle_no", name: "vehicle_no" },
            { data: "created_at", name: "created_at" },
            { data: "telecaller_name", name: "telecaller_name", visible: false },
            { data: "emergency_call", name: "emergency_call", visible: false },
            { data: "action", name: "action" },
        ],
        initComplete: function (settings, json) {
            var dataTable = $("#datatable").DataTable();
            if (User_role == "SUPER_ADMIN") {
                dataTable.column(5).visible(true);
            }
            if (User_role == "TELECALLER") {
                dataTable.column(6).visible(true);
            }
        },
        pageLength: 10,
        rowCallback: function (row, data, index) {
            var api = this.api();
            var pageNumber = api.page.info().page;
            var rowIndex = index + 1 + pageNumber * api.page.len();
            $("td:eq(0)", row).html(rowIndex);
        },
    });

    $(".filter").click(function refreshData() {
        table.ajax.reload();
    });

    $(document).on("click", ".status", function () {
        var id = $(this).data("id");
        var status = $(this).attr("value");
        confirmMessage =
            status === "1"
                ? "Are you sure you want to active this call histories ?"
                : "Are you sure you want to inactive this call histories ?";
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + "admin/emergency-update-status",
                type: "POST",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {
                    id: id,
                    status: status,
                },
                success: function (response) {
                    // alert(response);
                    // console.log(response);
                    location.reload();
                },
                error: function (response) {
                    console.error(response);
                    location.reload();
                },
            });
        }
    });

    $("#emergency_form").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                // console.log(response);
                // console.log(response.redirect);
                window.location.href = response.redirect;
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        var errorSpan = $("<span></span>")
                            .addClass("invalid-feedback")
                            .attr("role", "alert");
                        errorSpan.html("<strong>" + value + "</strong>");
                        $("#" + key).addClass("is-invalid");
                        $("#" + key)
                            .parent()
                            .append(errorSpan);
                    });
                } else {
                    // Handle other errors
                }
            },
        });
    });

    $("body").on("click", ".delete", function () {
        var Id = $(this).data("id");
        if (
            confirm("Are you sure you want to remove this emergency?") == true
        ) {
            $.ajax({
                type: "DELETE",
                url: site_url + "admin/del-emergency/" + Id,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (data) {
                    location.href = location.href;
                },
            });
        }
    });

    $("body").on("click", ".view", function () {
        var Id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: site_url + "admin/view-emergency/" + Id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                $("#EnquiryBody").html(data.page);
                $("#EnquiryModel").modal("show");
            },
        });
    });

    $("body").on("click", ".emergency_call", function () {
        var Id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: site_url + "admin/call-emergency/" + Id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                $("#EnquiryBody").html(data.page);
                $("#EnquiryModel").modal("show");
            },
        });
    });
});

$("#call_emergency_form").validate({
    rules: {
        details: {
            required: true,
        },
        status: {
            required: true,
        },
    },
    messages: {
        details: {
            required: "Please enter details",
        },
        status: {
            required: "Please select status",
        },
    },

    submitHandler: function (form) {
        form.submit();
    },
});

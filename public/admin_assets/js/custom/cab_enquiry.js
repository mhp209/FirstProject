$(document).ready(function () {


    $(function () {
        var timeout = 3000;
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
            url: site_url + "admin/cab-enquiry",
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
            { data: "name", name: "name" },
            { data: "mobile_number", name: "mobile_number" },
            { data: "trip_type", name: "trip_type" },
            { data: "type_vehicle", name: "type_vehicle" },
            { data: "pickup_city", name: "pickup_city" },
            { data: "dest_city", name: "dest_city" },
            { data: "created_at", name: "created_at" },
            { data: "status", name: "status" },
            { data: "action", name: "action" },
        ],
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
        var confirmMessage =
            status === "Close"
                ? "Are you sure you want to close this enquiry?"
                : "Are you sure you want to open this enquiry?";
        if (confirm(confirmMessage)) {
            $.ajax({
                url: site_url + "admin/enquiry/status",
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

    $("body").on("click", ".view", function () {
        var Id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: site_url + "admin/view-hire-enquiry/" + Id,
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

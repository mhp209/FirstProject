$(document).ready(function() {
    setTimeout(function() {
        $('#order_table').DataTable({
            paging: true,
            responsive: true,
            ordering: false,
            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }],
            "language": {
                "emptyTable": "No Order data Found"
            }
        });
    }, 5000);

});

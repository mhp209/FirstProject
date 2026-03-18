$(document).ready(function () {
    $("body").on("click", ".delete", function () {
        var vehicleId = $(this).data("id");
        if (confirm("Are you sure you want to remove this vehicle?") == true) {
            $.ajax({
                type: "DELETE",
                url: site_url + "del-vehicle/" + vehicleId,
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
});

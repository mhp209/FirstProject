$(document).ready(function () {
    $("body").on("click", ".delete", function () {
        var Id = $(this).data("id");
        if (confirm("Are you sure you want to remove this Address?") == true) {
            $.ajax({
                type: "DELETE",
                url: site_url + "del-address/" + Id,
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

    $.validator.addMethod(
        "noSpaces",
        function (value, element) {
            return value.indexOf(" ") === -1; // Returns true if there are no spaces
        },
        "This field should not contain spaces."
    );

    $("#address_frm").validate({
        errorElement: "div",
        rules: {
            first_name: {
                required: true,
                // noSpaces: true,
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
            add1: {
                required: true,
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10,
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            pincode: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
                // noSpaces: "Name should not contain spaces"
            },
            last_name: {
                required: "Please enter your last name",
                noSpaces: "Name should not contain spaces",
            },
            email: {
                required: "Please enter email address",
                noSpaces: "Name should not contain spaces",
                email: "Please enter valid email address",
            },
            add1: {
                required: "Please enter address",
            },
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            state: {
                required: "Please select state",
            },
            city: {
                required: "Please enter city name",
            },
            pincode: {
                required: "Please enter pin code",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            // element.closest('.form-control').after(error);
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("has-error").addClass("has-success");
            $(element).next("label.error").remove();
        },

        submitHandler: function (form) {
            if ($("#address_frm").valid()) {
                form.submit();
            }
        },
    });
});

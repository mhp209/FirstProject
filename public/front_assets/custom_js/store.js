$(document).ready(function () {
    $.validator.addMethod("noSpaces", function(value, element) {
        return value.indexOf(" ") === -1; // Returns true if there are no spaces
    }, "This field should not contain spaces.");

    $("#insurance_qut_frm").validate({
        errorElement:'div',
        rules: {
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
            if($("#insurance_qut_frm").valid()) {
                form.submit();
            }
        }
    });
});

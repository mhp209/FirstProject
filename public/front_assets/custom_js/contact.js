
$(document).ready(function () {
    $.validator.addMethod("noSpaces", function(value, element) {
        return value.indexOf(" ") === -1; // Returns true if there are no spaces
    }, "This field should not contain spaces.");

    $("#contact_us").validate({
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
            email: {
                required: true,
                noSpaces: true,
                email: true,
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
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
            email: {
                required: "Please enter email address",
                noSpaces: "Name should not contain spaces",
                email: "Please enter valid email address"
            },
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback text-start');
            if (element.is(":checkbox")) {
                console.log(element.is);
                element.closest('.form-check').append(error);
            } else {
                element.after(error);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('has-error').addClass('has-success');
            $(element).next('label.error').remove();
        },

        submitHandler: function (form) {
            if($("#contact_us").valid()) {
                form.submit();
            }
        }
    });
});



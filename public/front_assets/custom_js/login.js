$(document).ready(function () {
    $.validator.addMethod("noSpaces", function(value, element) {
        return value.indexOf(" ") === -1; // Returns true if there are no spaces
    }, "This field should not contain spaces.");

    $("#frmlogin").validate({
        errorElement:'div',
        rules: {
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                noSpaces: true,
                minlength: 8
            },
        },
        messages: {
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            password: {
                required: "Please enter password",
                minlength: "Your password must be at least 8 characters long",
                noSpaces: "Password should not contain spaces"
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-control').after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-control ').addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-control ').removeClass('has-error').addClass('has-success');
            $(element).closest('.form-control ').next('label.error').remove();
        },

        submitHandler: function (form) {
            if($("#frmlogin").valid()) {
                form.submit();
            }
        }
    });
});

$(document).ready(function() {
    const passwordInput = $('#password');
    const togglePassword = $('#Passwordtoggle');

    togglePassword.click(function() {
        if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        togglePassword.removeClass('fa-eye-slash');
        togglePassword.addClass('fa-eye');
        } else {
        passwordInput.attr('type', 'password');
        togglePassword.addClass('fa-eye-slash');
        togglePassword.removeClass('fa-eye');
        }
    });
});

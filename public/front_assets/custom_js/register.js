$.validator.addMethod("noSpaces", function(value, element) {
    return value.indexOf(" ") === -1; // Returns true if there are no spaces
}, "This field should not contain spaces.");

$(document).ready(function () {
    $("#form_register").validate({
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
            password: {
                required: true,
                noSpaces: true,
                minlength: 8
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
            terms_and_policy: {
                required: true,
                minlength: 1
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
            password: {
                required: "Please enter password",
                noSpaces: "Password should not contain spaces",
                minlength: "Your password must be At least 8 characters long",
            },
            mobile_number: {
                required: "Please enter mobile number",
                noSpaces: "Password should not contain spaces",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            terms_and_policy: {
                required: "You must accept the terms and policy.",
                minlength: "You must accept the terms and policy.",
            },

        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback text-start');
            if (element.is(":checkbox")) {
                // console.log(element.is);
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
            if($("#form_register").valid()) {
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


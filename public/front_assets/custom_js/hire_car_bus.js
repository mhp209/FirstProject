$(document).ready(function() {
    // var message = '<?php echo $message; ?>';
    // console.log(message);
    setTimeout(function() {
      $('#thankyouModal').modal('show');
    }, 1000);

    // $('body').on('click', '.getQuote', function () {
    //     var alias = $(this).data('alias');
    //     var name = $(this).data('name');
    //     $("#alias").val(alias);
    //     $("#name").val(name);
    //     $('#staticBackdrop').modal('show');
    // });

    $("#hire_frm").validate({
        errorElement:'div',
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            mobile_number: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            email: {
                required: true,
            },
            trip_type:{
                required: true,
            },
            type_vehicle: {
                required: true,
            },
            pickup_city: {
                required: true,
            },
            dest_city: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter your first name",
            },
            last_name: {
                required: "Please enter your last name",
            },
            mobile_number: {
                required: "Please enter mobile number",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            email: {
                required: "Please enter email",
            },
            trip_type:{
                required: "Please select trip type",
            },
            type_vehicle: {
                required: "Please select Vehicle type",
            },
            pickup_city: {
                required: "Please enter pickup city",
            },
            dest_city: {
                required: "Please enter destination city",
            },
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
            if($("#hire_frm").valid()) {
                form.submit();
            }
        }
    });
});

$("#paymentButton").click(function (e) {
    e.preventDefault();
    // var form = $(this);
    var form = $("#payment_form");
    $.ajax({
        url: form.attr("action"),
        type: "POST",
        data: form.serialize(),
        success: function (response) {
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

$("#payment_form").validate({
    rules: {
        payment_method: {
            required: true,
        },
        transaction_id: {
            required: true,
        },
    },
    messages: {
        payment_method: {
            required: "Please select payment method",
        },
        transaction_id: {
            required: "Please enter transaction id",
        },
    },
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".form-control").after(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element)
            .closest(".form-control")
            .addClass("has-error")
            .removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element)
            .closest(".form-control")
            .removeClass("has-error")
            .addClass("has-success");
        $(element).closest(".form-control").next("label.error").remove();
    },

    submitHandler: function (form) {
        if ($("#payment_form").valid()) {
            form.submit();
        }
    },
});

$("#form_register").validate({
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
        // password: {
        //     required: true,
        //     noSpaces: true,
        //     minlength: 8,
        // },
        mobile_number: {
            required: true,
            noSpaces: true,
            minlength: 10,
            maxlength: 10,
        },
        payment_method: {
            required: true,
        },
        transaction_id: {
            required: true,
        },
    },
    messages: {
        first_name: {
            required: "Please enter your first name",
            noSpaces: "Name should not contain spaces",
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
        // password: {
        //     required: "Please enter password",
        //     noSpaces: "Password should not contain spaces",
        //     minlength: "Your password must be at least 8 characters long",
        // },
        mobile_number: {
            required: "Please enter mobile number",
            noSpaces: "Password should not contain spaces",
            minlength: "Your mobile number must be at least 10 characters long",
            maxlength: "Your mobile number must be at least 10 characters long",
        },
        payment_method: {
            required: "Please select payment method",
        },
        transaction_id: {
            required: "Please enter transaction id",
        },
    },
    errorPlacement: function (error, element) {
        error.addClass("invalid-feedback");
        element.closest(".form-control").after(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element)
            .closest(".form-control")
            .addClass("has-error")
            .removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element)
            .closest(".form-control")
            .removeClass("has-error")
            .addClass("has-success");
        $(element).closest(".form-control").next("label.error").remove();
    },

    submitHandler: function (form) {
        if ($("#form_register").valid()) {
            form.submit();
        }
    },
});

$(document).ready(function () {

    $('#promocode').change(function () {
        var code = $(this).val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var data = {'code' : code, 'price' : price , 'quantity' : quantity};
        console.log(data);
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : data,
            url: site_url + 'admin/seller/promocode',
            success: function(res) {
                console.log(res);
                var discount = res.discount;
                var totalAmount = res.total_amount;
                $("#discount").val(discount);
                $("#total_amount").val(totalAmount);

                $("#discountcode").html(parseFloat(discount).toFixed(2));
                $("#totalAmount").html(parseFloat(totalAmount).toFixed(2));

                $('#discountSection').hide();
                if (discount > 0) {
                    $('#discountSection').show();
                } else {
                    $('#discountSection').hide();
                }

            }
        });
    });
});

$(document).ready(function () {
    // Initial state on page load
    TransactionIdVisibility();

    // Event handler when the payment method is changed
    $('#payment_method').on('change', function () {
        TransactionIdVisibility();
    });

    // Function to toggle visibility based on payment method
    function TransactionIdVisibility() {
        var selectedPaymentMethod = $('#payment_method').val();
        var transactionIdContainer = $('#transaction_id_container');

        // Check if the selected payment method is 'Cash'
        if (selectedPaymentMethod === 'Cash') {
            transactionIdContainer.hide();
        } else {
            transactionIdContainer.show();
        }
    }
});

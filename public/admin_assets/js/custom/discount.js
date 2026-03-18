$( document ).ready(function() {

    $("#discount_frm").validate({
        rules: {
            quantity: {
                required: true,
            },
            discount: {
                required: true,
            },
        },
        messages: {
            quantity: {
                required: "Please enter quantity",
            },
            discount: {
                required: "Please select discount",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

});


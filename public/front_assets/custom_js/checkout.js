$.validator.addMethod("noSpaces", function(value, element) {
    return value.indexOf(" ") === -1; // Returns true if there are no spaces
}, "This field should not contain spaces.");

$(document).ready(function () {


    $('.continue-to-payment-btn').click(function(event) {
        event.preventDefault();
        var selectedAddress = $('#address_id').val();

        if (selectedAddress) {
            $('#checkout_frm').submit();
        } else {
            alert('Please select an address.');
        }
    });


    $("#checkout_frm").validate({
        errorElement:'div',
        rules: {
            address_id: {
                required: true,
            },

        },
        messages: {
            address_id: {
                required: "Please select address",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // element.closest('.form-control').after(error);
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('has-error').addClass('has-success');
            $(element).next('label.error').remove();
        },

        submitHandler: function (form) {
            if($("#checkout_frm").valid()) {
                form.submit();
            }
        }
    });

    $('body').on('click', '.edit-address', function () {
        var Id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: site_url +'address-form/'+ Id,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#AddressBody').html(data.page);
                $('#AddressModel').modal('show');
            }
        });
    });

    $('body').on('click', '.add-address', function () {
        $.ajax({
            type: 'GET',
            url: site_url +'address-form',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#AddressBody').html(data.page);
                $('#AddressModel').modal('show');
            }
        });
    });

    $('input[type="radio"]').change(function(){
        var address_id= $('input[name="address_id"]:checked').val();
        var selectedOption = $('input[name="address_id"]:checked').val();
        // console.log(selectedOption);
        // console.log(address_id);

        $.ajax({
            url: site_url +'set_address_session',
            method: "POST",
            data: {'address_id' : address_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if(response.success){
                    // console.log('Session value set successfully');
                } else {
                    // console.log('Failed to set session value');
                }
            },
            error: function(xhr, status, error){
                console.error('Error:', error);
            }
        });
    });


});



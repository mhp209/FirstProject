function Calprice(){
    var quantityInput = 0;
    $('input[name="quantity"]').each(function() {
        var quantity = parseInt($(this).val());
        quantityInput += quantity;
    });
    // var quantityInput = $('#quantity').val();
    $('#cart-count').html(quantityInput);
    var price =  RS_SAFETY_PRICE * quantityInput;
    $(".discountDiv").removeClass("d-flex");
    $(".discountDiv").css("display", "none");
    $('#product_total_price,#checkout_price').html(price.toFixed(2));
    quantityInput = parseInt(quantityInput);
    if(DISCOUNT_CODE !== '' && DISCOUNT.length !== 0){
        DISCOUNT = parseInt(DISCOUNT);
        var discount = (DISCOUNT).toFixed(2);
        var final_amount = (price - discount).toFixed(2);
        $('#discount').html(discount);
        $(".discountDiv").addClass("d-flex");
        $('#final_amount').html(final_amount);
    } else {
        var discount = 0;
        var final_amount = price;
        $(".discountDiv").removeClass("d-flex");
        $(".discountDiv").css("display", "none");
        $('#discount').html(0);
        $('#final_amount').html(price.toFixed(2));
    }

    $('#final_price').val(price);
    $('#final_quantity').val(quantityInput);
    $('#final_discount').val(discount);
    CheckBarcode();
}

$(document).ready(function() {
    $('.plus-btn,.minus-btn').click(function (e) {
        // var quantityInput = $('#quantity').val();
        var type = $(this).closest('.item-wrapper').find('h6').text();
        var input = $(this).siblings('input[type=number]');
        var qnt = parseInt(input.val());

        var Total_qnt = 0;
        $('input[type="number"]').each(function() {
            var value = parseFloat($(this).val());
            if (!isNaN(value)) {
                Total_qnt += value;
            }
        });

        $.ajax({
            url: site_url + 'update_cart',
            method: "POST",
            data: {
                'quantity' : qnt,
                'type' : type
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                // console.log(response);
                var AvailableBarcode = response.AvailableBarcode;
                DISCOUNT = response.discount;
                $('#available_barcode').val(AvailableBarcode);
                $('#cart-count').html(Total_qnt);
                Calprice();
            }
        });
    });
});

$(document).ready(function () {
    CheckBarcode();
    Calprice();
    $('.btn-promo-code').on('click', function() {
        var final_price = $('#final_price').val();
        var final_quantity = $('#final_quantity').val();
        // console.log(DISCOUNT_CODE);
        var data = { 'price' : final_price , 'quantity' : final_quantity , 'code' : DISCOUNT_CODE };
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : data,
            url: site_url + 'get-promo-code',
            success: function(res) {
                $('.modal-body').html(res.page);
                $('#promocodeModal').modal('show');
            }
        });
    });

    $(document).on('click', '.apply-promo-code', function(){
        var code_id = $(this).attr("data-id");
        var code = $(this).attr("data-code");
        var data = { 'code_id' : code_id , 'code' : code };
        SetPromoCode(data);
    });

    $(document).on('click', '#apply-code-btn', function(){
        var code = $('#promo-code').val();
        var final_price = $('#final_price').val();
        var final_quantity = $('#final_quantity').val();
        var data = {'code' : code, 'price' : final_price , 'quantity' : final_quantity }
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : data,
            url: site_url + 'check-promo-code',
            success: function(res) {
                // console.log(res);
                if(res.result == false){
                    $("#code-error").html('Invalid Code');
                    $("#code-error").show();
                }else{
                    SetPromoCode(data);
                }
            }
        });
    });

    $(document).on('keyup', '#promo-code', function(){
        var code = $('#promo-code').val();
        if(code == ''){
            $("#code-error").hide();
        }
    });

    $(".cart_remove").click(function (e) {
        var name = $(this).closest('.item-wrapper').find('h6').text();
        // console.log(name)
        if(confirm("Do you really want to remove?")) {
            $.ajax({
                url: site_url + 'remove_from_cart',
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { name: name },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });

    $(document).on('click', '.remove-code', function(){
        SetPromoCode();
    });
});

function CheckBarcode(){
    var AvailableBarcode = $('#available_barcode').val();
    var quantity =  $('#final_quantity').val();
    var availableBarcodeInt = parseInt(AvailableBarcode, 10);
    var quantityInt = parseInt(quantity, 10);
    $('#plus-btn').prop("disabled", false);

    if((availableBarcodeInt != 0 )&& (availableBarcodeInt < quantityInt)){
        // $(".chechout-btn"). attr("disabled", true);
        $(".chechout-btn").hide();
        $("#qnt_msg").text("Only "+AvailableBarcode+" barcode available");
        $("#qnt_msg").show();
        $("#plus-btn"). attr("disabled", true);
    }else if(availableBarcodeInt == 0){
        $(".chechout-btn").hide();
        $("#qnt_msg").text("Out of Stock");
        $("#qnt_msg").show();
        $("#plus-btn"). attr("disabled", true);
    }else{
        $('.chechout-btn').show();
        $("#qnt_msg").text("");
        $("#qnt_msg").hide();
    }
}

function SetPromoCode(data = ''){
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : data,
        url: site_url + 'set-promo-code',
        success: function(res) {
            location.reload();
        }
    });
}

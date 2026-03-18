// product Page
$(document).ready(function () {
    $(".item_cart").on("click", function () {
        var productId = $(this).data("id");
        var quantity = parseInt($("#quantityInput").val());
        $.ajax({
            type: "POST",
            url: site_url + "add_to_cart",
            data: { productId: productId, quantity: quantity },
            success: function (response) {
                // alert(response.message);
                if (response.message == "success") {
                    $("#cart_message").text("Product added to the cart.");
                } else {
                    $("#cart_message").text(
                        "Failed to add the product to the cart."
                    );
                }
                setInterval(function () {
                    $("#cart_message").hide();
                }, 1000);
                location.reload();
            },
        });
    });

    $("#plus-btn,#minus-btn").click(function () {
        var quantityInput = $("#quantity-input").val();
        var wheeler_type = $("#wheeler_type").val();

        $.ajax({
            url: site_url + "check_qnt",
            method: "POST",
            data: {
                quantity: quantityInput,
                wheeler_type : wheeler_type,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var AvailableBarcode = response.AvailableBarcode;
                $("#available_barcode").val(AvailableBarcode);

                var quantity = quantityInput;
                var availableBarcodeInt = parseInt(AvailableBarcode, 10);
                var quantityInt = parseInt(quantity, 10);
                $("#plus-btn").prop("disabled", false);

                if (
                    availableBarcodeInt != 0 &&
                    availableBarcodeInt < quantityInt
                ) {
                    $("#AddToCart").hide();
                    $("#qnt_msg").text(
                        "Only " + AvailableBarcode + " barcode available"
                    );
                    $("#qnt_msg").show();
                    $("#plus-btn").attr("disabled", true);
                } else if (availableBarcodeInt == 0) {
                    $("#AddToCart").hide();
                    $("#qnt_msg").text("Out of Stock");
                    $("#qnt_msg").show();
                } else {
                    $("#AddToCart").show();
                    $("#qnt_msg").text("");
                    $("#qnt_msg").hide();
                }
            },
        });
    });
});

$(document).ready(function () {
    $(".remove_from_cart").on("click", function () {
        var id = $(this).data("id");
        $.ajax({
            url: site_url + "remove_from_cart/" + id,
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#cart_message").html(response.html);
                setInterval(function () {
                    $("#cart_message").hide();
                }, 1000);
                location.reload();
            },
            error: function (response) {
                // console.error(response);
                // location.reload();
            },
        });
    });

    $(document).ready(function () {
        $('#offer-content-slider .offer-content').on('click', function () {
            var code = $(this).data('code');
            var description = $(this).data('description');

            // Set modal title and description
            $('#exampleModalToggleLabel').text(code);
            $('#modal-description').text(description);
        });
    });
});

jQuery(document).ready(function () {
    AOS.init({
        disable: function () {
            var maxwidth = 800;
            var isMobile = /Mobi|Android/i.test(navigator.userAgent);
            return window.innerWidth < maxwidth || isMobile;
        },
    });
});

function increaseQuantity() {
    const quantityInput = document.getElementById("quantityInput");
    const currentValue = parseInt(quantityInput.value);
    if (currentValue < 10) {
        quantityInput.value = currentValue + 1;
        updateProductPrice(quantityInput.value);
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById("quantityInput");
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateProductPrice(quantityInput.value);
    }
}

function updateProductPrice(newQuantity) {
    const productPrice = parseFloat(product_price.replace("₹", "").trim());
    const totalPrice = productPrice * newQuantity;
    const price = "₹ " + totalPrice;
    $("#productPrice").html(price);
}

(function ($) {
    $(function () {
        $("#offer-content-slider").slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 500,
            autoplaySpeed: 2000,
            infinite: true,
            autoplay: true,
            centerMode: true,
            centerPadding: "0",
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: true,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: true,
                    },
                },
                {
                    breakpoint: 526,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                    },
                },
            ],
        });
    });
})(jQuery);

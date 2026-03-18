const $ = jQuery.noConflict();

$(document).ready(function() {
    // var message = '<?php echo $message; ?>';
    // console.log(message);
    setTimeout(function() {
      $('#thankyouModal').modal('show');
    }, 1000);

    $('body').on('click', '.getQuote', function () {
        var alias = $(this).data('alias');
        var name = $(this).data('name');
        $("#alias").val(alias);
        $("#name").val(name);
        $('#staticBackdrop').modal('show');
    });

    $("#gallery-slider-1").slick({
      dots: false,
      infinite: true,
      slidesToShow: 8,
      slidesToScroll: 1,
      speed: 300,
      rtl:false,
      autoplaySpeed: 2000,
      infinite: true,
      autoplay: true,
      centerMode: true,
      centerPadding: "0",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            dots: true,
          },
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 526,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
      ],
    });
});


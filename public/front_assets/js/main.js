



$(document).ready(function($){

(function ($) {
    "use strict";
    // Sticky Navbar
    $(window).scroll(function () {
        ($(this).scrollTop());
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('bg-primary border-bottom border-4 border-navy shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('bg-primary border-bottom border-4 border-navy shadow-sm').css('top', '-150px');
        }
    });
})(jQuery);

//owl carousel
    

    $(function() {
        setTimeout(function() {
            $(".alert-success, .alert-danger").hide();
        }, 3000);
    })

})





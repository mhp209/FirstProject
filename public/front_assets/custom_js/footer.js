jQuery(document).ready(function() {   
    $('.loader-main').fadeOut();
    $('.nav-item.dropdown').hover(function() {
        $(this).find('.dropdown-menu').toggle();
    });

    $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown-menu').toggle();
    });

    $(document).on('click', function(event) {
        var target = $(event.target);
        if (!target.closest('.dropdown-toggle').length && !target.closest('.dropdown-menu').length) {
            $('.dropdown-menu').hide();
        }
    });    
});

jQuery(window).bind("load", function() {
        var footerHeight = 0,
            footerTop = 0,
            $footer = $("#footer");
        positionFooter();

        function positionFooter() {
            footerHeight = $footer.height();
            // console.log(footerHeight);
            footerTop = ($(window).height() - (footerHeight * 2)) + "px";
            // console.log(footerTop);
            if (($(document.body).height() + footerHeight) < $(window).height()) {
                // console.log(111);
                // alert(111);
                $footer.css({
                        position: "absolute",
                        width: "100%"
                    })
                    .animate({
                        top: footerTop
                    })
            }
            // else {
            //     $footer.css({
            //         position: "static"
            //     })
            // }
        }

    });

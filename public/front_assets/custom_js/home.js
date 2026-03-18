$(document).ready(function($){
    
    $("#testimonials-slider-wrapper").slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        lazyLoad: 'ondemand',
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
                    slidesToShow: 3,
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
                    slidesToShow: 1,
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

    // if (window.innerWidth > 768) {
    //     AOS.init({
    //         duration: 3000,
    //         once: false
    //     });
    // }

    AOS.init({
        disable: function () {
            var maxwidth = 800;
            var isMobile = /Mobi|Android/i.test(navigator.userAgent);
            return window.innerWidth < maxwidth || isMobile;
        },
    });    

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();

});

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
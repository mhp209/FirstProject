<section id="footer">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo-footer">
                        <img src="{{ asset('front_assets/images/raod-sathi-logo-footer.webp') }}" alt="" class="img-fluid" width="95" height="44">
                    </div>
                    <div class="social-icon">
                        <ul>
                            <li>
                                <!-- <i class="fa fa-google"></i> -->
                                <a href="https://www.youtube.com/channel/UCr1xkFJcQx09ePVD0R-Kbkg" target="_blank">
                                    <i class="fa fa-youtube-play"></i>
                                </a>
                                <a href="https://www.instagram.com/roadsathi/" target="_blank">
                                    <i class="fa fa-instagram"></i>
                                </a>
                                <a href="https://www.facebook.com/profile.php?id=61554644532553" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="quick-link">
                        <h4>quick-link</h4>
                        <ul class="list-unstyled ">
                            <li>
                                <a href="{{ route('about') }}">About company</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="services">
                        <h4>Products</h4>
                        <ul class="list-unstyled ">
                            <li>
                                <a href="{{ route('product') }}">RS Safety Tag</a>
                            </li>
                            <li>
                                <a href="{{ route('insurance') }}">Insurance</a>
                            </li>
                            <li>
                                <a href="{{ route('hire.cab') }}">Hire Cab</a>
                            </li>
                            <li>
                                <a href="{{ route('hire.bus') }}">Hire Bus</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="contact-us-wrapper">
                        <h4>contact us</h4>
                        <ul class="list-unstyled">
                            <li>
                                <a href="mailto:info@roadsathi.in" class="gap-2 ">
                                    <span class="material-symbols-outlined">
                                        mail
                                    </span>
                                    {{ MAIL }}
                                </a>
                            </li>
                            <li>
                                <a href="tel:8401177585" class="gap-2">
                                    <span class="material-symbols-outlined">
                                        call
                                    </span>
                                    {{ MOBILE_NO }}
                                </a>
                            </li>
                            <li class="gap-2 ">
                                <span class="material-symbols-outlined">
                                    location_on
                                </span>
                                {{ LOCATION }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <section id="footer-row" class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 ">
                        <div class="right-reservad">
                            <p>@ {{ now()->year }} All right reserved by Kinix Infotech Pvt. Ltd </p>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end ">
                        <div class="terms-wrapper">
                            <a href="{{ url('termscondition') }}">Terms & Conditions</a>
                            |
                            <a href="{{ url('privacypolicy') }}">Privacy Policy</a>
                        </div>
                    </div>
                </div>



            </div>

        </section>
    </footer>

</section>

<script>
    function loadCSS(url) {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = url;
        document.head.appendChild(link);
    }

    function loadJS(url) {
        var script = document.createElement('script');
        script.src = url;
        document.head.appendChild(script);
    }
    window.addEventListener('load', function() {
        loadJS("{{ asset('front_assets/custom_js/footer.js') }}");
        loadJS("{{ asset('front_assets/js/main.js') }}");
    });
</script>

</body>

</html>

<div class="adminActions">
    <input type="checkbox" name="adminToggle" class="adminToggle" />
    <a class="adminButton" href="#!">
    <span class="images">
    <img src="{{ asset('front_assets/images/customer-service.png') }}" alt="" width="30" height="30">
    </span>
    </a>
    <div class="adminButtons">
        <a href="mailto:info@roadsathi.in" title="">
            <span class="material-symbols-outlined">
                mail
            </span>
        </a>
        <a href="tel:8401177585" title="">
            <span class="material-symbols-outlined">
                call
            </span>
        </a>
        <!-- <a href="#" title="">
            <i class="fa fa-google"></i>
        </a> -->
        <a href="https://www.youtube.com/channel/UCr1xkFJcQx09ePVD0R-Kbkg" target="_blank" title="">
            <i class="fa fa-youtube-play"></i>
        </a>
        <a href="https://www.instagram.com/roadsathi/" target="_blank" title="">
            <i class="fa fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/profile.php?id=61554644532553" target="_blank" title="">
            <i class="fa fa-facebook"></i>
        </a>
    </div>
</div>

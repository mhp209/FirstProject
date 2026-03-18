@extends('front.layout.master')

@section('content')    
<section class="container mt-5">  
        <div class="row d-flex justify-content-center py-4">
            <div class="col-lg-5 col-md-8 col-sm-12 col-xsm-12">
                <form action="" method="">
                    <div class="form-container">
                        <h2>Log In</h2>
                        <div class="form-group">
                            <input type="text" placeholder=" " id="name">
                            <label for="text">Email Or Phone </label>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder=" " id="lastname">
                            <label for="lastname">Password</label>
                        </div>
                        <p class="text-end">
                            <a href="#" class="d-block text-end  text-decoration-none forgto-pass">Forgot Password ?</a>
                        </p>
                        <div class="checkBx">
                            <input type="checkbox" id="html">
                            <label for="html">Remember me</label>
                        </div>
                        <a href="user-profile.php" class="submit-button my-5 text-decoration-none text-center" type="submit">Log In</a>
                        <a href="user-profile.php" class="submit-button my-5 text-decoration-none text-center" type="submit">Sign Up</a>
                        <!-- <h5 class="text-center my-4"><span class="logOther">Or Login with</span></h5>
                        <div class="login-icon d-flex justify-content-center">
                            <a href="#"><i class="mx-3 fab fa-facebook-square"></i></a>
                            <a href="#"><i class="mx-3 fab fa-instagram"></i></a>
                            <a href="#"><i class="mx-3 fab fa-linkedin"></i></a>
                            <a href="#"><i class="mx-3 fab fa-twitter"></i></a>
                            <a href="#"><i class="mx-3 fab fa-google"></i></a>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
</section>
@endsection
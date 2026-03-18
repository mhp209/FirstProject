<!-- <div class="side-bar-wrapper text-center">
    <div class="col-lg-4 images">
        <img src="{{ asset('front_assets/images/user-profile.png') }}" alt="" class="img-fluid">
    </div>
    <div class="col-lg-2 username">
        <h5>Willson jones</h5>
    </div>
    <div class="col-lg-5 tab-content text-center ">
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('my_account') }}">My Account</a>
            </li>
            <li>
                <a href="{{ route('order.listing') }}">Order details</a>
            </li>
            <li>
                <a href="{{ route('add.vehicle') }}" class="active ">Link vehicle</a>
            </li>
        </ul>
    </div>
    <div class="col-lg-2 log-out-btn">
        <a href="{{ route('logout') }}">Log Out</a>
    </div>
</div> -->
<div class="side-bar-wrapper">
    <div class="col-lg-1 images">
        <img src="{{ asset('front_assets/images/user-profile.png') }}" alt="" class="img-fluid">
    </div>
    <div class="col-lg-2 username">
        <h5>{{ ucfirst(Auth::user()->first_name)}} {{ ucfirst(Auth::user()->last_name)}}</h5>
    </div>
    <div class="col-lg-9 tab-content">
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('my_account') }}" class="@if(Session::get('module') == 'profile') active @endif">Profile</a>
            </li>
            <li>
                <a href="{{ route('order.listing') }}" class="@if(Session::get('module') == 'orderListing') active @endif">My Order</a>
            </li>
            <!-- <li>
                    <a href="link-vehicle.html">Link vehicle</a>
                </li> -->
            <li>
                <a href="{{ route('vehicle.details') }}" class="@if(Session::get('module') == 'vehicle-details') active @endif">My Vehicle</a>
            </li>
            <li>
                <a href="{{ route('address') }}" class="@if(Session::get('module') == 'my_address') active @endif">My address</a>
            </li>
        </ul>
    </div>
    <!-- <div class="col-lg-2 log-out-btn">
            <a href="#">Log Out</a>
        </div> -->
</div>

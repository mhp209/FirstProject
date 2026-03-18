<!-- Logo -->
<div class="header-left">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <img src="{{ asset('admin_assets/img/logo.png') }}" width="40" height="40" alt="">
    </a>
</div>
<!-- /Logo -->

<a id="toggle_btn" href="javascript:void(0);">
    <span class="bar-icon">
        <span></span>
        <span></span>
        <span></span>
    </span>
</a>

<!-- Header Title -->
<div class="page-title-box">
    @if(Auth::guard('admin')->user()->role == 'SUPER_ADMIN' || Auth::guard('admin')->user()->role == 'ADMIN')
    <h3>Road Sathi ({{ ucwords(Auth::guard('admin')->user()->name) }})</h3>
    @else
    <h3>Road Sathi ({{ ucwords(AdminRole(Auth::guard('admin')->user()->role)) }})</h3>
    @endif
    <!-- dd(AdminRole(Auth::guard('admin')->user()->role)); -->
</div>
<!-- /Header Title -->

<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

<!-- Header Menu -->
<ul class="nav user-menu">
    <!-- Notifications -->
    <!-- <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i> <span class="badge badge-pill" id="noti_number"></span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a href="javascript:void(0)" class="clear-noti" id="clear-noti" data-id="1"> Clear All </a>
            </div>
            <div class="noti-content">
                <ul class="notification-list" id="notification-list"></ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="#">View all Notifications</a>
            </div>
        </div>
    </li> -->
    <!-- /Notifications -->

    <!-- Message Notifications -->
    <!-- <li class="nav-item dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fa fa-comment-o"></i> <span class="badge badge-pill">8</span>
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Messages</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="assets/img/profiles/avatar-09.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Richard Miles </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">John Doe</span>
                                    <span class="message-time">6 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="assets/img/profiles/avatar-03.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Tarah Shropshire </span>
                                    <span class="message-time">5 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="assets/img/profiles/avatar-05.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Mike Litorus</span>
                                    <span class="message-time">3 Mar</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img alt="" src="assets/img/profiles/avatar-08.jpg">
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Catherine Manseau </span>
                                    <span class="message-time">27 Feb</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="#">View all Messages</a>
            </div>
        </div>
    </li> -->
    <!-- /Message Notifications -->

    <li class="nav-item dropdown has-arrow main-drop">
        <!-- <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <span class="user-img"><img src="{{ asset('admin_assets/img/profiles/avatar-21.jpg') }}" alt="">
            <span class="status online"></span></span>
            <span><? // admin_session('first_name')
                    ?></span>
        </a> -->
        <!-- <div class="dropdown-menu">
            <a class="dropdown-item" href="#">My Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="{{ url('admin/logout')  }}">Logout</a>
        </div> -->
    </li>
</ul>
<!-- /Header Menu -->

<!-- Mobile Menu -->
<div class="dropdown mobile-user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#">My Profile</a>
        <a class="dropdown-item" href="settings.html">Settings</a>
        <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
        {{-- <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
        document.getElementById('admin-logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i>
        <span>{{ __('Logout') }}</span>
        </a> --}}
        {{-- <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
        </form> --}}
    </div>
</div>
<!-- /Mobile Menu -->

<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="la la-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            @if(Auth::guard('admin')->user()->role == 'SUPER_ADMIN' || Auth::guard('admin')->user()->role == 'ADMIN')

            <li class="{{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                <a href="{{ route('roles') }}">
                    <i class="las la-user-tag"></i>
                    <span> Role </span>
                </a>
            </li>

            <!-- <li class="{{ Request::segment(2) == 'safety-option' ? 'active' : '' }}">
                <a href="{{ url('admin/safety-option') }}">
                    <i class="la la-user-secret"></i>
                    <span> Safety Option </span>
                </a>
            </li> -->

            <li class="submenu">
                <a href="javascript:void(0);" class="nav-link {{ Request::segment(2) == 'front_users' || Request::segment(2) == 'users' ? 'active' : ''  }}">
                    <i class="la la-users"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item {{ Request::segment(2) == 'front_users' ? 'active' : '' }}">
                        <a href="{{ route('admin.FrontUsers') }}" class="nav-link">
                            <i class="la la-user"></i>
                            <span> Web </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'users' ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="la la-user"></i>
                            <span> Admin Users </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="submenu">
                <a href="javascript:void(0);" class="nav-link {{ in_array(Request::segment(2), ['insurance', 'ins_enquiry', 'cab-enquiry', 'bus-enquiry']) ? 'active' : '' }}">
                    <i class="las la-phone-square"></i>
                    <span> Enquiries </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item {{ Request::segment(2) == 'insurance' ? 'active' : '' }}">
                        <a href="{{ route('admin.insurance') }}" class="nav-link">
                            <i class="las la-phone-square"></i>
                            <span> Insurance </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'ins_enquiry' ? 'active' : '' }}">
                        <a href="{{ route('admin.ins_enquiry') }}" class="nav-link">
                            <i class="las la-phone-square"></i>
                            <span> Insurance Enquiry </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'cab-enquiry' ? 'active' : '' }}">
                        <a href="{{ route('admin.cab.enquiry') }}" class="nav-link">
                            <i class="las la-phone-square"></i>
                            <span> Cab Enquiry </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'bus-enquiry' ? 'active' : '' }}">
                        <a href="{{ route('admin.bus.enquiry') }}" class="nav-link">
                            <i class="las la-phone-square"></i>
                            <span> Bus Enquiry </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="submenu">
                <a href="javascript:void(0);" class="nav-link {{ Request::segment(2) == 'barcode' || Request::segment(2) == 'generate_barcode' ? 'active' : ''  }}">
                    <i class="las la-qrcode"></i>
                    <span> Barcode </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item {{ Request::segment(2) == 'generate_barcode' ? 'active' : '' }}">
                        <a href="{{ route('generate.barcode') }}" class="nav-link">
                            <i class="las la-qrcode"></i>
                            <span> Generate Barcode </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'barcode' ? 'active' : '' }}">
                        <a href="{{ route('barcode') }}" class="nav-link">
                            <i class="las la-qrcode"></i>
                            <span> Assign Barcode </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::segment(2) == 'promocode' ? 'active' : '' }}">
                <a href="{{ route('promocode') }}">
                    <i class="las la-tags"></i>
                    <span> Promocode </span>
                </a>
            </li>

            <li class="{{ Request::segment(2) == 'order' ? 'active' : '' }}">
                <a href="{{ route('order.list') }}">
                    <i class="las la-shopping-cart"></i>
                    <span> Orders </span>
                </a>
            </li>

            <li class="submenu">
                <a href="javascript:void(0);" class="nav-link {{ Request::segment(2) == 'alert' || Request::segment(2) == 'emergency' ? 'active' : ''  }}">
                    <i class="las la-exclamation-triangle"></i>
                    <span> Alerts </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item {{ Request::segment(2) == 'alert' ? 'active' : '' }}">
                        <a href="{{ route('alert.list') }}" class="nav-link">
                            <i class="las la-comment"></i>
                            <span> SMS Alert </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'emergency' ? 'active' : '' }}">
                        <a href="{{ route('admin.emergency') }}" class="nav-link">
                            <i class="las la-phone-square"></i>
                            <span> Emergency </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="submenu">
                <a href="javascript:void(0);" class="nav-link {{ Request::segment(2) == 'setting' || Request::segment(2) == 'banner' ? 'active' : ''  }}">
                    <i class="las la-cog"></i>
                    <span> Settings </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item {{ Request::segment(2) == 'setting' ? 'active' : '' }}">
                        <a href="{{ route('setting') }}" class="nav-link">
                            <i class="las la-cog"></i>
                            <span> Setting </span>
                        </a>
                    </li>
                    <li class="nav-item {{ Request::segment(2) == 'banner' ? 'active' : '' }}">
                        <a href="{{ route('banner') }}" class="nav-link">
                            <i class="las la-image"></i>
                            <span> Banner </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ Request::segment(2) == 'vehicles' ? 'active' : '' }}">
                <a href="{{ route('admin.vehiclesList') }}">
                    <i class="las la-car-alt"></i>
                    <span> Vehicles </span>
                </a>
            </li>

            <!-- <li class="{{ Request::segment(2) == 'discount' ? 'active' : '' }}">
                <a href="{{ url('admin/discount') }}">
                <i class="las la-tags"></i>
                    <span> Discount </span>
                </a>
            </li> -->

            <li class="{{ Request::segment(2) == 'notification' ? 'active' : '' }}">
                <a href="{{ route('notification') }}">
                    <i class="las la-bell"></i>
                    <span> Notification </span>
                </a>
            </li>

            @endif

            @if(Auth::guard('admin')->user()->role == 'SELL_EMPLOYEE')
            <li class="{{ Request::segment(2) == 'barcode' ? 'active' : '' }}">
                <a href="{{ route('barcode') }}">
                    <i class="las la-qrcode"></i>
                    <span> barcode </span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(2) == 'ins_enquiry' ? 'active' : '' }}">
                <a href="{{ route('admin.ins_enquiry') }}" class="nav-link">
                    <i class="las la-phone-square"></i>
                    <span> Insurance Enquiry </span>
                </a>
            </li>

            <li class="{{ Request::segment(2) == 'order' ? 'active' : '' }}">
                <a href="{{ route('order.list') }}">
                    <i class="las la-shopping-cart"></i>
                    <span> Orders </span>
                </a>
            </li>

            @endif

            @if(Auth::guard('admin')->user()->role == 'TELECALLER')

            <li class="{{ Request::segment(2) == 'emergency' ? 'active' : '' }}">
                <a href="{{ route('admin.emergency') }}">
                    <i class="las la-phone-square"></i>
                    <span> Emergency </span>
                </a>
            </li>

            <li class="{{ Request::segment(2) == 'add_emergency' ? 'active' : '' }}">
                <a href="{{ route('admin.add_emergency') }}">
                    <i class="las la-plus-circle"></i>
                    <span> Add Emergency </span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(2) == 'ins_enquiry' ? 'active' : '' }}">
                <a href="{{ route('admin.ins_enquiry') }}" class="nav-link">
                    <i class="las la-phone-square"></i>
                    <span> Insurance Enquiry </span>
                </a>
            </li>

            @endif

            @if(Auth::guard('admin')->user()->role == 'FRANCHISE_PARTNER')
            <li class="{{ Request::segment(2) == 'barcode' ? 'active' : '' }}">
                <a href="{{ route('barcode') }}">
                    <i class="las la-qrcode"></i>
                    <span> barcode </span>
                </a>
            </li>

            <li class="nav-item {{ Request::segment(2) == 'ins_enquiry' ? 'active' : '' }}">
                <a href="{{ route('admin.ins_enquiry') }}" class="nav-link">
                    <i class="las la-phone-square"></i>
                    <span> Insurance Enquiry </span>
                </a>
            </li>

            @endif

            <li>
                <a href="{{ route('admin.logout') }}">
                    <i class="las la-sign-out-alt"></i>
                    <span> Logout </span>
                </a>
            </li>

        </ul>
    </div>
</div>

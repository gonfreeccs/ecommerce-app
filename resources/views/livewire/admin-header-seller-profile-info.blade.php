<div>
    @if (Auth::guard('admin')->check())
				
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a
                class="dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
            >
                <span class="user-icon">
                    <img src="{{$admin->picture}}" alt="" />
                </span>
                <span class="user-name" value="">{{ $admin->name }}</span>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
            >
                <a class="dropdown-item" href="{{route('adminprofile')}}"
                    ><i class="dw dw-user1"></i> Profile</a
                >
                <a class="dropdown-item" href="profile.html"
                    ><i class="dw dw-settings2"></i> Setting</a
                >
                <a class="dropdown-item" href="faq.html"
                    ><i class="dw dw-help"></i> Help</a
                >
                <a class="dropdown-item" href="{{ route('adminlogout_handler')}}"
                    onclick="event.preventDefault();document.getElementById('adminLogoutForm').submit();"><i class="dw dw-logout"></i> Log Out</a
                >

                <form action="{{ route('adminlogout_handler')}}" id="adminLogoutForm" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
        
    @elseif(Auth::guard('seller')->check())
    
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a
                class="dropdown-toggle"
                href="#"
                role="button"
                data-toggle="dropdown"
            >
                <span class="user-icon">
                    <img src="/back/vendors/images/photo1.jpg" alt="" />
                </span>
                <span class="user-name"></span>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
            >
                <a class="dropdown-item" href="profile.html"
                    ><i class="dw dw-user1"></i> Profile</a
                >
                <a class="dropdown-item" href="profile.html"
                    ><i class="dw dw-settings2"></i> Setting</a
                >
                <a class="dropdown-item" href="faq.html"
                    ><i class="dw dw-help"></i> Help</a
                >
                <a class="dropdown-item" href="{{ route('adminlogout_handler')}}"
                    ><i class="dw dw-logout"></i> Log Out</a
                >
            </div>
        </div>
    </div>
        
    @endif

</div>

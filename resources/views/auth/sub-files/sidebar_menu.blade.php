<div class="sidebar-menu-area" id="metismenu" data-simplebar>
    <!-- Sidebar content -->
    <ul class="sidebar-menu o-sortable">
        <!-- HOME -->
        <li><span class="cat">HOME</span></li>
        <li class="{{ Request::is('dashboard*') ? ' mm-active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-title">
                <span class="icon"><i data-feather="home"></i></span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <!-- Menus -->
        <li><span class="cat">Menus</span></li>
        <li class="{{ Request::is('students') ? ' mm-active' : '' }}">
            <a href="{{ route('students') }}" class="menu-title">
                <span class="icon"><i data-feather="user"></i></span>
                <span class="title">List of Students</span>
            </a>
        </li>
        <li  class="{{ Request::is('student-logs') ? ' mm-active' : '' }}">
            <a href="{{ route('students-logs') }}" class="menu-title">
                <span class="icon"><i data-feather="file-text"></i></span>
                <span class="title">Student Logs</span>
            </a>
        </li>
        <li class="{{ Request::is('sms-api') ? 'mm-active' : '' }}">
            <a href="#" class="has-arrow menu-title{{ Request::is('sms-api') ? ' active' : '' }}" aria-expanded="{{ Request::is('sms-api') ? 'true' : 'false' }}">
                <span class="icon"><i data-feather="settings"></i></span>
                <span class="title">Settings</span>
            </a>
            <ul class="sidemenu-second-level show mm-collapse {{ Request::is('sms-api') ? ' mm-show' : '' }}">
                <li><a href="{{ route('smsapi') }}" class="{{ Request::is('sms-api') ? 'active' : '' }}">SMS Gateway API</a></li>
                <li><a href="{{ route('accounts') }}" class="{{ Request::is('accounts*') ? 'active' : '' }}">Admin Accounts</a></li>
            </ul>
        </li>
        
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Add 'active' class to the current menu item based on the URL
    $(document).ready(function () {
        var currentUrl = window.location.href;
        $('.sidebar-menu a').each(function () {
            var linkUrl = $(this).attr('href');
            if (currentUrl.includes(linkUrl)) {
                $(this).addClass('active');
                $(this).closest('.has-arrow').addClass('active');
                $(this).closest('.sidemenu-second-level').addClass('mm-show');
                $(this).closest('.sidemenu-second-level').prev('.menu-title').addClass('active');
            }
        });
    });
</script>

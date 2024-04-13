<div class="sidebar-menu-area" id="metismenu" data-simplebar>
    <div class="d-flex justify-content-between align-items-center border-bottom border-color bg-white position-sticky top-0 z-1 main-logo-wrap">
        <a href="#" class="main-logo d-flex align-items-center text-decoration-none">
            <img class="logo" src="assets/images/logo.png" alt="logo">
            <span class="ms-3 logo-text">Dass</span>
        </a>
        <div class="responsive-burger-menu d-block d-xl-none">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>
    </div>
    <ul class="sidebar-menu o-sortable">
        <li><span class="cat">HOME</span></li>
        <li>
            <a href="{{route('dashboard')}}" class="menu-title">
                <span class="icon"><i data-feather="home"></i></span>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li><span class="cat">Menus</span></li>
        <li>
            <a href="user-profile.html" class="menu-title">
                <span class="icon"><i data-feather="user"></i></span>
                <span class="title">List of Students</span>
            </a>
        </li>
        <li>
            <a href="notes.html" class="menu-title">
                <span class="icon"><i data-feather="file-text"></i></span>
                <span class="title">Student Logs</span>
            </a>
        </li>
        <li>
            <a href="to-do-list.html" class="menu-title">
                <span class="icon"><i data-feather="message-square"></i></span>
                <span class="title">Text Logs</span>
            </a>
        </li>
        
        <li>
            <a href="#" class="has-arrow menu-title" aria-expanded="true">
                <span class="icon"><i data-feather="settings"></i></span>
                <span class="title">Settings</span>
            </a>
            <ul class="sidemenu-second-level">
                <li><a href="my-drive.html">SMS Gateway API</a></li>
                <li><a href="my-drive.html">SMS Messages</a></li>
                <li><a href="recent.html">Administrator Accounts</a></li>
            </ul>
        </li>
        
    </ul>
</div>
<header class="header-area bg-white mb-24">
    <div class="row align-items-center">
        <div class="col-lg-6 col-sm-6">
            <div class="header-left-content">
                <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-start justify-content-md-start align-items-center">
                    <li>
                        <div class="burger-menu d-none d-lg-block">
                            <span class="top-bar"></span>
                            <span class="middle-bar"></span>
                            <span class="bottom-bar"></span>
                        </div>
                        <div class="responsive-burger-menu d-block d-lg-none">
                            <span class="top-bar"></span>
                            <span class="middle-bar"></span>
                            <span class="bottom-bar"></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6">
            <div class="header-right-content float-lg-end float-md-end">
                <ul class="list-unstyled ps-0 mb-0 d-flex justify-content-center justify-content-lg-end justify-content-md-end align-items-center">

                    <li class="ms-lg-4 ms-md-4 ms-2">
                        <div class="dropdown user-profile">
                            <div class="btn border-0 p-0 d-flex align-items-center text-start" data-bs-toggle="dropdown">
                                <div class="flex-shrink-0">
                                    <img class="rounded-circle user" src="assets/images/user/user.png" alt="user">
                                </div>
                                <div class="flex-grow-1 ms-2 d-none d-xxl-block">
                                    <h3 class="fs-14 mb-0">{{ Auth::user()->name }}</h3>
                                    <span class="fs-13 text-body">Administrator</span>
                                </div>
                            </div>
                            <ul class="dropdown-menu border-0 rounded box-shadow">
                                
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-body" href="account-settings.html">
                                        <i data-feather="settings"></i>
                                        <span class="ms-2 fs-14">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-body" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i data-feather="log-out"></i>
                                        <span class="ms-2 fs-14">Logout</span>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
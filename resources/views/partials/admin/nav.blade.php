<!--  Main wrapper -->
<div class="body-wrapper bg-primary-dark">
<!--  Header Start -->
<header class="app-header bg-secondary-dark">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                    href="javascript:void(0)">
                    <i class="ti ti-menu-2 text-mode"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="ti ti-bell-ringing text-mode"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-start dropdown-menu-animate-up"
                    aria-labelledby="drop2">
                    <div class="message-body">
                        <a href="{{route('admin.myProfile')}}" class="d-flex align-items-center gap-2 dropdown-item">
                            <i class="ti ti-user fs-6"></i>
                            <p class="mb-0 fs-3">My Profil lo</p>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <div class="me-3">
                    <img src="" loading="lazy" class="cursor-pointer" width="22px" alt="" id="icon-mode">
                </div>
                <li class="nav-item dropdown d-flex justify-content-center align-item-center">
                <a class="nav-link nav-icon-hover img-nav p-0 me-3" href="" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('images/admins/' . $adminData->profile_picture) }}" id="headerImage" alt="" width="45" class="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                        aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="{{route('admin.myProfile')}}"
                                class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Page Preloder -->
<div id="preloder">
        <div class="loader"></div>
    </div>

<!-- Sidebar Start -->
<aside class="left-sidebar rounded-right">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-simplebar>
        <div class="d-flex mb-2 align-items-center justify-content-between">
            <a href="{{route('admin.dashboard')}}">
                <img class="text-nowrap logo-img ms-0 ms-md-1" loading="lazy" src="/assets/images/logo/Treasure Academy logo light-mode.png" width="70px" id="logo">
                </img>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-mode"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-4 pb-2">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-5"></i>
                    <span class="text-mode hide-menu fw-bold ">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="background-active sidebar-link grey-hover-bg color-active" href="{{route('admin.dashboard')}}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-light-grey rounded-3">
                            <i class="ti ti-layout-dashboard fs-7 text-primary"></i>
                        </span>
                        <span class="text-mode hide-menu ms-2 ps-1 ">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap d-flex align-items-end hover-text-blue">
                    <div id="controlItem" class="d-flex align-items-center cursor-pointer">
                        <span class="text-mode mb-1 fw-bold  bn13">Control &dArr;</span>
                    </div>
                </li>
                <div class="control">
                    <li class="sidebar-item">
                        <div class="sidebar-link  color-active category grey-hover-bg control-hide mb-0 cursor-pointer"
                            href="#" aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-layout-grid-add fs-7 text-primary"></i>
                            </span>
                            <span class="text-mode hide-menu ms-2 ps-1 ">Category</span>
                        </div>
                        <ul class="submenu hide ">
                            <div class="border-left"></div>
                            <li class="d-flex align-items-center mt-1 parent-submenu-title">
                                <div class="submenu-title">
                                    <a href="{{ route('admin.addCategory') }}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-category grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Category
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewCategories')}}"
                                    class="sidebar-link text-mode mt-1 mt-1 m-0 submenu-title view-category grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View Category</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <div class="sidebar-link text-mode  color-active grey-hover-bg control-hide mb-0 cursor-pointer"
                            aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-folder-plus fs-7 text-primary"></i>
                            </span>
                            <span class="hide-menu ms-2 ps-1 ">Course</span>
                        </div>
                        <ul class="submenu hide">
                            <div class="border-left"></div>
                            <li class="d-flex align-items-center mt-1">
                                <div class="submenu-title">
                                    <a href="{{route('admin.addCourse')}}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-course grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Course
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewCourses')}}"
                                    class="sidebar-link text-mode mt-1 m-0 submenu-title view-course grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View Course</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <div class="sidebar-link text-mode  color-active grey-hover-bg control-hide mb-0 cursor-pointer"
                            aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-file-plus fs-7 text-primary"></i>
                            </span>
                            <span class="hide-menu ms-2 ps-1 ">Section</span>
                        </div>
                        <ul class="submenu hide">
                            <div class="border-left"></div>
                            <li class="d-flex align-items-center mt-1">
                                <div class="submenu-title">
                                    <a href="{{route('admin.addSection')}}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-section grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Section
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewSections')}}"
                                    class="sidebar-link text-mode mt-1 m-0 submenu-title view-section grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View Section</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <div class="sidebar-link text-mode  color-active grey-hover-bg control-hide mb-0 cursor-pointer"
                            aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-video-plus fs-7 text-primary"></i>
                            </span>
                            <span class="hide-menu ms-2 ps-1 ">Lecture</span>
                        </div>
                        <ul class="submenu hide">
                            <div class="border-left"></div>
                            <li class="d-flex align-items-center mt-1">
                                <div class="submenu-title">
                                    <a href="{{route('admin.addLecture')}}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-lecture grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Lecture
                                    </a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewLectures')}}"
                                    class="sidebar-link text-mode mt-1 m-0 submenu-title view-lecture grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View Lecture</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <div class="sidebar-link text-mode  color-active grey-hover-bg control-hide mb-0 cursor-pointer"
                            aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-user-edit fs-7 text-primary"></i>
                            </span>
                            <span class="hide-menu ms-2 ps-1 ">Instructor</span>
                        </div>
                        <ul class="submenu hide">
                            <li class="d-flex align-items-center mt-1">
                                <div class="submenu-title">
                                    <div class="border-left"></div>
                                    <a href="{{route('admin.addInstructor')}}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-category grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Instructor</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewInstructors')}}" class="sidebar-link text-mode mt-1 m-0 submenu-title view-category grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View Instructor</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <div class="sidebar-link text-mode  color-active grey-hover-bg control-hide mb-0 cursor-pointer"
                            aria-expanded="false">
                            <span class="aside-icon p-2 bg-light-grey rounded-3">
                                <i class="ti ti-user-plus fs-7 text-primary"></i>
                            </span>
                            <span class="hide-menu ms-2 ps-1 ">User</span>
                        </div>
                        <ul class="submenu hide">
                            <li class="d-flex align-items-center mt-1">
                                <div class="submenu-title">
                                <div class="border-left"></div>
                                    <a href="{{ route('admin.addUser') }}"
                                        class="sidebar-link text-mode color-active m-0 submenu-title add-user grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add User</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('viewUsers')}}" class="sidebar-link text-mode mt-1 m-0 submenu-title view-user grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">View User</a>
                            </li>
                            <li class="d-flex align-items-center">
                                <a href="{{route('admin.addCourseToUser')}}" class="sidebar-link text-mode mt-1 m-0 submenu-title view-user grey-hover-bg pe-3 ps-3 pt-1 pb-1 ">Add Course To User</a>
                            </li>
                        </ul>
                    </li>
                </div>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-5"></i>
                    <span class="hide-menu ">Auth</span>
                </li>
                <li class="sidebar-item">
                    <a class="background-active sidebar-link text-mode warning-hover-bg" href="{{route('admin.logout')}}"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-light-warning rounded-3">
                            <i class="ti ti-login fs-7 text-warning"></i>
                        </span>
                        <span class="hide-menu ms-2 ps-1 ">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->

<div class="side-bar">

    <div id="close-btn">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <div class="flex items-center justify-between pb-5 border-b border-gray-500">
            <a href="{{route('user.home')}}"> <img src="/images/users/{{$user->profile_picture}}" class="image" loading="lazy" alt="">
            </a>

            <div class="name-side">
                <h3 class="name">Hi, <span>{{ Auth::user()->name }}</span></h3>
                <p class="w-back">Welcome Back</p>
            </div>
        </div>
    </div>

    <nav class="navbar sidebar-nav border-b border-gray-500 pb-5">
        <ul class="w-11/12">
            <li class="sidebar-item border-0 ps-5">
                <a href="{{route('user.home')}}" class="sidebar-link p-0 color-active grey-hover-bg mb-0 cursor-pointer">
                    <span class="aside-icon p-2 bg-light-grey rounded-3">
                        <i class="fas fa-home fs-8 text-primary"></i>
                    </span>
                    <span class="ms-4 text-mode">Home</span></a>
            </li>

            <li class="sidebar-item border-0 ps-5">
                <a href="{{route('user.courses')}}" class="sidebar-link p-0 color-active grey-hover-bg mb-0 cursor-pointer">
                    <span class="aside-icon p-2 bg-light-grey rounded-3">
                    <i class="fa-solid fa-layer-group fs-8 text-primary"></i>
                    </span>
                    <span class="ms-4 text-mode">Courses</span></a>
            </li>

            <li class="sidebar-item border-0 ps-5">
                <a href="{{route('user.myProfile')}}" class="sidebar-link p-0 color-active grey-hover-bg mb-0 cursor-pointer">
                    <span class="aside-icon p-2 bg-light-grey rounded-3">
                    <i class="fas fa-user fs-8 text-primary"></i>
                    </span>
                    <span class="ms-4 text-mode">Profile</span></a>
            </li>

            <li class="sidebar-item border-0 ps-5">
                <a href="http://t.me/HunterTA12" class="sidebar-link p-0 color-active grey-hover-bg mb-0 cursor-pointer">
                    <span class="aside-icon p-2 bg-light-grey rounded-3">
                    <i class="fas fa-headset fs-8 text-primary"></i>
                    </span>
                    <span class="ms-4 text-mode">Contact Us</span></a>
            </li>

        </ul>

    </nav>

</div>

<header class="header">

    <section class="flex">

        <div id="menu-btn" class="fas fa-bars cursor-pointer"></div>

        <a href="home.html"><img class="logo" id="logo" loading="lazy" style="margin-left: 40px"
                src="/assets/images/logo/Treasure Academy logo dark-mode.png" alt=""></a>

        <form action="search.html" method="post" class="search-form">
            <input type="text" name="search_box" required placeholder="search courses..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
        </form>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <div id="toggle-btn" class="fas fa-sun mode cursor-pointer"></div>
            <img src="/images/users/{{ $user->profile_picture }}" class="image" loading="lazy" alt="">
            <h3 class="name">{{ $user->name }}</h3>
            <a href="{{route('user.myProfile')}}" class="btn-new"><i class="fas fa-user me-1"></i> view profile</a>
            <div class="flex-btn">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                    class="option-btn"><i class="fa-solid fa-right-from-bracket me-3"></i>logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </section>

</header>

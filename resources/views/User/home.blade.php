@include('partials.user.user-header', ['title' => 'Treasure Academy|Home'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')

<div class="home">
    <section class="home-grid pb-6">

        <h1 class="heading">quick options</h1>
        <div class="box-container">

            <div class="box">
                <h3 class="title">likes and comments</h3>
                <p class="likes">total likes : <span>{{ $numberOfLikes }}</span></p>
                <a href="#" class="inline-btn">view likes</a>
                <p class="likes">total comments : <span>{{ $numberOfComments }}</span></p>
                <a href="#" class="inline-btn">view comments</a>
                <p class="likes">saved playlists : <span>0</span></p>
                <a href="#" class="inline-btn">view playlists</a>
            </div>

            <div class="box">
                <h3 class="title">Categories</h3>
                <div class="flex">
                    <a href="#"><i class="fas fa-code"></i><span>development</span></a>
                    <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
                    <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
                    <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
                </div>
            </div>

            <div class="box">
                <h3 class="title">Courses</h3>
                <div class="flex">
                    <a href="#"><i class="fa-solid fa-square-poll-vertical"></i><span>Forex</span></a>
                    <a href="#"><i class="fa-solid fa-chalkboard-user"></i><span>TOT</span></a>
                    <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
                </div>
            </div>

        </div>

    </section>



    <section class="courses">

        <h1 class="heading">Your Courses</h1>
        <div class="box-container">
            @if ($coursesOfLoggedUser->isNotEmpty())
                @foreach ($coursesOfLoggedUser as $userCourse)
                    <div class="box">

                        <div class="tutor">

                            <img src="/images/instructors/{{ $userCourse->course->instructor->profile_picture }}"
                                alt="" loading="lazy">
                            <div class="info">
                                <h3>{{ $userCourse->course->instructor ? $userCourse->course->instructor->first_name . ' ' . $userCourse->course->instructor->last_name : 'No Instructor' }}
                                </h3>
                                <span>{{ $userCourse->course->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="thumb">
                            <img src="/images/CoursesCoverImages/{{ $userCourse->course->cover_image }}" alt=""
                                loading="lazy">
                            <span>{{ $userCourse->course->videos_count }}</span>
                        </div>
                        <h3 class="title">{{ $userCourse->course->course_title }}</h3>
                        <a href="{{ route('user.playlist', $userCourse->course->id) }}" class="inline-btn">view
                            playlist</a>
                    </div>
                @endforeach
            @else
                <p class="fs-10 t text-xl-center">No Courses Founded</p>
            @endif
        </div>

        <div class="more-btn">
            <a href="{{ route('user.courses') }}" class="inline-option-btn">view all courses</a>
        </div>

    </section>
</div>

@include('partials.user.user-footer')
@include('partials.user.user-footer-script')

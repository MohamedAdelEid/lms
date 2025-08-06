@include('partials.user.user-header', ['title' => 'Treasure Academy|Courses'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')


<section class="courses" style="padding-bottom: 100px">

    <div class="flex items-center justify-between border-b border-gray-500 mb-5">
        <h1 class="heading mb-0 p-0 pb-3 border-0">our courses</h1>
        <div class="pb-3">
            <form class="w-60 h-14 mx-auto ">
                <select id="countries"
                    class="select-category bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 fs-6">
                    @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" selected>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    @else
                        <option>No Categories</option>
                    @endif
                </select>
            </form>
        </div>
    </div>

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
                        {{--                     Course Cover Image --}}
                        <img src="/images/CoursesCoverImages/{{ $userCourse->course->cover_image }}" alt=""
                            loading="lazy">
                        <span>{{ $userCourse->course->videos_count }}</span>
                    </div>
                    <h3 class="title">{{ $userCourse->course->course_title }}</h3>
                    <a href="{{ route('user.playlist', $userCourse->course->id) }}" class="inline-btn">view playlist</a>
                </div>
            @endforeach
        @else
            <p class="fs-10 t text-xl-center">No Courses Founded</p>
        @endif
    </div>

</section>

@include('partials.user.user-footer')
@include('partials.user.user-footer-script')

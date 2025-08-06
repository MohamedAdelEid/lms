@include('partials.user.user-header',['title'=>'Treasure Academy|Play List'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')

<section class="playlist-details pb-5">

    <h1 class="heading">playlist details</h1>

    <div class="row">

        <div class="column">
            <form action="" method="post" class="save-playlist">
                <button type="submit"><i class="far fa-bookmark"></i> <span>save playlist</span></button>
            </form>

            <div class="thumb">
                <img src="/images/CoursesCoverImages/{{$course->cover_image}}" alt="" loading="lazy">
                <span>{{$course->videos_count}}</span>
            </div>
        </div>
        <div class="column">
            <div class="tutor">
                <img src="/images/instructors/{{$course->instructor->profile_picture}}" alt="" loading="lazy">
                <div>
                    <h3>{{$course->instructor ? $course->instructor->first_name.' '.$course->instructor->last_name : 'No Instructor'}}</h3>
                    <span>{{$course->created_at->format('Y-m-d')}}</span>
                </div>
            </div>

            <div class="details">
                <h3>{{$course->course_title}}</h3>
                <p>{{$course->course_description}}</p>
            </div>
        </div>
    </div>

</section>

<section class="playlist-videos">

    <h1 class="heading">Playlist Videos</h1>
    @foreach($sectionsByCourseIdAndLoggedUser as $section)
        <p class="control-hide active">{{$section->section->section_name}} <i class="fa-solid fa-circle-down"></i></p>

        <div class="box-container mb-5 submenu" style="">
            @forelse($section->section->lectures as $lecture)
                <a class="box" href="{{ route('user.watchvideo', $lecture->id) }}">
                    <i class="fas fa-play"></i>
                    @if($lecture->videos->isNotEmpty() && isset($lecture->videos->first()->cover_image))
                        <img src="{{ asset('images/VideoCoverImages/' . $lecture->videos->first()->cover_image) }}" alt="" loading="lazy">
                    @else
                        <img src="{{ asset('images/VideoCoverImages/default.jpg') }}" alt="" loading="lazy">
                    @endif
                    <h3>{{$lecture->lecture_name}}</h3>
                </a>
            @empty
                <p class="text-center mt-3 mb-0 text-muted display-4">No lectures available.</p>
            @endforelse
        </div>
    @endforeach

</section>

@include('partials.user.user-footer')
@include('partials.user.user-footer-script')

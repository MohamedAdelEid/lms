@include('partials.user.user-header', ['title' => 'Treasure Academy|Watch Video'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')

<section class="watch-video pb-5">

    <div class="video-container">
        <div class="video">
            <video controls preload="metadata" controlsList="nodownload" autoplay loop
                src="{{ asset('storage/videos/' . $video->video_path) }}"
                poster="{{ asset('images/VideoCoverImages/' . $lecture->videos->first()->cover_image) }}">
            </video>
        </div>

        <h3 class="title">{{ $lecture->lecture_name }}</h3>
        <div class="info">
            <p class="date"><i class="fas fa-calendar"></i><span>{{ $lecture->created_at->format('Y-m-d') }}</span>
            </p>
            <p class="date"><i class="fas fa-heart"></i><span class="likes-count">{{ $numberOfLikes }}</span></p>
        </div>
        <div class="tutor">
            <img src="/images/instructors/{{ $instructorImage }}" alt="" loading="lazy">
            <div>
                <h3>{{ $instructorName }}</h3>
                <span>{{ $instructorQualification }}</span>
            </div>
        </div>
        <form action="" method="post" class="flex">
            <a href="{{ route('user.playlist', $lecture->section->course->id) }}" class="inline-btn">view playlist</a>
            <button class="like-btn" data-lecture-id="{{ $lecture->id }}"><i
                    class="far fa-heart"></i><span>like</span></button>
        </form>
        <p class="description">
            {{ $lecture->lecture_description }}
        </p>
    </div>

</section>
<section class="comments">
    <h1 id="comments-heading" class="heading">{{ $numberOfComments }} Comments</h1>

    <form id="add-comment-form" class="add-comment" @if ($existingComment && $existingComment->message !== null) disabled @endif>
        @csrf
        <h3>add comments</h3>
        <textarea name="comment_box" class="@error('comment_box') is-invalid @enderror" placeholder="Enter Your Comment"
                  required maxlength="1000" cols="30" rows="1" id="comment"
                  @if ($existingComment && $existingComment->message !== null) disabled @endif></textarea>
        @error('comment_box')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <input type="submit" value="add comment" class="inline-btn @if ($existingComment && $existingComment->message !== null) disabled-btn opacity-65 cursor-not-allowed @endif" name="add_comment">
    </form>
    <div class="box-container position-relative" id="comments-container">
        @foreach ($discussionsByLectureId as $discussion)
            @if ($discussion->message !== null)
                <div class="box position-relative" data-discussion-id="{{ $discussion->id }}">
                    @if(Auth::user()->id == $discussion->user->id)
                        <div class="dropdown position-absolute right-4 top-7 z-10">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                    class="rounded-circle btn-transparent rounded-circle btn-sm px-1 shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode fs-8"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item fs-5 edit-btn" href="#" data-discussion-id="{{ $discussion->id }}">Edit</a></li>
                                <li><a class="
                                dropdown-item fs-5 hover:text-red-500 transition duration-300 ease-in-out text-gray-500 p-3 m-0 text-start bg-transparent
                                dropdown-item fs-5 hover:text-red-500 transition duration-300 ease-in-out delete-btn" href="#" data-discussion-id="{{ $discussion->id }}">Delete</a></li>
                            </ul>
                        </div>
                    @endif
                    <div class="user">
                        <img src="/images/users/{{ $discussion->user->profile_picture }}" alt="" loading="lazy">
                        <div>
                            <h3>{{ $discussion->user->name }}</h3>
                            <span>{{ $discussion->message_date }}</span>
                        </div>
                    </div>
                    <div class="comment-box">{{ $discussion->message }}</div>
                </div>
            @endif
        @endforeach

    </div>
</section>
@include('partials.user.user-footer-script')
@include('partials.user.user-footer')
{{-- like ajax code --}}
<script>
    $(document).ready(function() {
        $('button.like-btn, button.dislike-btn').click(function(e) {
            e.preventDefault();
            var lectureId = $(this).data('lecture-id');
            var $likeBtn = $(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('like.video') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    lecture_id: lectureId
                },
                success: function(response) {
                    if (response.success) {
                        var likesCount = response.likesCount;
                        var likeStatus = response.likeStatus;

                        $('.likes-count').text(likesCount);

                        if (likeStatus === '1') {
                            $likeBtn.removeClass('like-btn').addClass('dislike-btn');
                            $likeBtn.find('i').removeClass('far').addClass('fas');
                            $likeBtn.find('span').text('Dislike');
                        } else if (likeStatus === '0') {
                            $likeBtn.removeClass('dislike-btn').addClass('like-btn');
                            $likeBtn.find('i').removeClass('fas').addClass('far');
                            $likeBtn.find('span').text('Like');
                        }
                    }
                }
            });
        });
    });
</script>
{{-- delete and edit on comment ajax code --}}
<script>
    $(document).ready(function() {
        $('#add-comment-form').submit(function(e) {
            // ... (your existing code)
        });

        // Attach event handlers to the parent element
        $('#comments-container').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            var discussionId = $(this).data('discussion-id');
            var $commentBox = $(this).closest('.box');
            var currentMessage = $commentBox.find('.comment-box').text();

            var newMessage = prompt('Enter the new message:', currentMessage);
            if (newMessage !== null) {
                $.ajax({
                    type: 'POST',
                    url: '/discussion/' + discussionId + '/edit',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: newMessage
                    },
                    success: function(response) {
                        if (response.success) {
                            $commentBox.find('.comment-box').text(newMessage);
                            console.log(response.message);
                        } else {
                            console.error('Failed to update discussion message');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to update discussion message:', error);
                    }
                });
            }
        });

        $('#comments-container').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var discussionId = $(this).data('discussion-id');
            var $commentBox = $(this).closest('.box');

            $.ajax({
                type: 'POST',
                url: '/discussion/' + discussionId + '/delete',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $commentBox.remove();
                        // Update the number of comments
                        var $commentsCount = $('#comments-heading');
                        var currentCount = parseInt($commentsCount.text());

                        $commentsCount.text(currentCount - 1);
                        console.log(response.message);
                    } else {
                        console.error('Failed to clear discussion message');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to clear discussion message:', error);
                }
            });
        });

    });
</script>
{{-- comment ajax code --}}
<script>
    $(document).ready(function() {
        $('#add-comment-form').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var lectureId = '{{ $lecture->id }}';

            $.ajax({
                type: 'POST',
                url: '{{ route('user.addComment', $lecture->id) }}',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var newComment = `
                        <div class="box position-relative" data-discussion-id="${response.discussion.id}">
                            <div class="dropdown position-absolute right-4 top-7 z-10">
                                <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                        class="rounded-circle btn-transparent rounded-circle btn-sm px-1 shadow-none">
                                    <i class="ti ti-dots-vertical fs-7 d-block text-mode fs-8"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item fs-5 edit-btn" href="#" data-discussion-id="${response.discussion.id}">Edit</a></li>
                                    <li><a class="dropdown-item fs-5 hover:text-red-500 transition duration-300 ease-in-out text-gray-500 p-3 m-0 text-start bg-transparent
dropdown-item fs-5 hover:text-red-500 transition duration-300 ease-in-out delete-btn" href="#" data-discussion-id="${response.discussion.id}">Delete</a></li>
                                </ul>
                            </div>
                            <div class="user">
                                <img src="/images/users/${response.discussion.user.profile_picture}" alt="" loading="lazy">
                                <div>
                                    <h3>${response.discussion.user.name}</h3>
                                    <span>${response.discussion.message_date}</span>
                                </div>
                            </div>
                            <div class="comment-box">${response.discussion.message}</div>
                        </div>
                    `;

                        $('#comments-container').append(newComment);
                        $('#comment').val('');

                        // Update the comment count
                        $('#comments-heading').text(`${response.numberOfComments} Comments`);

                        // Disable the form
                        $('#add-comment-form textarea, #add-comment-form input[type="submit"]')
                            .prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>

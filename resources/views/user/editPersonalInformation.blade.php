@include('partials.user.user-header', ['title' => 'Treasure Academy|Edit Page'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')

<section class="user-profile">

    <h1 class="heading">Edit Profile</h1>

    <div class="info position-relative">
        <div class="user">
            <div class="image-profile" data-toggle="modal" data-target="#exampleModalCenter">
                <img src="/images/users/{{ $user->profile_picture }}" alt="">
                <i class="ti ti-edit"></i>
            </div>
            <div class="name-profile">
                <h3>{{ $user->name }}</h3>
                <p>Student</p>
            </div>
        </div>

        <div class="profile-details">

            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success m-0 fs-7" id="success">
                        {{ session('success') }}
                    </div>
                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $('#success').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" id="error">
                        {{ session('error') }}
                    </div>
                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $('#error').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif
            </div>

            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="edit-border col-12">
                        <div></div>
                        <div>Edit Name</div>
                        <div></div>
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label label">New Name</label>
                        <input type="text" class="form-control fs-6 @error('name') is-invalid @enderror "
                            name="name" id="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong class="category-error">{{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="edit-border col-12 mt-5">
                        <div></div>
                        <div>Edit Password</div>
                        <div></div>
                    </div>
                    <div class="col-12">
                        <label for="old-password" class="form-label label">Old Password</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control auth__password fs-6 @error('old_password') is-invalid @enderror"
                                name="old_password" id="old-password">
                            <i
                                class="password__icon text-primary fs-8 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                            @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="category-error">{{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <label for="new-password" class="form-label label">New Password</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control auth__password  fs-6 @error('new_password') is-invalid @enderror"
                                name="new_password" id="new-password">
                            <i
                                class="password__icon text-primary fs-8 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="category-error">{{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <label for="confirm-password" class="form-label label">Confirm Password</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control auth__password fs-6 @error('confirm_password') is-invalid @enderror"
                                name="confirm_password" id="confirm-password">
                            <i
                                class="password__icon text-primary fs-8 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="category-error">{{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="submit-button fs-7">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!--modal image profile-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="margin:auto; width: 75%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="font-size: 2.5rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="rounded" src="/images/users/{{ $user->profile_picture }}" alt="">
                </div>
                <form action="{{ route('images.handle') }}" method="POST" id="imageForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" id="action" value="">
                    <div class="modal-footer justify-content-center pt-0">
                        @if ($user->profile_picture != 'default.jpg')
                            <button type="button" class="btn btn-danger mr-3 fs-7 pl-2 pr-2 pt-1 pb-1 bg-transparent"
                                onclick="deleteImage()">Delete <i class="ti ti-trash"></i></button>
                        @endif
                        <div class="p-0">
                            <label for="img-file-modal"
                                class="btn btn-primary ml-3 fs-7 pl-2 pr-2 pt-1 pb-1 bg-transparent">Change <i
                                    class="ti ti-edit"></i></label>
                            <input name="profile_picture" type="file" id="img-file-modal" hidden
                                onchange="updateImage()">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

@include('partials.user.user-footer')
@include('partials.user.user-footer-script')
<script>
    function deleteImage() {
        document.getElementById('action').value = 'delete';
        document.getElementById('imageForm').submit();
    }

    function updateImage() {
        document.getElementById('action').value = 'update';
        document.getElementById('imageForm').submit();
    }
</script>

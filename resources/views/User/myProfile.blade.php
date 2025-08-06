@include('partials.user.user-header', ['title' => 'Treasure Academy|MyProfile'])
@include('partials.user.user-nav')
@include('partials.user.user-aside')

<section class="user-profile">
    <h1 class="heading">Your Profile</h1>
    <div class="info position-relative">
        <div class="dropdown position-absolute right-4 top-7">
            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 shadow-none">
                <i class="ti ti-dots-vertical fs-7 d-block text-mode fs-8"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item fs-5" href="{{ route('user.editUserInformation') }}">Edit Profile</a>
                </li>
            </ul>
        </div>
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
            <div class="row">
                <div class="col-12">
                    <p class="title-information">Your Email</p>
                    <div class="information d-flex align-items-center">
                        <i class="fa-regular fa-envelope me-3"></i>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <p class="title-information">Phone Number</p>
                    <div class="information d-flex align-items-center">
                        <i class="ti ti-phone me-3"></i>
                        <p>{{ $user->phone_number }}</p>
                    </div>
                </div>
            </div>
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
                <form action="{{ route('images.handle')}}" method="POST" id="imageForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" id="action" value="">
                    <div class="modal-footer justify-content-center pt-0">
                        @if($user->profile_picture != 'default.jpg')
                            <button type="button" class="btn btn-danger mr-3 fs-7 pl-2 pr-2 pt-1 pb-1 bg-transparent" onclick="deleteImage()">Delete <i class="ti ti-trash"></i></button>
                        @endif
                            <div class="p-0">
                            <label for="img-file-modal" class="btn btn-primary ml-3 fs-7 pl-2 pr-2 pt-1 pb-1 bg-transparent">Change <i class="ti ti-edit"></i></label>
                            <input name="profile_picture" type="file" id="img-file-modal" hidden onchange="updateImage()">
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

@include('partials.admin.header',['title'=>'My Profile'])
@include('partials.admin.aside')
@include('partials.admin.nav')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="w-100">
                <div class="card-body p-4 pt-0">
                    <div class="mb-4">
                        <h5 class="mb-0 fw-bold text-mode fs-6 mb-3">My Profile</h5>
                        <hr>
                    </div>
                    @if (session('Profile-success'))
                        <div class="alert alert-success" id="profileAlert">
                            {{ session('Profile-success') }}
                        </div>
                        <script>
                            $(document).ready(function() {
                                setTimeout(function() {
                                    $('#profileAlert').fadeOut();
                                }, 3000);
                            });
                        </script>
                    @endif
                    <form action="{{ route('admin.updateOrDeleteProfilePicture') }}" method="post"
                        enctype="multipart/form-data" id="upload-img" onchange="submit()">
                        @csrf
                        <div class="img-name-admin row align-items-center ms-2">
                            <div class="profile-pic-div d-flex justify-content-center col">
                                <div id="click-modal" style="width:100%">
                                    <img src="images/admins/{{ $adminData->profile_picture }}" id="profilePicContainer"
                                        loading="lazy">
                                </div>
                                <span for="img-file" class="uploadBtn"><img
                                        src="../../assets/images/dashboardAdmin/camera.png" alt=""
                                        loading="lazy"></span>
                            </div>
                            <div class="name-profile col mb-3 ps-3">
                                <p class="text-mode text-capitalize pb-4 fs-6">
                                    {{ $adminData->first_name . ' ' . $adminData->last_name }}</p>
                            </div>
                        </div>
                        <div id="modal" class="modal">
                            <div class="row">
                                <div class="content-modal col-9 col-sm-6 col-md-5 col-lg-4 col-xl-3" id="content-modal">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <div class="modal-header-text">
                                        <h2>Profile Picture</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="profile-pic-container">
                                            <img src="" id="modalImage">
                                        </div>
                                    </div>
                                    <div
                                        class="footer-modal d-flex justify-content-center align-items-center ps-3 pe-3">
                                            @if($adminData->profile_picture != 'default.jpg')
                                        <div class="p-0 me-3">
                                            <button class="delete-btn btn btn-danger fs-3 ps-2 pe-2 pt-1 pb-1"
                                                name="delete" onclick="closeModal()">Delete
                                                <i class="ti ti-trash"></i></button>
                                            @endif
                                        </div>
                                        <div class="p-0">
                                            <label for="img-file-modal"
                                                class="change-btn fs-3 btn btn-primary ps-2 pe-2 pt-1 pb-1">Change
                                                <i class="ti ti-edit"></i></label>
                                            <input name="profile_picture" type="file" id="img-file-modal" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="ms-2 mt-4">
                        <div class="d-flex align-items-center content-profile">
                            <div class="Personal-details">
                                <p class="mb-0 me-4 clickable-paragraph text-mode" data-target="personal-details">
                                    Personal details</p>
                            </div>
                            <div class="">
                                <p class="mb-0 clickable-paragraph text-mode" data-target="settings">Settings</p>
                            </div>
                        </div>
                        <div class="mt-4" id="personal-details">
                            <!-- Personal details content -->
                            <div class="content-personal-details">
                                <table class="ms-2 table-profile text-mode">
                                    <th class="bg-primary-dark p-3" colspan="2">
                                        <p class="text-mode fs-5">Personal Information</p>
                                    </th>
                                    <tr class="border-bottom-mode p-2">
                                        <td class="p-2 py-3">
                                            <p class="mb-0">Frist Name</p>
                                        </td>
                                        <td>
                                            <h5 class="mt-0 text-mode fs-4">{{ $adminData->first_name }}</h5>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom-mode mt-4 p-0">
                                        <td class="p-2 py-3">
                                            <p class="mb-0">Last Name</p>
                                        </td>
                                        <td>
                                            <h5 class="mt-0 text-mode fs-4">{{ $adminData->last_name }}</h5>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom-mode p-0">
                                        <td class="p-2 py-3">
                                            <p class="mb-0">Phone</p>
                                        </td>
                                        <td>
                                            <h5 class="mt-0 text-mode fs-4">{{ $adminData->phone_number }}</h5>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td class="p-2 py-3">
                                            <p class="mb-0">Email</p>
                                        </td>
                                        <td>
                                            <h5 class="mt-0 text-mode fs-4">{{ $adminData->email }}</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div id="settings" style="display: none;">
                            <!-- Settings content -->
                            <div class="mt-3">
                                <div class="d-flex align-items-center ">
                                    <div class="Personal-details-edit">
                                        <p class="mb-0 me-2 clickable-edit btn btn-primary"
                                            data-target="personal-details-edit">
                                            Personal details
                                        </p>
                                    </div>
                                    <div class="">
                                        <p class="mb-0 clickable-edit btn btn-primary" data-target="password-edit">Reset
                                            Password</p>
                                    </div>
                                </div>
                            </div>
                            <div class="content-setting mt-3" id="personal-details-edit">
                                @if (session('success'))
                                    <div class="alert alert-success" id="success">
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
                                <form action="{{ route('admin.changePersonalDetails') }}" method="post">
                                    @csrf
                                    <div class="row ms-1 me-1">
                                        <div class="col-12 pb-3 ps-0 pe-0 me-lg-5">
                                            <div class="pb-2 ps-0 pe-0">
                                                <label for="first-name" class="form-label text-mode">First
                                                    Name</label>
                                                <div class="position-relative">
                                                    <input type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        name="first_name" id="first-name"
                                                        value="{{ $adminData->first_name }}">
                                                    <span class="input-group-text icon-edit">
                                                        <i class="ti ti-edit"></i>
                                                    </span>
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="pb-2 ps-0 pe-0 mt-1">
                                                <label for="last-name" class="form-label text-mode">Last Name</label>
                                                <div class="position-relative">
                                                    <input type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        name="last_name" id="last-name"
                                                        value="{{ $adminData->last_name }}">
                                                    <span class="input-group-text icon-edit">
                                                        <i class="ti ti-edit"></i>
                                                    </span>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="pb-1 ps-0 pe-0 mt-1">
                                                <label for="phone" class="form-label text-mode">Phone</label>
                                                <div class="position-relative">
                                                    <input type="text"
                                                        class="form-control @error('phone_number') is-invalid @enderror"
                                                        name="phone_number" id="phone"
                                                        value="{{ $adminData->phone_number }}">
                                                    <span class="input-group-text icon-edit">
                                                        <i class="ti ti-edit"></i>
                                                    </span>
                                                    @error('phone_number')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-0">
                                            <button type="submit" name="submit"
                                                class="btn btn-primary text-mode">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="password-edit" class="mt-3" style="display:none;">
                                @if (session('success'))
                                    <div class="alert alert-success" id="success">
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
                                <form action="{{ route('admin.ChangePassword') }}" method="post">
                                    @csrf
                                    <div class="row ms-1 me-1">
                                        <div class="col-12 pb-2 ps-0 pe-0 me-lg-5">
                                            <div class="pb-2 ps-0 pe-0">
                                                <label for="old-password" class="form-label text-mode">Old
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password" placeholder="Enter Old Password"
                                                        class="form-control auth__password @error('old_password') is-invalid @enderror"
                                                        name="old_password" id="old-password" value="">
                                                    <span class="password__icon input-group-text icon-edit">
                                                        <i
                                                            class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                                    </span>
                                                    @error('old_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="pb-2 ps-0 pe-0 mt-1">
                                                <label for="password" class="form-label text-mode">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" placeholder="Enter New Password"
                                                        class="form-control auth__password @error('new_password') is-invalid @enderror"
                                                        name="new_password" id="password">
                                                    <span class="password__icon input-group-text icon-edit">
                                                        <i
                                                            class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                                    </span>
                                                    @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="pb-3 ps-0 pe-0 mt-1">
                                                <label for="confirm-password" class="form-label text-mode">Confirm
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password" placeholder="Confirm Password"
                                                        class="form-control auth__password @error('confirm_password') is-invalid @enderror"
                                                        name="confirm_password" id="confirm-password">
                                                    <span class="password__icon input-group-text icon-edit">
                                                        <i
                                                            class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                                    </span>
                                                    @error('confirm_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong class="category-error">{{ $message }} </strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="p-0 mt-3">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary text-mode">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')
<script></script>

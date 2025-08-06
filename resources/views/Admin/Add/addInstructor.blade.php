@include('partials.admin.header', ['title' => 'Add Instructor'])
@include('partials.admin.aside')
@include('partials.admin.nav')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">Add Instructor</h5>
                <hr>
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
                <div class="card">
                    <form method="POST" action="{{ route('admin.storeInstructor') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row justify-content-between bg-primary-dark">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label text-mode">First Name</label>
                                    <input type="text" value="{{ old('first_name') }}" placeholder="First Name"
                                        name="first_name"
                                        class="form-control  @error('first_name') is-invalid @enderror" id="firstName">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="lastName" class="form-label text-mode">Last Name</label>
                                    <input type="text" value="{{ old('last_name') }}" placeholder="Last Name"
                                        name="last_name" class="form-control  @error('last_name') is-invalid @enderror"
                                        id="lastName">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-mode">E-mail</label>
                                    <input type="email" value="{{ old('email') }}" placeholder="E-mail"
                                        name="email" class="form-control  @error('email') is-invalid @enderror"
                                        id="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="numberOfLecture" class="form-label text-mode">Phone Number</label>
                                    <input value="{{ old('phone_number') }}" type="text" placeholder="Phone Number"
                                        name="phone_number"
                                        class="form-control  @error('phone_number') is-invalid @enderror"
                                        id="numberOfLecture">
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label text-mode">Password</label>
                                    <div class="position-relative">
                                        <input type="text" placeholder="Password" name="password"
                                            class="form-control auth__password @error('password') is-invalid @enderror"
                                            id="password">
                                        <span class="password__icon input-group-text icon-edit">
                                            <i
                                                class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="qualifications" class="form-label text-mode">Qualifications</label>
                                    <input type="text" value="{{ old('qualifications') }}"
                                        placeholder="Qualifications"
                                        class="form-control  @error('qualifications') is-invalid @enderror "
                                        name="qualifications" id="qualifications">
                                    @error('qualifications')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label text-mode">Photo</label>
                                    <input type="file" value="{{ old('profile_picture') }}" name="profile_picture"
                                        class="form-control @error('profile_picture') is-invalid @enderror "
                                        id="numberOfLecture">
                                    @error('profile_picture')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-xl-3">
                                <button type="submit" class="btn btn-primary text-mode">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

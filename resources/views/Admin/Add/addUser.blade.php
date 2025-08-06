@include('partials.admin.header',['title'=>'Add User'])
@include('partials.admin.aside')
@include('partials.admin.nav')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">Add User</h5>
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
                <form method="POST" action="{{ route('admin.storeUser') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row justify-content-between bg-primary-dark">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label text-mode">Name</label>
                                <input type="text" name="name" placeholder="Name"
                                    class="form-control @error('name') is-invalid @enderror" id="firstName">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-mode">E-mail</label>
                                <input type="email" placeholder="E-mail" value="{{ old('email') }}" name="email"
                                    class="form-control  @error('email') is-invalid @enderror" id="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="numberOfLecture" class="form-label text-mode">Phone Number</label>
                                <input type="text" placeholder="Phone Number" name="phone_number"
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
                                    <input type="password" placeholder="Password" name="password"
                                        class="form-control auth__password @error('password') is-invalid @enderror" id="password">
                                    <span class="password__icon input-group-text icon-edit">
                                        <i class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label text-mode">Photo</label>
                                <input type="file" placeholder="Photo" value="{{ old('profile_picture') }}"
                                    name="profile_picture"
                                    class="form-control  @error('profile_picture') is-invalid @enderror" id="photo">
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
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

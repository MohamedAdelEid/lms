@include('partials.admin.header',['title'=>'Edit Instructor'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','add Category')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
                    <script>
                        $(document).ready(function(){
                            setTimeout(function(){
                                $('#success').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" id="error">
                        {{ session('error') }}
                    </div>
                    <script>
                        $(document).ready(function(){
                            setTimeout(function(){
                                $('#error').fadeOut();
                            }, 3000);
                        });
                    </script>
                @endif
                <h5 class="card-title fw-semibold text-mode mb-3">Edit Instructor</h5>
                <hr>
                <form method="POST" action="{{route('edit.editInstructor',['id' => $currentInstructorData->id])  }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body row justify-content-between bg-primary-dark">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label text-mode">First Name</label>
                                <input type="text" value="{{$currentInstructorData->first_name}}"
                                    placeholder="First Name" name="first_name"
                                    class="form-control  @error('first_name') is-invalid @enderror" id="firstName">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label text-mode">Last Name</label>
                                <input type="text" value="{{$currentInstructorData->last_name}}"
                                    placeholder="Last Name"  name="last_name"
                                    class="form-control  @error('last_name') is-invalid @enderror" id="lastName">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-mode">E-mail</label>
                                <input type="email" value="{{$currentInstructorData->email}}"
                                    placeholder="E-mail"  name="email"
                                    class="form-control  @error('email') is-invalid @enderror" id="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="qualifications" class="form-label text-mode">Qualifications</label>
                                <input type="text" value="{{$currentInstructorData->qualifications}}"
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
                                <label for="numberOfLecture" class="form-label text-mode">Phone Number</label>
                                <input type="text" value="{{$currentInstructorData->phone_number}}"
                                    placeholder="Phone Number" name="phone_number"
                                    class="form-control  @error('phone_number') is-invalid @enderror" id="numberOfLecture">
                                @error('phone_number')
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

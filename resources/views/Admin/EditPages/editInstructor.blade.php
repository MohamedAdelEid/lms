@include('partials.admin.header',['title'=>'Edit Instructor'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','Edit Instructor')

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
                
                <form method="POST" action="{{route('edit.editInstructor',['id' => $currentInstructorData->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body row justify-content-between bg-primary-dark">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label text-mode">First Name</label>
                                <input type="text" value="{{$currentInstructorData->first_name}}"
                                    placeholder="First Name" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror" id="firstName">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label text-mode">Last Name</label>
                                <input type="text" value="{{$currentInstructorData->last_name}}"
                                    placeholder="Last Name" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror" id="lastName">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-mode">E-mail</label>
                                <input type="email" value="{{$currentInstructorData->email}}"
                                    placeholder="E-mail" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email">
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
                                    class="form-control @error('qualifications') is-invalid @enderror"
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
                                    class="form-control @error('phone_number') is-invalid @enderror" id="numberOfLecture">
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                            <!-- Photo Section -->
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label text-mode">Profile Picture</label>
                                
                                <!-- Current Photo Preview -->
                                <div class="mb-3">
                                    <div class="current-photo-container">
                                        <label class="form-label text-mode small">Current Photo:</label>
                                        <div class="d-flex align-items-center">
                                            <img src="/images/instructors/{{ $currentInstructorData->profile_picture }}" 
                                                 alt="Current Profile Picture" 
                                                 class="rounded border"
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 id="currentPhotoPreview">
                                            <div class="ms-3">
                                                <small class="text-mode">{{ $currentInstructorData->profile_picture }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- New Photo Upload -->
                                <div class="mb-3">
                                    <label class="form-label text-mode small">Upload New Photo (Optional):</label>
                                    <input type="file" 
                                           name="profile_picture" 
                                           class="form-control @error('profile_picture') is-invalid @enderror" 
                                           id="profile_picture"
                                           accept="image/*"
                                           onchange="previewNewImage(this)">
                                    <small class="form-text text-muted">
                                        Accepted formats: JPG, PNG, JPEG. Max size: 5MB
                                    </small>
                                    @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <!-- New Photo Preview -->
                                <div class="mb-3" id="newPhotoPreview" style="display: none;">
                                    <label class="form-label text-mode small">New Photo Preview:</label>
                                    <div class="d-flex align-items-center">
                                        <img src="/placeholder.svg" 
                                             alt="New Profile Picture Preview" 
                                             class="rounded border"
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             id="newPhotoImg">
                                        <div class="ms-3">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearNewPhoto()">
                                                <i class="ti ti-x"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <button type="submit" class="btn btn-primary text-mode">
                                <i class="ti ti-device-floppy me-1"></i>Update Instructor
                            </button>
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

<script>
function previewNewImage(input) {
    const file = input.files[0];
    const previewContainer = document.getElementById('newPhotoPreview');
    const previewImg = document.getElementById('newPhotoImg');
    
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, JPEG)');
            input.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            input.value = '';
            previewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

function clearNewPhoto() {
    document.getElementById('profile_picture').value = '';
    document.getElementById('newPhotoPreview').style.display = 'none';
    document.getElementById('newPhotoImg').src = '';
}
</script>

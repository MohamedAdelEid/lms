@include('partials.admin.header',['title'=>'Edit Lecture'])
@include('partials.admin.aside')
@include('partials.admin.nav')

@section('title', 'Edit Lecture')

<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
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
                
                <h5 class="card-title fw-semibold text-mode mb-3">Edit Lecture</h5>
                <hr>
                
                <form method="post" action="{{ route('edit.editLecture', ['id' => $currentLectureData->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body row justify-content-between">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="nameCourse" class="form-label text-mode">Lecture Name</label>
                                <input name="lecture_name" 
                                       value="{{ old('lecture_name', $currentLectureData->lecture_name) }}"
                                       type="text" 
                                       placeholder="Lecture Name"
                                       class="form-control @error('lecture_name') is-invalid @enderror" 
                                       id="nameCourse">
                                @error('lecture_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="descriptionLecture" class="form-label text-mode">Description</label>
                                <textarea class="form-control @error('descriptionLecture') is-invalid @enderror"  
                                          name="descriptionLecture" 
                                          placeholder="Description" 
                                          id="descriptionLecture"
                                          cols="30" 
                                          rows="4">{{ old('descriptionLecture', $currentLectureData->lecture_description) }}</textarea>
                                @error('descriptionLecture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Current Video Cover Preview -->
                            @if($currentLectureData->videos->isNotEmpty())
                                <div class="mb-3">
                                    <label class="form-label text-mode">Current Video Cover</label>
                                    <div class="current-cover-preview mb-3">
                                        <img src="/images/VideoCoverImages/{{ $currentLectureData->videos->first()->cover_image }}" 
                                             alt="{{ $currentLectureData->lecture_name }}"
                                             class="img-thumbnail"
                                             style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                            @endif

                            <!-- New Cover Image Upload -->
                            <div class="mb-3">
                                <label for="cover-image" class="form-label text-mode">Update Cover Image (Optional)</label>
                                <input type="file" 
                                       id="cover-image" 
                                       name="cover_image"
                                       class="form-control @error('cover_image') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewCoverImage(this)">
                                @error('cover_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-text text-muted">
                                    Leave empty to keep current cover. Accepted formats: JPG, PNG, GIF. Max size: 2MB
                                </div>
                                
                                <!-- New Cover Preview -->
                                <div id="new-cover-preview" class="mt-2" style="display: none;">
                                    <label class="form-label text-mode">New Cover Preview:</label>
                                    <img id="preview-cover" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="section" class="form-label text-mode">Section</label>
                                <select name="section_id" 
                                        id="section"
                                        class="form-control @error('section_id') is-invalid @enderror">
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                                {{ old('section_id', $currentLectureData->section_id) == $section->id ? 'selected' : '' }}>
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Current Video Info -->
                            @if($currentLectureData->videos->isNotEmpty())
                                <div class="mb-3">
                                    <label class="form-label text-mode">Current Video</label>
                                    <div class="alert alert-info">
                                        <i class="ti ti-video me-2"></i>
                                        <strong>{{ $currentLectureData->videos->first()->name }}</strong>
                                        <br>
                                        <small>Uploaded: {{ $currentLectureData->videos->first()->created_at->format('Y-m-d H:i') }}</small>
                                    </div>
                                </div>
                            @endif

                            <!-- New Video Upload -->
                            <div class="mb-3">
                                <label for="video-file" class="form-label text-mode">Update Video (Optional)</label>
                                <input type="file" 
                                       name="video_path" 
                                       id="video-file"
                                       class="form-control @error('video_path') is-invalid @enderror"
                                       accept="video/*"
                                       onchange="showVideoInfo(this)">
                                @error('video_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-text text-muted">
                                    Leave empty to keep current video. Accepted formats: MP4, AVI, MOV. Max size: 100MB
                                </div>
                                
                                <!-- Video Upload Progress -->
                                <div id="video-upload-progress" class="mt-2" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <progress class="progress" id="progressBar" value="0" max="100" style="width:300px;"></progress>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="cancelUpload()">
                                            Cancel
                                        </button>
                                    </div>
                                    <div id="upload-status" class="mt-1"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-lg text-mode px-5">
                                <i class="ti ti-edit me-2"></i>Update Lecture
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
function previewCoverImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-cover').src = e.target.result;
            document.getElementById('new-cover-preview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function showVideoInfo(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        document.getElementById('upload-status').innerHTML = `
            <small class="text-info">
                Selected: ${file.name} (${fileSize} MB)
            </small>
        `;
        document.getElementById('video-upload-progress').style.display = 'block';
    }
}

function cancelUpload() {
    document.getElementById('video-file').value = '';
    document.getElementById('video-upload-progress').style.display = 'none';
}
</script>

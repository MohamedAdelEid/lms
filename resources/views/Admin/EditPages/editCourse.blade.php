@include('partials.admin.header',['title'=>'Edit Course'])
@include('partials.admin.aside')
@include('partials.admin.nav')

@section('title', 'Edit Course')

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
                            }, 5000);
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
                            }, 5000);
                        });
                    </script>
                @endif
                
                <h5 class="card-title fw-semibold text-mode mb-3">Edit Course</h5>
                <hr>
                
                <div class="p-3">
                    <form method="post" action="{{ route('edit.editCourse', ['id' => $currentCourseData->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body row justify-content-between">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="nameCourse" class="form-label text-mode">Name</label>
                                    <input type="text" 
                                           value="{{ old('course_title', $currentCourseData->course_title) }}"
                                           name="course_title"
                                           class="form-control @error('course_title') is-invalid @enderror"
                                           id="nameCourse">
                                    @error('course_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="descriptionCourse" class="form-label text-mode">Description</label>
                                    <textarea class="form-control @error('course_description') is-invalid @enderror" 
                                              name="course_description"
                                              placeholder="Description" 
                                              id="descriptionCourse" 
                                              cols="30" 
                                              rows="4">{{ old('course_description', $currentCourseData->course_description) }}</textarea>
                                    @error('course_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="priceCourse" class="form-label text-mode">Price</label>
                                    <input type="number" 
                                           name="price" 
                                           id="priceCourse"
                                           value="{{ old('price', $currentCourseData->price) }}"
                                           class="form-control @error('price') is-invalid @enderror"
                                           step="0.01"
                                           min="0">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <!-- Current Image Preview -->
                                <div class="mb-3">
                                    <label class="form-label text-mode">Current Cover Image</label>
                                    <div class="current-image-preview mb-3">
                                        <img src="/images/CoursesCoverImages/{{ $currentCourseData->cover_image }}" 
                                             alt="{{ $currentCourseData->course_title }}"
                                             class="img-thumbnail"
                                             style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                                
                                <!-- New Image Upload -->
                                <div class="mb-3">
                                    <label for="cover-course" class="form-label text-mode">Update Cover Image (Optional)</label>
                                    <input type="file" 
                                           id="cover-course" 
                                           name="cover_image"
                                           class="form-control @error('cover_image') is-invalid @enderror"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Leave empty to keep current image. Accepted formats: JPG, PNG, GIF. Max size: 2MB
                                    </div>
                                    
                                    <!-- New Image Preview -->
                                    <div id="new-image-preview" class="mt-2" style="display: none;">
                                        <label class="form-label text-mode">New Image Preview:</label>
                                        <img id="preview-img" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label text-mode">Category</label>
                                    <select name="category_id" 
                                            id="category"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ old('category_id', $currentCourseData->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="instructor" class="form-label text-mode">Instructor</label>
                                    <select name="instructor_id" 
                                            id="instructor"
                                            class="form-control @error('instructor_id') is-invalid @enderror">
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}"
                                                    {{ old('instructor_id', $currentCourseData->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->first_name . ' ' . $instructor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label text-mode">Status</label>
                                    <select name="status" 
                                            id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                        @foreach (\App\Models\Dashboard\Course::getStatusOptions() as $statusValue => $statusLabel)
                                            <option value="{{ $statusValue }}"
                                                    {{ old('status', $currentCourseData->status) == $statusValue ? 'selected' : '' }}>
                                                {{ $statusLabel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary btn-lg text-mode px-5">
                                    <i class="ti ti-edit me-2"></i>Update Course
                                </button>
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

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('new-image-preview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

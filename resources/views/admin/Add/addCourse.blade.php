@include('partials.admin.header',['title'=>'Add Course'])
@include('partials.admin.aside')
@include('partials.admin.nav')

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
                
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Course</h5>
                <hr>
                
                <div class="card">
                    <form method="POST" action="{{ route('admin.storeCourse') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row justify-content-between bg-primary-dark">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="nameCourse" class="form-label text-mode">Name</label>
                                    <input type="text" 
                                           value="{{ old('course_title') }}" 
                                           name="course_title"
                                           placeholder="Course Name"
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
                                              rows="4">{{ old('course_description') }}</textarea>
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
                                           value="{{ old('price') }}"
                                           class="form-control @error('price') is-invalid @enderror" 
                                           placeholder="Price"
                                           step="0.01"
                                           min="0"
                                           id="priceCourse">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cover-course" class="form-label text-mode">Cover Image</label>
                                    <input type="file" 
                                           id="cover-course" 
                                           name="cover_image"
                                           class="form-control @error('cover_image') is-invalid @enderror"
                                           accept="image/*">
                                    @error('cover_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Accepted formats: JPG, PNG, GIF. Max size: 2MB
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label text-mode">Category</label>
                                    <select name="category_id" 
                                            id="category"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        <option value="">Select Instructor</option>
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" 
                                                    {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
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
                                                    {{ old('status', 'upcoming') == $statusValue ? 'selected' : '' }}>
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
                                    <i class="ti ti-plus me-2"></i>Create Course
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

@include('partials.admin.header',['title'=>'Add Lecture'])
@include('partials.admin.aside')
@include('partials.admin.nav')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Lecture</h5>
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
                    <form method="POST" action="{{ route('admin.storeLecture') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row justify-content-between bg-primary-dark">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="nameCourse" class="form-label text-mode">Name</label>
                                    <input name="lecture_name" value="{{ old('lecture_name') }}" type="text"
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
                                    <label for="select-course" class="form-label text-mode">Course</label>
                                    <select name="course_id" id="select-course" class="form-control">
                                        <option value="">Select a course</option>
                                    @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_title }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                     </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="descriptionLecture" class="form-label text-mode">Description</label>
                                    <textarea  class="form-control @error('lecture_description') is-invalid @enderror" name="lecture_description"
                                        placeholder="Description" id="descriptionLecture" cols="30" rows="1"></textarea>
                                    @error('lecture_description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="cover-course" class="form-label text-mode">Photo</label>
                                    <input type="file" value="" id="cover-course" name="cover_image"
                                        class="form-control @error('cover_image') is-invalid @enderror">
                                    @error('cover_image')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">

                                <div class="mb-3">
                                    <label for="select-section" class="form-label text-mode">Sections</label>
                                    <select name="section_id" class="form-control @error('section_id') is-invalid @enderror" id="select-section">
                                        <option value="">Select a section</option>

                                        <!-- Sections will be populated dynamically via AJAX -->
                                    </select>
                                    @error('section_id')
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 ">
                                    <label for="file1" class="form-label text-mode">Video</label>
                                    <input type="file" name="video_path" id="file1"
                                        class="form-control @error('video_path') is-invalid @enderror"
                                        onchange="uploadFile()" value="{{ old('video_path') }}">
                                    @error('video_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <progress class="progress" id="progressBar" value="0" max="100"
                                            style="width:300px;"></progress>
                                        <!-- <span  class="cursor-pointer">Cancel</span> -->
                                        <div class="outer" onclick="reload()">
                                            <div class="inner">
                                                <label class="cancel text-mode">cancel</label>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 id="status"></h3>
                                    <p id="loaded_n_total"></p>
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
<script>
    $(document).ready(function() {
        $('#select-course').on('change', function() {
            var courseId = $(this).val();
            $.ajax({
                url: "{{ route('admin.fetchSections') }}",
                method: 'POST',
                data: { course_id: courseId, _token: "{{ csrf_token() }}" },
                success: function(data) {
                    $('#select-section').empty();
                    if ($.isEmptyObject(data)) {
                        $('#select-section').append('<option value="">No sections available</option>');
                    } else {
                        $.each(data, function(key, value) {
                            $('#select-section').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

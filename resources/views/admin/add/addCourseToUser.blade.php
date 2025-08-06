@include('partials.admin.header',['title'=>'Add Course To User'])
@include('partials.admin.aside')
@include('partials.admin.nav')

<div class="content-add container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Course To User</h5>
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
                <form method="POST" action="{{ route('admin.storeCourseToUser') }}">
                    @csrf
                    <div class="card-body row justify-content-between">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label text-mode">E-mail User</label>
                                <input type="email" placeholder="E-mail" value="" name="email" id="email"
                                    class="form-control  @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="courses" class="form-label text-mode">Course</label>
                                <select name="course_id" id="select-course"
                                    class="form-control @error('course_id') is-invalid @enderror">
                                    <option value="">Select a course</option>
                                @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" >{{ $course->course_title }}
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="courses" class="form-label text-mode">Sections</label>
                                <select name="sections[]" class="form-multi-select" id="select-section" multiple
                                    data-coreui-search="true">
                                    <option value="">Select a section</option>

                                    <!-- Sections will be populated dynamically via AJAX -->
                                </select>
                                @error('sections[]')
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
<script>
    $(document).ready(function() {
        $('#select-course').on('change', function() {
            var courseId = $(this).val();
            updateSectionOptions(courseId);
        });

        function updateSectionOptions(courseId) {
            $.ajax({
                url: "{{ route('admin.fetchSections') }}",
                method: 'POST',
                data: { course_id: courseId, _token: "{{ csrf_token() }}" },
                success: function(data) {
                    // Clear the existing section options
                    $('#select-section').empty();
                    $('.form-multi-select-option').remove();

                    // Populate the section options with the new data
                    $.each(data, function(key, value) {
                        $('#select-section').append('<option value="' + key + '">' + value + '</option>');
                        $('.form-multi-select-options').append(
                            '<div class="form-multi-select-option form-multi-select-option-with-checkbox" data-value="' + key + '">' + value + '</div>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

</script>

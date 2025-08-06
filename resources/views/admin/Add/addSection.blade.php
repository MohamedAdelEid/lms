@include('partials.admin.header', ['title' => 'Add Section'])
@include('partials.admin.aside')
@include('partials.admin.nav')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Sections</h5>
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
                    <form method="POST" action="{{ route('admin.storeSection') }}">
                        @csrf
                        <div class="card-body row justify-content-between bg-primary-dark">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="nameCourse" class="form-label text-mode">Name</label>
                                    <input type="text" placeholder="Section Name" value="{{ old('section_name') }}"
                                        name="section_name"
                                        class="form-control @error('section_name') is-invalid @enderror"
                                        id="nameCourse">
                                    @error('section_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="numberOfLecture" class="form-label text-mode">Number Of Lectures</label>
                                    <input type="text" placeholder="Number of Lecture"
                                        value="{{ old('number_of_lectures') }}" name="number_of_lectures"
                                        class="form-control @error('number_of_lectures') is-invalid @enderror"
                                        id="numberOfLecture">
                                    @error('number_of_lectures')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="courses" class="form-label text-mode">Courses</label>
                                    <select name="course_id" id="courses"
                                        class="form-control @error('course_id') is-invalid @enderror">
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

@include('partials.admin.header',['title'=>'Treasure Academy|Dashboard'])
@include('partials.admin.aside')
@include('partials.admin.nav')

<div class="container-fluid bg-secondary-dark pb-7">
    <!--  Row 1 show ♥ -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="show w-100">
                <div class="row justify-content-between align-items-center pb-0">
                    <div class="col-6 col-lg-4 col-xl-4 mb-4">
                        <div class="show-content show-first p-3">
                            <div class="head d-flex justify-content-between align-items-center">
                                <p class="title">Courses</p>
                                <div class="d-flex flex-column">
                                    <div class="dropdown">
                                        <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                            class="btn-transparent btn-sm px-1 btn shadow-none text-white ">
                                            <i class="ti ti-dots-vertical fs-7 d-block"></i>
                                        </button>
                                        <ul class="dropdown-menu view-add dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ route('viewCourses') }}">View</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p class="number text-center fw-bold bs-white">{{ $numberOfCourses }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-4 mb-4">
                        <div class="show-content show-secondary p-3">
                            <div class="head d-flex justify-content-between align-items-center">
                                <p class="title">Instructors</p>
                                <div class="d-flex flex-column">
                                    <div class="dropdown">
                                        <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                            class="btn-transparent btn-sm px-1 btn shadow-none text-white ">
                                            <i class="ti ti-dots-vertical fs-7 d-block"></i>
                                        </button>
                                        <ul class="dropdown-menu view-add dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ route('viewInstructors') }}">View</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p class="number text-center fw-bold bs-white">{{ $numberOfInstructors }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-xl-4 mb-4">
                        <div class="show-content show-third p-3">
                            <div class="head d-flex justify-content-between align-items-center">
                                <p class="title">Users</p>
                                <div class="d-flex flex-column">
                                    <div class="dropdown">
                                        <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                            class="btn-transparent btn-sm px-1 btn shadow-none text-white ">
                                            <i class="ti ti-dots-vertical fs-7 d-block"></i>
                                        </button>
                                        <ul class="dropdown-menu view-add dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="{{ route('viewUsers') }}">View</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p class="number text-center fw-bold bs-white">{{ $numberOfUsers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Row 2 categories ♥ -->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-5 pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Categories</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addCategory') }}">Add Category</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap mb-0">
                            <thead class="bg-third-dark">
                                <tr class="">
                                    <th class="col-4 text-center text-mode">Name</th>
                                    <th class="col-3 text-center text-mode">Creation Date</th>
                                    <th class="col-3 text-center text-mode">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody">
                                @if (count($lastFiveCategories) > 0)
                                    @foreach ($lastFiveCategories as $index => $category)
                                        <tr class="categoryRow border-b border-gray-800">
                                            <td>
                                                <div class="text-center">
                                                    <p class="fs-3 fw-normal mb-0 category-name text-mode">
                                                        {{ $category->category_name }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="fs-3 fw-normal mb-0 text-mode">
                                                        {{ $category->created_at->format('Y-m-d') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-center">
                                                    <p class="fs-3 fw-normal mb-0 text-mode">
                                                        {{ $category->updated_at->format('Y-m-d') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-mode">No Categories Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Row 3 courses ♥-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-4 pt-3">
                    <div class="d-flex mb-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Courses</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addCourse') }}">Add
                                        Course</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="bg-third-dark">
                                <tr class="text-mode">
                                    <th class="col text-center">Name</th>
                                    <th class="col text-center">Price</th>
                                    <th class="col text-center">Instructor</th>
                                    <th class="col text-center">Category</th>
                                    <th class="col text-center">Admin</th>
                                    <th class="col text-center">Status</th>
                                    <th class="col text-center">Creation Date</th>
                                    <th class="col text-center">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lastFiveCourses) > 0)
                                    @foreach ($lastFiveCourses as $index => $course)
                                        <tr class="text-center text-mode border-b border-gray-800">
                                            <td>
                                                <p class="fs-3 fw-normal mb-0">{{ $course->course_title }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0">{{ $course->price }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $course->instructor ? $course->instructor->first_name . ' ' . $course->instructor->last_name : 'No Instructor Founded' }}
                                                </p>
                                            </td>
                                            <td>
                                                {{ $course->category ? $course->category->category_name : 'No Category Founded' }}
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $course->admin ? $course->admin->first_name . ' ' . $course->admin->last_name : 'No Admin' }}
                                                </p>
                                            </td>
                                            <td
                                            @if ($course->status === 'active') style="color: rgb(34 197 94 / 1) !important;"
                                            @elseif($course->status === 'upcoming') style="color: rgba(59, 130, 246, 0.5)"
                                            @elseif($course->status === 'deactivated') style="color: rgba(239, 68, 68, 0.5)"
                                            @elseif($course->status === 'completed') style="color: rgba(139, 92, 246, 0.5)" @endif
                                            class="px-4 py-3 text-center">
                                                {{ $course->status }}
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">{{ $course->created_at->format('Y-m-d') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">{{ $course->updated_at->format('Y-m-d') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center text-mode">No Courses Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Row 4 sections ♥-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-2 pt-3">
                    <div class="d-flex mb-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Sections</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addSection') }}">Add
                                        Section</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="bg-third-dark">
                                <tr class="text-mode">
                                    <th class="col text-center">Name</th>
                                    <th class="col text-center">Course</th>
                                    <th class="col text-center">Admin</th>
                                    <th class="col text-center">Creation Date</th>
                                    <th class="col text-center">Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lastFiveSections) > 0)
                                    @foreach ($lastFiveSections as $index => $section)
                                        <tr class="text-center text-mode border-b border-gray-800">
                                            <td>
                                                <p class="fs-3 fw-normal mb-0">{{ $section->section_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 p-2">
                                                    {{ $section->course ? $section->course->course_title : 'No Course Founded' }}
                                                </p>
                                            </td>
                                            <td class="fs-3 fw-normal mb-0">
                                                {{ $section->admin ? $section->admin->first_name . ' ' . $section->admin->last_name : 'No Admin' }}
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $section->created_at->format('Y-m-d') }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $section->updated_at->format('Y-m-d') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-mode">No Sections Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class=" d-flex align-items-center ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Row 5 lectures ♥-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-4 pt-3">
                    <div class="d-flex mb-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Lectures</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addLecture') }}">Add
                                        Lecture</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="bg-third-dark">
                                <tr class="text-mode">
                                    <th class="col text-center">Name</th>
                                    <th class="col text-center">Section</th>
                                    <th class="col text-center">Admin</th>
                                    <th class="col text-center">Creation Date</th>
                                    <th class="col text-center">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lastFiveLectures) > 0)
                                    @foreach ($lastFiveLectures as $index => $lecture)
                                        <tr class="text-center text-mode border-b border-gray-800">
                                            <td>
                                                <p class="fs-3 fw-normal mb-0">{{ $lecture->lecture_name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $lecture->section ? $lecture->section->section_name : 'No Section Founded' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $lecture->admin ? $lecture->admin->first_name . ' ' . $lecture->admin->last_name : 'No Admin' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $lecture->created_at->format('Y-m-d') }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $lecture->updated_at->format('Y-m-d') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-mode">No Lectures Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Row 5 users ♥-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-4 pt-3">
                    <div class="d-flex mb-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Users</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addUser') }}">Add User</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="mb-5">
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="bg-third-dark">
                                <tr class="text-mode">
                                    <th class="col text-center">Name</th>
                                    <th class="col text-center">Email</th>
                                    <th class="col text-center">Phone Number</th>
                                    <th class="col text-center">Admin Name</th>
                                    <th class="col text-center">User Subscription Date </th>
                                    <th class="col text-center">User Subscription Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lastFiveUsers) > 0)
                                    @foreach ($lastFiveUsers as $index => $user)
                                        <tr class="text-center text-mode border-b border-gray-800">
                                            <td>
                                                <p class="fs-3 fw-normal mb-0">{{ $user->name }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $user->email }}
                                                </p>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="mb-0">{{ $user->phone_number }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $user->admin ? $user->admin->first_name . ' ' . $user->admin->last_name : 'No Admin' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">{{ $user->created_at->format('Y-m-d') }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">{{ $user->updated_at->format('Y-m-d') }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-mode">No Users Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Row 6 instructors ♥-->
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-dark">
                <div class="card-body pb-4 pt-3">
                    <div class="d-flex mb-2 justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-5 text-mode">Latest Instructors</h5>
                        <div class="dropdown">
                            <button id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
                                class="rounded-circle btn-transparent rounded-circle btn-sm px-1 btn shadow-none">
                                <i class="ti ti-dots-vertical fs-7 d-block text-mode"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="{{ route('admin.addInstructor') }}">Add
                                        Instructor</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive" data-simplebar>
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="bg-third-dark">
                                <tr class="text-mode">
                                    <th class="col text-center">Name</th>
                                    <th class="col text-center">Email</th>
                                    <th class="col text-center">Phone Number</th>
                                    <th class="col text-center">Admin Name</th>
                                    <th class="col text-center">Qualifications</th>
                                    <th class="col text-center">Creation Date </th>
                                    <th class="col text-center">Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($lastFiveInstructors) > 0)
                                    @foreach ($lastFiveInstructors as $index => $instructor)
                                        <tr class="text-center text-mode border-b border-gray-800">
                                            <td>
                                                <p class="fs-3 fw-normal mb-0">
                                                    {{ $instructor->first_name . ' ' . $instructor->last_name }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $instructor->email }}
                                                </p>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="mb-0">{{ $instructor->phone_number }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $instructor->admin ? $instructor->admin->first_name . ' ' . $instructor->admin->last_name : 'No Admin' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">{{ $instructor->qualifications }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $instructor->created_at->format('Y-m-d') }}</p>
                                            </td>
                                            <td>
                                                <p class="mb-0 text-center">
                                                    {{ $instructor->updated_at->format('Y-m-d') }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center text-mode">No Instructors Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

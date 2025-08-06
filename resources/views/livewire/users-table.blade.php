<div>
    <section class="mt-10">
        <div class="mx-auto px-4 lg:px-12">
            <div class="relative sm:rounded-lg overflow-hidden bg-primary-dark">
                <!-- Search Section -->
                <div class="flex items-center justify-between p-4 ps-0">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-5 p-2"
                                placeholder="Search users..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions Bar -->
                @if(count($selectedUsers) > 0)
                    <div class="bg-blue-600 text-white p-4 rounded-lg mb-4 mx-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <span class="font-semibold">{{ count($selectedUsers) }} users selected</span>
                                <div class="flex space-x-2">
                                    <button wire:click="bulkBlock" class="btn btn-sm btn-warning">
                                        <i class="ti ti-user-minus me-1"></i>Block All
                                    </button>
                                    <button wire:click="bulkUnblock" class="btn btn-sm btn-success">
                                        <i class="ti ti-user-plus me-1"></i>Unblock All
                                    </button>
                                    <button wire:click="bulkDelete" class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash me-1"></i>Delete All
                                    </button>
                                    <button wire:click="openBulkAssignModal" class="btn btn-sm btn-primary">
                                        <i class="ti ti-school me-1"></i>Assign Courses
                                    </button>
                                </div>
                            </div>
                            <button wire:click="$set('selectedUsers', [])" class="btn btn-sm btn-outline-light">
                                <i class="ti ti-x"></i> Clear Selection
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Loading Indicator -->
                <div wire:loading class="text-center py-2">
                    <span class="text-blue-500">Loading...</span>
                </div>

                <!-- Table Section -->
                <div class="row">
                    <div class="table-responsive" data-simplebar style="max-height: 1000px; overflow-y: auto;">
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="text-xs uppercase text-mode bg-third-dark">
                                <tr class="fs-3 fw-bold text-center">
                                    <th scope="col" class="px-4 py-3">
                                        <input type="checkbox" wire:model.live="selectAll" class="form-check-input">
                                    </th>
                                    <th scope="col" class="px-4 py-3">Image</th>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">E-mail</th>
                                    <th scope="col" class="px-4 py-3">Phone</th>
                                    <th scope="col" class="px-4 py-3">Courses</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">Admin</th>
                                    <th scope="col" class="px-4 py-3">Creation Date</th>
                                    <th scope="col" class="px-4 py-3">Last Update</th>
                                    <th scope="col" class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr wire:key="user-{{ $user->id }}" 
                                        class="border-b border-gray-800 text-mode fs-3 fw-bold text-center {{ in_array($user->id, $selectedUsers) ? 'bg-blue-50' : '' }} {{ $user->is_blocked ? 'bg-red-50' : '' }}">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" wire:model.live="selectedUsers" value="{{ $user->id }}" class="form-check-input">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="img-view d-flex justify-content-center col overflow-hidden" style="border-radius: 9px !important;">
                                                <div class="cursor-pointer hover:opacity-80 transition-opacity" style="width:100%">
                                                    <img loading="lazy"
                                                        wire:click="viewImage('{{ $user->profile_picture }}', '{{ $user->name }}')"
                                                        src="/images/users/{{ $user->profile_picture }}"
                                                        alt="{{ $user->name }}"
                                                        class="rounded hover:scale-105 transition-transform duration-200"
                                                        style="border-radius: 0px !important; cursor: pointer; width: 60px; height: 60px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </td>
                                        <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap">
                                            {{ $user->name }}
                                        </th>
                                        <td class="px-4 py-3 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="me-2">{{ $user->email }}</span>
                                                <button wire:click="copyEmail('{{ $user->email }}')" 
                                                        class="btn btn-sm btn-outline-secondary p-1"
                                                        title="Copy email">
                                                    <i class="ti ti-copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $user->phone_number }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($user->courses->isNotEmpty())
                                                <span class="badge bg-info">{{ $user->courses->count() }} courses</span>
                                                <div class="mt-1">
                                                    <button class="btn btn-sm btn-outline-info" 
                                                            onclick="showUserCoursesEnhanced({{ $user->id }}, '{{ $user->name }}', {{ $user->courses->load('sections')->toJson() }})">
                                                        <i class="ti ti-eye"></i> View Details
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-warning">No courses</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge {{ $user->is_blocked ? 'bg-danger' : 'bg-success' }}">
                                                {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $user->admin ? $user->admin->first_name . ' ' . $user->admin->last_name : 'No Admin' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3 text-center">{{ $user->updated_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex justify-content-center align-items-center gap-1">
                                                <a href="{{ route('admin.editUser', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <button wire:click.prevent="delete({{ $user->id }})" 
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                                <button wire:click="toggleBlockUser({{ $user->id }})" 
                                                        class="btn btn-sm {{ $user->is_blocked ? 'btn-outline-success' : 'btn-outline-warning' }}">
                                                    <i class="ti {{ $user->is_blocked ? 'ti-user-plus' : 'ti-user-minus' }}"></i>
                                                    {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-4">
                                            @if($search)
                                                No users found matching "{{ $search }}"
                                            @else
                                                No users found.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Controls -->
                <div class="py-4 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="me-2 text-sm font-medium text-mode">Per Page:</label>
                            <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div>{{ $users->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    @if($showImageModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Profile Picture</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeImageModal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ $modalImage }}" alt="{{ $modalTitle }}" class="img-fluid rounded shadow-lg" style="max-height: 70vh;">
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary" wire:click="closeImageModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bulk Course Assignment Modal -->
    @if($showBulkAssignModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">Assign Courses to {{ count($selectedUsers) }} Selected Users</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeBulkAssignModal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-mode mb-3">Select Courses:</h6>
                                <div class="course-selection" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($courses as $course)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" 
                                                   wire:model.live="selectedCourses" 
                                                   value="{{ $course->id }}" 
                                                   id="course{{ $course->id }}">
                                            <label class="form-check-label text-mode" for="course{{ $course->id }}">
                                                {{ $course->course_title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-mode mb-3">Select Sections for Each Course:</h6>
                                <div class="sections-selection" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($selectedCourses as $courseId)
                                        @if(isset($courseSections[$courseId]))
                                            <div class="card bg-secondary-dark mb-3">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h6 class="text-mode mb-0">{{ $courseSections[$courseId]['course']->course_title }}</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            wire:click="toggleAllSections({{ $courseId }})">
                                                        Select All
                                                    </button>
                                                </div>
                                                <div class="card-body">
                                                    @foreach($courseSections[$courseId]['sections'] as $section)
                                                        <div class="form-check mb-1">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   wire:model.live="courseSections.{{ $courseId }}.selected_sections" 
                                                                   value="{{ $section->id }}" 
                                                                   id="section{{ $section->id }}">
                                                            <label class="form-check-label text-mode" for="section{{ $section->id }}">
                                                                {{ $section->section_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    
                                    @if(empty($selectedCourses))
                                        <p class="text-warning">Please select courses first to see their sections.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary" wire:click="closeBulkAssignModal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="assignCoursesToUsers">
                            <i class="ti ti-check me-1"></i>Assign Courses
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
// Enhanced function to show user courses with unassign functionality
function showUserCoursesEnhanced(userId, userName, courses) {
    let coursesHtml = '';
    
    if (courses && courses.length > 0) {
        courses.forEach(course => {
            // Get user's sections for this course
            const userSections = course.sections || [];
            const totalSections = course.sections ? course.sections.length : 0;
            const assignedSections = userSections.length;
            
            coursesHtml += `
                <div class="card bg-secondary mb-3 border border-info">
                    <div class="card-header d-flex justify-content-between align-items-center bg-info text-white">
                        <div>
                            <h6 class="card-title mb-0 text-white">
                                <i class="ti ti-book me-2"></i>${course.course_title}
                            </h6>
                            <small class="text-white opacity-75">
                                ${assignedSections === totalSections ? 'Assigned to all sections' : `${assignedSections} of ${totalSections} sections assigned`}
                            </small>
                        </div>
                        <button class="btn btn-sm btn-outline-light" onclick="unassignCourse(${userId}, ${course.id})" title="Unassign entire course">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="sections-list">
                            <strong class="text-primary">
                                <i class="ti ti-list me-1"></i>Assigned Sections:
                            </strong>
                            <div class="mt-2">
            `;
            
            if (userSections.length > 0) {
                userSections.forEach(section => {
                    coursesHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                            <span class="text-dark">
                                <i class="ti ti-circle-dot me-1 text-success"></i>${section.section_name}
                            </span>
                            <button class="btn btn-sm btn-outline-danger" onclick="unassignSection(${userId}, ${course.id}, ${section.id})" title="Unassign this section">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                    `;
                });
            } else {
                coursesHtml += `<p class="text-warning">No sections assigned</p>`;
            }
            
            coursesHtml += `
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        coursesHtml = `
            <div class="text-center py-4">
                <i class="ti ti-school-off fs-1 text-warning mb-3"></i>
                <p class="text-warning mb-0">No courses assigned to this user.</p>
            </div>
        `;
    }

    Swal.fire({
        title: `<i class="ti ti-user me-2"></i>${userName}'s Courses`,
        html: coursesHtml,
        width: '800px',
        showConfirmButton: false,
        showCloseButton: true,
        customClass: {
            popup: 'bg-dark text-white',
            title: 'text-white',
            htmlContainer: 'text-start'
        },
        background: '#2c3e50'
    });
}

// Function to unassign entire course
function unassignCourse(userId, courseId) {
    Swal.fire({
        title: 'Unassign Course?',
        text: 'This will remove the entire course and all its sections from the user.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, unassign it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch('unassignCourse', [userId, courseId]);
        }
    });
}

// Function to unassign specific section
function unassignSection(userId, courseId, sectionId) {
    Swal.fire({
        title: 'Unassign Section?',
        text: 'This will remove only this section from the user.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, unassign it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch('unassignSection', [userId, courseId, sectionId]);
        }
    });
}
</script>

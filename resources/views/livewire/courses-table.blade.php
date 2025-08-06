<div>
    <section class="mt-10">
        <div class="mx-auto px-4 lg:px-12">
            <div class="relative sm:rounded-lg overflow-hidden bg-primary-dark">
                <!-- Search Section -->
                <div class="flex items-center justify-content-between p-4 ps-0">
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
                                placeholder="Search courses..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div wire:loading class="text-center py-2">
                    <span class="text-blue-500">Loading...</span>
                </div>

                <!-- Table Section -->
                <div class="row">
                    <div class="table-responsive" data-simplebar style="max-height: 1000px; overflow-y: auto;">
                        <table class="table table-borderless table-hover align-middle text-nowrap">
                            <thead class="text-xs text-mode uppercase bg-third-dark">
                                <tr class="fs-3 fw-bold text-center">
                                    <th scope="col" class="px-4 py-3">Image</th>
                                    <th scope="col" class="px-4 py-3">Name</th>
                                    <th scope="col" class="px-4 py-3">Description</th>
                                    <th scope="col" class="px-4 py-3">Price</th>
                                    <th scope="col" class="px-4 py-3">Instructor</th>
                                    <th scope="col" class="px-4 py-3">Admin</th>
                                    <th scope="col" class="px-4 py-3">Category</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3">Sections</th>
                                    <th scope="col" class="px-4 py-3">Creation Date</th>
                                    <th scope="col" class="px-4 py-3">Last Update</th>
                                    <th scope="col" class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                    <tr wire:key="course-{{ $course->id }}" class="border-b border-gray-800 text-mode fs-3 fw-bold text-center">
                                        <td class="px-4 py-3 text-center">
                                            <div class="img-view d-flex justify-content-center col overflow-hidden" style="border-radius: 9px !important;">
                                                <div class="click-img-view cursor-pointer hover:opacity-80 transition-opacity" style="width:100%">
                                                    <img loading="lazy"
                                                        wire:click="viewImage('{{ $course->cover_image }}', '{{ $course->course_title }}')"
                                                        src="/images/CoursesCoverImages/{{ $course->cover_image }}"
                                                        alt="{{ $course->course_title }}"
                                                        class="rounded hover:scale-105 transition-transform duration-200"
                                                        style="border-radius: 0px !important; cursor: pointer; width: 80px; height: 60px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </td>
                                        <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap">
                                            {{ $course->course_title }}
                                        </th>
                                        <td class="px-4 py-3 font-medium whitespace-nowrap relative">
                                            <div wire:click="viewDescription('{{ addslashes($course->course_description) }}', '{{ $course->course_title }}')"
                                                class="cursor-pointer hover:text-blue-500 hover:underline transition-colors duration-200 w-40 text-ellipsis overflow-hidden"
                                                title="Click to view full description">
                                                {{ Str::limit($course->course_description, 50) }}
                                                <i class="ti ti-eye ms-1"></i>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">${{ number_format($course->price, 2) }}</td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $course->instructor ? $course->instructor->first_name . ' ' . $course->instructor->last_name : 'No Instructor' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $course->admin ? $course->admin->first_name . ' ' . $course->admin->last_name : 'No Admin' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $course->category ? $course->category->category_name : 'No Category' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge 
                                                @if($course->status === 'active') bg-success
                                                @elseif($course->status === 'upcoming') bg-primary
                                                @elseif($course->status === 'deactivated') bg-danger
                                                @elseif($course->status === 'completed') bg-secondary
                                                @endif">
                                                {{ ucfirst($course->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-info">{{ $course->sections->count() }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $course->created_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3 text-center">{{ $course->updated_at->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('admin.editCourse', $course->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <button wire:click.prevent="delete({{ $course->id }})" 
                                                        wire:loading.attr="disabled"
                                                        class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-4">
                                            @if($search)
                                                No courses found matching "{{ $search }}"
                                            @else
                                                No courses found.
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
                        <div>{{ $courses->links() }}</div>
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
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Course Image</h5>
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

    <!-- Description Modal -->
    @if($showDescriptionModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Description</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeDescriptionModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-mode" style="line-height: 1.6; font-size: 16px;">
                            {!! nl2br(e($modalDescription)) !!}
                        </div>
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary" wire:click="closeDescriptionModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

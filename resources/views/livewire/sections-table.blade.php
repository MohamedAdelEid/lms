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
                                placeholder="Search sections..." autocomplete="off">
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
                            <thead class="text-xs uppercase text-mode bg-third-dark">
                                <tr>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Name</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Number Of Lectures
                                    </th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Course</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Admin</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Lectures Count</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Creation Date</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Updated Date</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sections as $section)
                                    <tr wire:key="section-{{ $section->id }}"
                                        class="border-b border-gray-800 text-mode">
                                        <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap text-center">
                                            {{ $section->section_name }}
                                        </th>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-info">{{ $section->number_of_lectures }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $section->course ? $section->course->course_title : 'No Course' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $section->admin ? $section->admin->first_name . ' ' . $section->admin->last_name : 'No Admin' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="badge bg-warning">{{ $section->lectures->count() }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $section->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $section->updated_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('admin.editSection', $section->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <button wire:click.prevent="delete({{ $section->id }})"
                                                    wire:loading.attr="disabled" class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            @if ($search)
                                                No sections found matching "{{ $search }}"
                                            @else
                                                No sections found.
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
                        <div>{{ $sections->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

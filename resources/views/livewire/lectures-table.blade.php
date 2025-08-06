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
                                placeholder="Search lectures..." autocomplete="off">
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
                                <tr class="text-center">
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Cover</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Name</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Description</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Section</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Admin</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Creation Date</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Last Update</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lectures as $lecture)
                                    <tr wire:key="lecture-{{ $lecture->id }}"
                                        class="border-b border-gray-800 text-mode">
                                        <td class="px-4 py-3 text-center">
                                            <div class="img-view d-flex justify-content-center col overflow-hidden"
                                                style="border-radius: 9px !important;">
                                                @if ($lecture->videos->isNotEmpty())
                                                    <div class="position-relative cursor-pointer hover:opacity-80 transition-opacity"
                                                        style="width:100%">
                                                        <img loading="lazy"
                                                            wire:click="viewImage('{{ $lecture->videos->first()->cover_image }}', '{{ $lecture->lecture_name }}')"
                                                            src="/images/VideoCoverImages/{{ $lecture->videos->first()->cover_image }}"
                                                            alt="{{ $lecture->lecture_name }}"
                                                            class="rounded hover:scale-105 transition-transform duration-200"
                                                            style="border-radius: 0px !important; cursor: pointer; width: 80px; height: 60px; object-fit: cover;">
                                                        <div class="position-absolute top-50 start-50 translate-middle">
                                                            <i
                                                                class="ti ti-eye text-white bg-dark bg-opacity-75 rounded-circle p-1"></i>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                                        style="width: 80px; height: 60px;">
                                                        <i class="ti ti-photo text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <th scope="row" class="px-4 py-3 text-center font-medium whitespace-nowrap">
                                            {{ $lecture->lecture_name }}
                                        </th>
                                        <td class="px-4 py-3 font-medium whitespace-nowrap relative">
                                            <div wire:click="viewDescription('{{ addslashes($lecture->lecture_description) }}', '{{ $lecture->lecture_name }}')"
                                                class="cursor-pointer hover:text-blue-500 hover:underline transition-colors duration-200 w-40 text-ellipsis overflow-hidden"
                                                title="Click to view full description">
                                                {{ Str::limit($lecture->lecture_description, 50) }}
                                                <i class="ti ti-eye ms-1"></i>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $lecture->section ? $lecture->section->section_name : 'No Section' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $lecture->admin ? $lecture->admin->first_name . ' ' . $lecture->admin->last_name : 'No Admin' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $lecture->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">{{ $lecture->updated_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div
                                                class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                                @if ($lecture->videos->isNotEmpty())
                                                    <button wire:click="viewVideo({{ $lecture->id }})"
                                                        class="btn btn-sm btn-outline-success mb-1">
                                                        <i class="ti ti-player-play"></i> Preview
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.editLecture', $lecture->id) }}"
                                                    class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="ti ti-edit"></i> Edit
                                                </a>
                                                <button wire:click.prevent="delete({{ $lecture->id }})"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-sm btn-outline-danger mb-1">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            @if ($search)
                                                No lectures found matching "{{ $search }}"
                                            @else
                                                No lectures found.
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
                        <div>{{ $lectures->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    @if ($showImageModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Lecture Cover</h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeImageModal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <img src="{{ $modalImage }}" alt="{{ $modalTitle }}"
                            class="img-fluid rounded shadow-lg" style="max-height: 70vh;">
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary" wire:click="closeImageModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Description Modal -->
    @if ($showDescriptionModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Description</h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeDescriptionModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-mode" style="line-height: 1.6; font-size: 16px;">
                            {!! nl2br(e($modalDescription)) !!}
                        </div>
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary"
                            wire:click="closeDescriptionModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Video Preview Modal -->
    @if ($showVideoModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.8);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content bg-primary-dark">
                    <div class="modal-header border-bottom border-gray-600">
                        <h5 class="modal-title text-mode">{{ $modalTitle }} - Video Preview</h5>
                        <button type="button" class="btn-close btn-close-white"
                            wire:click="closeVideoModal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            For performance reasons, videos are not loaded directly in this modal.
                        </div>
                        @if (!empty($modalVideoData['videos']))
                            <div class="row">
                                @foreach ($modalVideoData['videos'] as $video)
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-secondary">
                                            <img src="/images/VideoCoverImages/{{ $video['cover_image'] }}"
                                                class="card-img-top" alt="Video Cover"
                                                style="height: 150px; object-fit: cover;">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">{{ $video['name'] }}</h6>
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('admin.viewLectureVideo', ['id' => $modalVideoData['lecture_id'], 'video' => $video['id']]) }}"
                                                        target="_blank" class="btn btn-primary btn-sm">
                                                        <i class="ti ti-external-link me-1"></i>Open in New Tab
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-top border-gray-600">
                        <button type="button" class="btn btn-secondary" wire:click="closeVideoModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div>
    <section class="mt-10">
        <div class="mx-auto px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="relative sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4 ps-0">
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
                            <input wire:model.live.debounce.300ms = 'search' type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-5 p-2 "
                                placeholder="Search" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive" data-simplebar style="max-height: 1000px; overflow-y: auto;">
                        <table class="table table-borderless table-hover table-hover align-middle text-nowrap">
                            <thead class="text-xs uppercase text-mode bg-third-dark">
                                <tr>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center"></th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Name</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">E-mail</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Phone</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Qualification</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Admin</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Creation Date</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Last update</th>
                                    <th scope="col" class="fs-3 fw-bold px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($instructors->isEmpty())
                                    <tr>
                                        <td colspan="10" class="text-center py-4">No Instructors Found.</td>
                                    </tr>
                                @else
                                    @foreach ($instructors as $instructor)
                                        <tr wire:key="{{ $instructor->id }}" class="border-b border-gray-800 text-mode">
                                            <td class="px-4 py-3 text-center">
                                                <div class="img-view d-flex justify-content-center col">
                                                    <div wire:click="viewImg('{{ $instructor->profile_picture }}')"
                                                        style="width:100%">
                                                        <img loading="lazy"
                                                            src="/images/instructors/{{ $instructor->profile_picture }}"
                                                            id="profilePicContainer">
                                                    </div>
                                                </div>
                                            </td>
                                            <th scope="row"class="px-4 py-3 font-medium whitespace-nowrap">
                                                {{ $instructor->first_name . ' ' . $instructor->last_name }}</th>
                                            <td class="px-4 py-3 text-center">{{ $instructor->email }}</td>
                                            <td class="px-4 py-3 text-center">{{ $instructor->phone_number }}</td>
                                            <td class="px-4 py-3 text-center">{{ $instructor->qualifications }}</td>
                                            <td class="px-4 py-3 text-center">
                                                {{ $instructor->admin ? $instructor->admin->first_name . ' ' . $instructor->admin->last_name : 'No Admin' }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                {{ $instructor->created_at->format('Y-m-d') }}</td>
                                            <td class="px-4 py-3 text-center">
                                                {{ $instructor->updated_at->format('Y-m-d') }}</td>
                                            <td class=" py-3">
                                                <div class="flex items-center justify-center">
                                                    <a
                                                        href="{{ route('admin.editInstructor', $instructor->id) }}"class="me-1 py-1">
                                                        <p class="edit"><i class="ti ti-edit"></i> Edit</p>
                                                    </a>
                                                    <button wire:click.prevent="delete({{ $instructor->id }})"
                                                        class="ms-1 py-1">
                                                        <p class="delete"><i class="ti ti-trash me-1">
                                                            </i>Delete</p>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-mode">Per Page</label>
                            <select wire:model.live ="perPage"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    {{ $instructors->links() }}
                </div>
            </div>
        </div>
        <div id="modal-view" class="modal">
            <div class="row">
                <div class="content-modal col-9 col-sm-6 col-md-5 col-lg-4 col-xl-3" id="content-modal">
                    <span class="close" onclick="closeViewImg()">&times;</span>
                    <div class="modal-body mt-3">
                        <div class="profile-pic-container">
                            <img src="" id="modalImage" class="rounded-3" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('partials.admin.header',['title'=>'Add User'])
@include('partials.admin.aside')
@include('partials.admin.nav')

<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold text-mode mb-0">Add User</h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#importUsersModal">
                            <i class="ti ti-file-import me-1"></i>Import Users
                        </button>
                    </div>
                </div>
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
                @if (session('import_errors'))
                    <div class="alert alert-danger" id="import_errors">
                        <h6>Import Errors:</h6>
                        <ul class="mb-0">
                            @foreach (session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $('#import_errors').fadeOut();
                            }, 10000);
                        });
                    </script>
                @endif

                <form method="POST" action="{{ route('admin.storeUser') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row justify-content-between bg-primary-dark">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="firstName" class="form-label text-mode">Name</label>
                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" id="firstName">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-mode">E-mail</label>
                                <input type="email" placeholder="E-mail" value="{{ old('email') }}" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="numberOfLecture" class="form-label text-mode">Phone Number</label>
                                <input type="text" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="numberOfLecture">
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label text-mode">Password</label>
                                <div class="position-relative">
                                    <input type="password" placeholder="Password" name="password"
                                        class="form-control auth__password @error('password') is-invalid @enderror" id="password">
                                    <span class="password__icon cursor-pointer input-group-text icon-edit">
                                        <i class="password__icon text-primary fs-6 fw-bold ti ti-eye-off text-mode"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label text-mode">Photo</label>
                                <input type="file" placeholder="Photo" name="profile_picture"
                                    class="form-control @error('profile_picture') is-invalid @enderror" id="photo"
                                    accept="image/*">
                                @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xl-3">
                            <button type="submit" class="btn btn-primary text-mode">
                                <i class="ti ti-user-plus me-1"></i>Add User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Import Users Modal -->
<div class="modal fade" id="importUsersModal" tabindex="-1" aria-labelledby="importUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-primary-dark" style="">
            <div class="modal-header border-bottom border-gray-600">
                <h5 class="modal-title text-mode" id="importUsersModalLabel">
                    <i class="ti ti-file-import me-2"></i>Import Users
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="ti ti-info-circle me-1"></i>Instructions
                    </h6>
                    <p class="mb-2">You can import multiple users at once using our Excel template. Please download the structure first to avoid format issues.</p>
                    <ul class="mb-0">
                        <li>Download the Excel template below</li>
                        <li>Fill in the user data (name, email, phone_number, password)</li>
                        <li>Upload the completed file</li>
                        <li>All rows must be valid for the import to proceed</li>
                    </ul>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-secondary-dark">
                            <div class="card-body text-center">
                                <i class="ti ti-download fs-1 text-success mb-2"></i>
                                <h6 class="text-mode">Step 1: Download Template</h6>
                                <p class="text-muted small">Get the Excel template with the correct structure</p>
                                <a href="{{ route('admin.downloadUserTemplate') }}" class="btn btn-success btn-sm">
                                    <i class="ti ti-file-spreadsheet me-1"></i>Download Template
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-secondary-dark">
                            <div class="card-body">
                                <i class="ti ti-upload fs-1 text-primary mb-2 d-block text-center"></i>
                                <h6 class="text-mode text-center">Step 2: Upload Filled File</h6>
                                <form method="POST" action="{{ route('admin.importUsers') }}" enctype="multipart/form-data" id="importForm">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="import_file" class="form-control" accept=".xlsx,.xls,.csv" required>
                                        <small class="form-text text-muted">Accepted: Excel (.xlsx, .xls) or CSV files</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-upload me-1"></i>Import Users
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h6 class="text-mode">Template Structure:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-secondary">
                                <tr>
                                    <th class="text-mode">name</th>
                                    <th class="text-mode">email</th>
                                    <th class="text-mode">phone_number</th>
                                    <th class="text-mode">password</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">John Doe</td>
                                    <td class="text-muted">john@example.com</td>
                                    <td class="text-muted">1234567890</td>
                                    <td class="text-muted">password123</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jane Smith</td>
                                    <td class="text-muted">jane@example.com</td>
                                    <td class="text-muted">0987654321</td>
                                    <td class="text-muted">securepass</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-gray-600">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

<script>
// Form submission with loading state
document.getElementById('importForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="ti ti-loader-2 me-1 spin"></i>Importing...';
    submitBtn.disabled = true;
    
    // Re-enable after 30 seconds as fallback
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 30000);
});
</script>

<style>
.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

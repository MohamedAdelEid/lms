@include('partials.admin.header', ['title' => 'Add Category'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title', 'add Category')
<div class="content-add container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3 text-mode">Add Category</h5>
                <hr>
                <div class="card-body">
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
                    <form method="POST" action="{{ route('admin.storeCategory') }}" id="categoryForm">
                        @csrf
                        <div class="mb-3">
                            <label for="category-name" class="form-label text-mode">Category Name</label>
                            <input type="text" value="{{ old('category_name') }}" placeholder="Category Name"
                                class="form-control category-name @error('category_name') is-invalid @enderror"
                                id="category-name" name="category_name">
                            @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="category-error">{{ $message }} </strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary text-mode">Submit</button>
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

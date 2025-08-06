@include('partials.admin.header',['title'=>'Edit User'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','add Category')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">Edit Categories </h5>
                <hr>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" id="success">
                            {{ session('success') }}
                        </div>
                        <script>
                            $(document).ready(function(){
                                setTimeout(function(){
                                    $('#success').fadeOut();
                                }, 3000);
                            });
                        </script>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" id="error">
                            {{ session('error') }}
                        </div>
                        <script>
                            $(document).ready(function(){
                                setTimeout(function(){
                                    $('#error').fadeOut();
                                }, 3000);
                            });
                        </script>
                    @endif
                        <form method="post" action="{{ route('edit.editCategory', ['id' => $currentCategoryData->id]) }}">
                            @csrf
                            @method('PUT')
                    <div class="mb-3">
                                <label for="category-name" class="form-label text-mode">Category Name</label>
                                <input type="text" value="{{$currentCategoryData->category_name}}"  class="form-control category-name @error('category_name') is-invalid @enderror"
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

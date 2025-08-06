@include('partials.admin.header',['title'=>'View Courses'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','View Courses')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">View Courses</h5>
                <hr>
                    <livewire:courses-table />
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

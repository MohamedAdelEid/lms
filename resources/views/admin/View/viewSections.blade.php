@include('partials.admin.header',['title'=>'View Sections'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','View Sections')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">View Sections</h5>
                <hr>
                <livewire:sections-table />
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

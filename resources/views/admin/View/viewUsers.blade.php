@include('partials.admin.header',['title'=>'View Users'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','View Users')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">View Users</h5>
                <hr>
                <livewire:users-table />
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

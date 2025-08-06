@include('partials.admin.header',['title'=>'View Lectures'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','View Lectures')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">View Lectures</h5>
                <hr>
                <livewire:lectures-table />
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

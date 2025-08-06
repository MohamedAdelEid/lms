@include('partials.admin.header',['title'=>'View Instructors'])
@include('partials.admin.aside')
@include('partials.admin.nav')
@section('title','View Instructors')
<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-mode mb-3">View Instructors</h5>
                <hr>
                    <livewire:instructors-table />
            </div>
        </div>
    </div>
</div>
@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

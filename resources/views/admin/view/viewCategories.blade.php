@include('partials.admin.header', ['title' => 'View Categories'])
@include('partials.admin.aside')
@include('partials.admin.nav')

@section('title', 'View Category')

<div class="container-fluid bg-secondary-dark pb-7">
    <div class="container-fluid">
        <div class="card bg-primary-dark">
            <div class="card-body pb-5 pt-3">
                <h5 class="card-title fw-semibold text-mode mb-3">View Categories</h5>
                <hr>
                @livewire('categories-table')
            </div>
        </div>
    </div>
</div>

@include('partials.admin.footer')
</div>
</div>
@include('partials.admin.footerScript')

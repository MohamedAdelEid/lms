<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login|User</title>
    <link rel="shortcut icon" type="image/png" href="/assets/images/logo/Treasure Academy logo dark-mode.png"
        sizes="32x32" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <link rel="stylesheet" href="/assets/css/admin.css" />
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="main-login position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-sm-7 col-md-6 col-lg-4 col-xxl-3">
                        <div class="card position-relative mb-0">
                            <div class="card-body">

                                <a href="{{ route('login') }}"
                                    class="text-nowrap logo-img text-center d-block py-3 w-100 pt-0">
                                    <img src="/assets/images/logo/Treasure Academy logo dark-mode.png" width="70px"
                                        alt="">
                                </a>
                                <p class="title text-center">welcome</p>
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">E-mail</label>
                                        <input id="exampleInputEmail1" type="text" placeholder="E-mail"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input type="password" id="exampleInputPassword1"
                                                class="form-control auth__password @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password" required
                                                autocomplete="current-password">
                                            <span class="password__icon input-group-text icon-edit">
                                                <i
                                                    class="text-primary fs-6 fw-bold ti ti-eye-off text-mode cursor-pointer"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value=""
                                                id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remember me
                                            </label>
                                        </div>
                                        <a class="forgot-pass text-primary text-decoration-none" href="">Forgot
                                            Password
                                            ?</a>
                                    </div>
                                    <div class="row justify-content-center">
                                        <input type="submit" class="btn btn-primary w-50 fs-4 mb-4 rounded-2"></input>
                                    </div>
                                </form>
                            </div>
                            <figure class="shap-1 position-absolute top-0 end-0 zi-n1 d-none d-sm-block">
                                <img class="img-fluid" src="/assets/images/login/pointer-up.svg"
                                    alt="Image Description">
                            </figure>
                            <figure class="shap-2 position-absolute bottom-0 start-0 d-none d-sm-block">
                                <img class="img-fluid" src="/assets/images/login/curved-shape.svg"
                                    alt="Image Description">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

@include('partials.admin.footerScript')

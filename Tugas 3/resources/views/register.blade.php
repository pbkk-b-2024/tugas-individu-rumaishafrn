<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('home') }}" class="btn btn-primary mt-3 rounded-circle"><i class="fas fa-arrow-left fs-2"></i></a>
            </div>
        </div>
        <div class="row justify-content-center mt-5 pt-lg-5">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-lg-5 p-0">
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="text-muted">Register</span>
                                    </div>
                                    <form action="" method="post" class="user text-center">
                                        @csrf
                                        <div class="form-group mb-4">
                                            <input autofocus="autofocus" autocomplete="off" value="{{ old('name') }}" type="text" name="name" class="form-control form-control-user" placeholder="Nama Lengkap">
                                            @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <input autofocus="autofocus" autocomplete="off" value="{{ old('email') }}" type="email" name="email" class="form-control form-control-user" placeholder="Email">
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Konfirmasi Password">
                                            @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>
                                        <a href="{{ route('login') }}" class="btn btn-secondary btn-block">Login</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: `{{ session('success') }}`,
            showConfirmButton: true,
            timer: 3000
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `{{ session('error') }}`,
            showConfirmButton: true,
            timer: 3000
        });
    </script>
    @endif
</body>

</html>

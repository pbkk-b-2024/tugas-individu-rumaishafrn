@extends('layout')

@section('error')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper p-0">
        <div class="content-wrapper d-flex align-items-center text-center error-page bg-secondary">
            <div class="row flex-grow">
                <div class="col-lg-7 mx-auto text-white">
                    <div class="row align-items-center d-flex flex-row">
                        <div class="col-lg-6 text-lg-right pr-lg-4">
                            <h1 class="display-1 mb-0">403</h1>
                        </div>
                        <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                            <h2>FORBIDDEN</h2>
                            <h3 class="font-weight-light">
                                @if ($exception)
                                {{ $exception->getMessage() }}
                                @else
                                Kamu tidak memiliki akses untuk halaman ini.
                                @enderror
                            </h3>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

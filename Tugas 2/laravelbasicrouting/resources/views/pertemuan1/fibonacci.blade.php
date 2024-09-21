@extends('app.layout')

@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Fibonacci</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Pertemuan 1</li>
                <li class="breadcrumb-item active">Fibonacci</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="fw-bold">Kalkulasi Fibonacci</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-stretch">
                        <div class="col-4">
                            <form action="{{ route('pertemuan1.fibonacci.cari') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="bilangan" class="mb-3">Masukkan Jumlah Untuk Fibonacci</label>
                                    <input type="number" name="bilangan" id="bilangan" class="form-control" value="{{ @$bilangan }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Cari</button>
                            </form>
                        </div>
                        @if ($bilangan)
                        <div class="col">
                            <div class="alert alert-info h-100">
                                <h5>Hasil</h5>
                                <b>{{ $hasil }}</b>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
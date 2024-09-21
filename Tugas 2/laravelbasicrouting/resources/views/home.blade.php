@extends('app.layout')

@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Text goes here</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <!-- Basic Route -->
                            <a href="{{ route('routing.basic') }}" class="btn btn-primary btn-block">Text goes here</a>
                        </div>
                        <div class="col">
                            <!-- Route Parameters -->
                            <a href="{{ route('routing.parameter', 1) }}" class="btn btn-secondary btn-block">Text goes here</a>
                        </div>
                        <div class="col">
                            <!-- Named Routes -->
                            <a href="{{ route('routing.named') }}" class="btn btn-success btn-block">Text goes here</a>
                        </div>
                        <div class="col">
                            <!-- Route Prefix -->
                            <a href="{{ route('routing.prefix') }}" class="btn btn-warning btn-block">Text goes here</a>
                        </div>
                        <div class="col">
                            <!-- Fallback Routes -->
                            <a href="{{ url('/ini/adalah/route/yang/bermasalah') }}" class="btn btn-danger btn-block">Text goes here</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="fw-bold">Pertemuan 2</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <form action="{{ route('pertemuan1.ganjilgenap.cari') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="bilangan" class="mb-3">Text goes here</label>
                                                    <input type="number" name="bilangan" id="bilangan" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Text goes here</button>
                                            </form>
                                        </div>
                                        <div class="col-4">
                                            <form action="{{ route('pertemuan1.fibonacci.cari') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="bilangan" class="mb-3">Text goes here</label>
                                                    <input type="number" name="bilangan" id="bilangan" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Text goes here</button>
                                            </form>
                                        </div>
                                        <div class="col-4">
                                            <form action="{{ route('pertemuan1.prima.cari') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="bilangan" class="mb-3">Text goes here</label>
                                                    <input type="number" name="bilangan" id="bilangan" class="form-control" value="{{ @$bilangan }}" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Text goes here</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
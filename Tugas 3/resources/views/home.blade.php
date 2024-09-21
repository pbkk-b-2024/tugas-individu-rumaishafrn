@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Home</h6>
        </div>
        <div class="card-body">
            <div class="row align-items-stretch">
                @can('manage-obat')
                <div class="col-3 d-flex align-items-stretch">
                    <div class="card bg-primary text-white shadow w-100">
                        <div class="card-body row align-items-center">
                            <div class="col-8">
                                <h2>Data Kategori Obat</h2>
                            </div>
                            <div class="col-4 text-center">
                                <i class="fa fa-list fa-3x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('kategori.index') }}" class="text-white">Lihat Data Kategori Obat <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="col-3 d-flex align-items-stretch">
                    <div class="card bg-secondary text-white shadow w-100">
                        <div class="card-body row align-items-center">
                            <div class="col-8">
                                <h2>Data Obat</h2>
                            </div>
                            <div class="col-4 text-center">
                                <i class="fa fa-medkit fa-3x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('obat.index') }}" class="text-white">Lihat Data Obat <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                @can('manage-stok')
                <div class="col-3 d-flex align-items-stretch">
                    <div class="card bg-success text-white shadow w-100">
                        <div class="card-body row align-items-center">
                            <div class="col-8">
                                <h2>Data Stok Obat</h2>
                            </div>
                            <div class="col-4 text-center">
                                <i class="fa fa-cubes fa-3x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('stok.index') }}" class="text-white">Lihat Data Stok Obat <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                @endcan
                @can('manage-transaksi')
                <div class="col-3 d-flex align-items-stretch">
                    <div class="card bg-danger text-white shadow w-100">
                        <div class="card-body row align-items-center">
                            <div class="col-8">
                                <h2>Data Transaksi</h2>
                            </div>
                            <div class="col-4 text-center">
                                <i class="fa fa-shopping-cart fa-3x" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('transaksi.index') }}" class="text-white">Lihat Data Transaksi <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
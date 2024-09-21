@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Laporan Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Jumlah Penjualan</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($data as $x) { ?>
                            <tr class="text-center">
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $x->tanggal }}</td>
                                <td>{{ $x->obat->nama_obat }}</td>
                                <td>{{ $x->jumlah_penjualan }}</td>
                                <td>Rp. {{ number_format($x->total_harga_penjualan, 0, ',', '.') }}</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
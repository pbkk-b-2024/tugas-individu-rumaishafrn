@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Laporan Stok Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Perubahan Stok</th>
                            <th>Total Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($data as $x) { ?>
                            <tr class="text-center">
                                <td>{{ $nomor++ }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($x->created_at)) }}</td>
                                <td>{{ $x->stokObat->obat->nama_obat }}</td>
                                <td>
                                    @if ($x->stokObat->jumlah_stok >= 0)
                                    <span class="badge badge-success">+{{ $x->stokObat->jumlah_stok }}</span>
                                    @else
                                    <span class="badge badge-danger">{{ $x->stokObat->jumlah_stok }}</span>
                                    @endif
                                </td>
                                <td><b>{{ $x->total_stok }}</b></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
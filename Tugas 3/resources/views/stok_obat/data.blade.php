@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Data Stok Obat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Gambar</th>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                            <th style="width: 50px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($data as $x) { ?>
                            <tr class="text-center">
                                <td>{{ $nomor++ }}</td>
                                <td><img src="{{ Storage::url($x->gambar) }}" class="rounded" style="width: 200px; height:200px"></td>
                                <td>{{ $x->nama_obat }}</td>
                                <td><b>{{ $x->stok }}</b></td>
                                <td align="center">
                                    <a href="{{ route('stok.edit', $x->id) }}" class="btn btn-primary py-1"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

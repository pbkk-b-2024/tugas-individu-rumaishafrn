@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Data Obat</h6>
            @can('manage-obat')
            <a href="{{ route('obat.create') }}" class="btn btn-primary"><i class="fa fa-plus fs-5" aria-hidden="true"></i></a>
            @endcan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Gambar</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Tersedia</th>
                            @can('manage-obat')
                            <th style="width: 50px;">Aksi</th>
                            @endcan
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
                                <td>{{ $x->kategori->nama_kategori }}</td>
                                <td>{{ $x->deskripsi }}</td>
                                <td>Rp. {{ number_format($x->harga, 0, ',', '.') }}</td>
                                <td>{{ $x->stok }}</td>
                                @can('manage-obat')
                                <td align="center">
                                    <a href="{{ route('obat.edit', $x->id) }}" class="btn btn-primary py-1"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('obat.destroy', $x->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger py-1" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Data Kategori Obat</h6>
            <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="fa fa-plus fs-5" aria-hidden="true"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width: 50px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($data as $x) { ?>
                            <tr class="text-center">
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $x->nama_kategori }}</td>
                                <td align="center">
                                    <a href="{{ route('kategori.edit', $x->id) }}" class="btn btn-primary py-1"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('kategori.destroy', $x->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger py-1" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
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
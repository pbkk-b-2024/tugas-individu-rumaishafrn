@extends('layout')

@section('content')

<body class="bg-gradient-success">
    <div class="mbr-slider slide carousel" data-keyboard="false" data-ride="carousel" data-interval="2000" data-pause="true">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card o-hidden border-0 shadow-lg my-5 ">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="p-5">
                                        <!-- Page Heading -->
                                        <div class="card">
                                            <div class="card-header">
                                                Tambah Obat
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <table class="table">
                                                                <tr>
                                                                    <td>Nama Obat</td>
                                                                    <td><input type="text" name="nama_obat" class="form-control" required></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Kategori</td>
                                                                    <td>
                                                                        <select name="kategori_id" class="form-control">
                                                                            <option value="">Pilih Kategori</option>
                                                                            @foreach ($kategori as $x)
                                                                            <option value="{{ $x->id }}">{{ $x->nama_kategori }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Deskripsi</td>
                                                                    <td><textarea name="deskripsi" class="form-control" required></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Harga</td>
                                                                    <td><input type="number" name="harga" class="form-control" required></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gambar</td>
                                                                    <td><input type="file" name="gambar" class="form-control" required accept="image/*"></td>
                                                                </tr>
                                                            </table>
                                                            <div class="text-center mt-5">
                                                                <button class="btn btn-success">Tambahkan</button>
                                                            </div>
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
        </div>
    </div>
</body>
@endsection

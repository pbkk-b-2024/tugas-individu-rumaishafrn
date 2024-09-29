@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Data Obat</h6>
            @can('manage-obat')
            <button class="btn btn-primary" onclick="addData()"><i class="fa fa-plus fs-5" aria-hidden="true"></i></button>
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
                            <th>Stok</th>
                            @can('manage-obat')
                            <th style="width: 50px;">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td colspan="8">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@can('manage-obat')
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/obat') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/obat') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <table class="table">
                        <input type="hidden" name="id">
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
                            <td><input type="file" name="gambar" class="form-control" accept="image/*"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endpush

@push('scripts')
<script>
    function getData() {
        const dt = $('#dataTable tbody');
        $.ajax({
            url: "{{ url('api/obat') }}",
            type: "GET",
            dataType: "json",
            success: function(x) {
                dt.html('');
                const data = x.data;
                data.forEach((item, index) => {
                    var htmls = `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                <td><img src="${item.gambar}" class="rounded" style="width: 200px; height:200px"></td>
                                <td>${item.nama_obat}</td>
                                <td>${item.kategori.nama_kategori}</td>
                                <td>${item.deskripsi}</td>
                                <td>Rp. ${convertToRupiah(item.harga)}</td>
                                <td>${item.stok}</td>`;
                    `@can('manage-obat')`
                    htmls += `
                                <td align="center">
                                    <button class="btn btn-primary py-1" onclick="editData(${item.id})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger py-1" onclick="deleteData(${item.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>`;
                    `@endcan`
                    htmls += `
                            </tr>
                        `;
                    dt.append(htmls);
                });
                $('#dataTable').DataTable();
            }
        });
    }

    getData();

    `@can('manage-obat')`

    function addData() {
        $('#addModal').find('input').val('');
        $('#addModal').find('textarea').val('');
        $('#addModal').find('select').val('');
        $('#addModal').modal('show');
    }

    function storeData() {
        const data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('nama_obat', $('#addModal').find('input[name="nama_obat"]').val());
        data.append('kategori_id', $('#addModal').find('select[name="kategori_id"]').val());
        data.append('deskripsi', $('#addModal').find('textarea[name="deskripsi"]').val());
        data.append('harga', $('#addModal').find('input[name="harga"]').val());
        data.append('gambar', $('#addModal').find('input[name="gambar"]')[0].files[0]);

        $.ajax({
            url: "{{ url('api/obat') }}",
            type: "POST",
            headers: {
                Authorization: `Bearer {{ session('api_token') }}`
            },
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(x) {
                $('#addModal').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil ditambahkan.',
                    'success'
                );
                getData();
            },
            error: function(x) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: x.responseJSON.message
                });
            }
        });
    };

    $('#addModal form').on('submit', function(e) {
        e.preventDefault();
        storeData();
    });

    function editData(id) {
        $('#editModal').find('input').val('');
        $('#editModal').find('textarea').val('');
        $('#editModal').find('select').val('');
        $.ajax({
            url: "{{ url('api/obat') }}/" + id,
            type: "GET",
            headers: {
                Authorization: `Bearer {{ session('api_token') }}`
            },
            dataType: "json",
            success: function(x) {
                const data = x.data;
                $('#editModal').find('input[name="id"]').val(data.id);
                $('#editModal').find('input[name="nama_obat"]').val(data.nama_obat);
                $('#editModal').find('select[name="kategori_id"]').val(data.kategori_id);
                $('#editModal').find('textarea[name="deskripsi"]').val(data.deskripsi);
                $('#editModal').find('input[name="harga"]').val(data.harga);
                $('#editModal').modal('show');
            }
        });
    }

    function updateData() {
        const id = $('#editModal').find('input[name="id"]').val();
        let data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('nama_obat', $('#editModal').find('input[name="nama_obat"]').val());
        data.append('kategori_id', $('#editModal').find('select[name="kategori_id"]').val());
        data.append('deskripsi', $('#editModal').find('textarea[name="deskripsi"]').val());
        data.append('harga', $('#editModal').find('input[name="harga"]').val());
        if ($('#editModal').find('input[name="gambar"]')[0].files[0] != undefined) {
            data.append('gambar', $('#editModal').find('input[name="gambar"]')[0].files[0] ?? '');
        }

        $.ajax({
            url: "{{ url('api/obat') }}/" + id + "?_method=PATCH",
            type: "POST",
            headers: {
                Authorization: `Bearer {{ session('api_token') }}`
            },
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(x) {
                $('#editModal').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil diubah.',
                    'success'
                );
                getData();
            },
            error: function(x) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: x.responseJSON.message
                });
            }
        });
    };

    $('#editModal form').on('submit', function(e) {
        e.preventDefault();
        updateData();
    });

    function deleteData(id) {
        Swal.fire({
            title: 'Yakin Hapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('api/obat') }}/" + id,
                    type: "DELETE",
                    headers: {
                        Authorization: `Bearer {{ session('api_token') }}`
                    },
                    dataType: "json",
                    success: function(x) {
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
                        getData();
                    }
                });
            }
        });
    }
    `@endcan`
</script>
@endpush
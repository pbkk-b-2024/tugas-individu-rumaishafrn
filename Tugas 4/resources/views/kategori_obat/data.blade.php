@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Data Kategori Obat</h6>
            <button class="btn btn-primary" onclick="addData()"><i class="fa fa-plus fs-5" aria-hidden="true"></i></button>
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
                        <tr class="text-center">
                            <td colspan="3">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('modals')
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Kategori Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/kategori') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Nama Kategori</td>
                            <td><input type="text" name="nama_kategori" class="form-control" required></td>
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
                <h5 class="modal-title" id="editModalLabel">Edit Kategori Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/kategori') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <table class="table">
                        <input type="hidden" name="id">
                        <tr>
                            <td>Nama Kategori</td>
                            <td><input type="text" name="nama_kategori" class="form-control" required></td>
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
@endpush

@push('scripts')
<script>
    const api_url = "{{ url('api/kategori') }}";

    function getData() {
        const dt = $('#dataTable tbody');
        $.ajax({
            url: api_url,
            type: "GET",
            headers: {
                Authorization: `Bearer {{ session('api_token') }}`
            },
            dataType: "json",
            success: function(x) {
                dt.html('');
                const data = x.data;
                data.forEach((item, index) => {
                    var htmls = `
                            <tr class="text-center">
                                <td>${index + 1}</td>
                                <td>${item.nama_kategori}</td>`;
                    htmls += `
                                <td align="center">
                                    <button class="btn btn-primary py-1" onclick="editData(${item.id})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    <button class="btn btn-danger py-1" onclick="deleteData(${item.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>`;
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

    function addData() {
        $('#addModal').find('input').val('');
        $('#addModal').find('textarea').val('');
        $('#addModal').find('select').val('');
        $('#addModal').modal('show');
    }

    function storeData() {
        const data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('nama_kategori', $('#addModal').find('input[name="nama_kategori"]').val());

        $.ajax({
            url: api_url,
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
            url: api_url + "/" + id,
            type: "GET",
            headers: {
                Authorization: `Bearer {{ session('api_token') }}`
            },
            dataType: "json",
            success: function(x) {
                const data = x.data;
                $('#editModal').find('input[name="id"]').val(data.id);
                $('#editModal').find('input[name="nama_kategori"]').val(data.nama_kategori);
                $('#editModal').modal('show');
            }
        });
    }

    function updateData() {
        const id = $('#editModal').find('input[name="id"]').val();
        let data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('nama_kategori', $('#editModal').find('input[name="nama_kategori"]').val());

        $.ajax({
            url: api_url + "/" + id + "?_method=PATCH",
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
                    url: api_url + "/" + id,
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
</script>
@endpush
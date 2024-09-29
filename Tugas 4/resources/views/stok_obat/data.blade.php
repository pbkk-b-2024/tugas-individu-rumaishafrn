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


@push('modals')
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Tambah Stok Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/stok') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <table class="table">
                        <input type="hidden" name="id">
                        <tr>
                            <td>Nama Obat</td>
                            <td><input type="text" name="nama_obat" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <td>Stok Sekarang</td>
                            <td><input type="number" name="stok" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <td>Jumlah Tambah</td>
                            <td><input type="number" name="jumlah_stok" class="form-control" required id="jumlah" min="1" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><input type="number" name="total" class="form-control" readonly id="total"></td>
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
@endpush

@push('scripts')
<script>
    const api_url = "{{ url('api/stok') }}";

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
                                <td><img src="${item.gambar}" class="rounded" style="width: 200px; height:200px"></td>
                                <td>${item.nama_obat}</td>
                                <td>${item.stok}</td>`;
                    htmls += `
                                <td align="center">
                                    <button class="btn btn-primary py-1" onclick="editData(${item.id})"><i class="fa fa-plus" aria-hidden="true"></i></button>
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
                console.log(data);
                $('#editModal').find('input[name="id"]').val(data.id);
                $('#editModal').find('input[name="nama_obat"]').val(data.nama_obat);
                $('#editModal').find('input[name="stok"]').val(data.stok);
                $('#editModal').find('input[name="jumlah_stok"]').on('input', function() {
                    const jumlah = $(this).val();
                    const total = parseInt(data.stok) + parseInt(jumlah);
                    $('#editModal').find('input[name="total"]').val(total);
                });
                $('#editModal').find('input[name="total"]').val(data.stok);
                $('#editModal').modal('show');
            }
        });
    }

    function updateData() {
        const id = $('#editModal').find('input[name="id"]').val();
        let data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('jumlah_stok', $('#editModal').find('input[name="jumlah_stok"]').val());

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
                    'Stok berhasil ditambahkan.',
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
</script>
@endpush
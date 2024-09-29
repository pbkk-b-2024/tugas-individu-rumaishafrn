@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold ">Transaksi</h6>
            <button class="btn btn-primary" onclick="addData()"><i class="fa fa-plus
                    fs-5" aria-hidden="true"></i></button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 50px;">No</th>
                            @can('confirm-transaksi')
                            <th>Nama Pelanggan</th>
                            @endcan
                            <th>Gambar</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th style="width: 50px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td colspan="7">Loading...</td>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/transaksi') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table">
                        @can('confirm-transaksi')
                        <tr>
                            <td>Pilih Pembeli</td>
                            <td>
                                <select name="user_id" class="form-control">
                                    <option value="">Pilih Pembeli</option>
                                    @foreach ($user as $x)
                                    <option value="{{ $x->id }}">{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endcan
                        <tr>
                            <td>Pilih Obat</td>
                            <td>
                                <select name="obat_id" class="form-control">
                                    <option value="">Pilih obat yang tersedia</option>
                                    @foreach ($obat as $x)
                                    <option value="{{ $x->id }}" data-harga="{{ $x->harga }}">{{ $x->nama_obat }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td><input type="number" name="jumlah" class="form-control" value="1" required></td>
                        </tr>
                        <tr>
                            <td>Total Harga</td>
                            <td><input type="number" class="form-control" readonly value="0" id="total"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('api/transaksi') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <table class="table">
                        <input type="hidden" name="id">
                        <tr>
                            <td>Informasi Bank</td>
                            <td class="fw-bold">
                                <p>Bank : BRI</p>
                                <p>No Rekening : 1234 2312 1232</p>
                                <p>Atas Nama : Apotek</p>
                            </td>
                        </tr>
                        <tr>
                            <td>Bukti Pembayaran</td>
                            <td>
                                <input type="file" name="bukti_pembayaran" class="form-control" required accept="image/*">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    const api_url = "{{ url('api/transaksi') }}";

    $('select[name="obat_id"]').change(function() {
        var harga = $(this).find(':selected').data('harga');
        var jumlah = $('input[name="jumlah"]').val() ? $('input[name="jumlah"]').val() : 0;
        var total = parseInt(harga) * parseInt(jumlah);
        $('#total').val(total);
    });

    $('input[name="jumlah"]').keyup(function() {
        var harga = $('select[name="obat_id"]').find(':selected').data('harga');
        var jumlah = $(this).val() ? $(this).val() : 0;
        var total = parseInt(harga) * parseInt(jumlah);
        $('#total').val(total);
    });

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
                                @can('confirm-transaksi')
                                <td>${item.user.name}</td>
                                @endcan
                                <td><img src="${item.obat_gambar}" class="rounded" style="width: 200px; height:200px"></td>
                                <td>${item.obat.nama_obat}</td>
                                <td>${item.jumlah}</td>
                                <td>Rp. ${convertToRupiah(item.total_harga)}</td>
                                <td align="center">`;
                    `@if(auth()->user()->role == 'pelanggan')`
                    if (!item.bukti_pembayaran) {
                        htmls += ` <button class="btn btn-primary py-1" onclick="editData(${item.id})">
                                        Bayar
                                    </button>`;
                    } else {
                        if (item.bukti_pembayaran.status == 'pending') {
                            htmls += ` <span class="badge badge-warning">Menunggu Konfirmasi</span>`;
                        } else if (item.bukti_pembayaran.status == 'paid') {
                            htmls += ` <span class="badge badge-success">Diterima</span>`;
                        } else {
                            htmls += ` <span class="badge badge-danger">Ditolak</span>`;
                        }
                    }
                    `@else`
                    if (item.bukti_pembayaran) {
                        if (item.bukti_pembayaran.status == 'pending') {
                            htmls += ` <button class="btn btn-primary py-1" onclick="konfirmasiPembayaran(${item.id})">
                                        Konfirmasi
                                    </button>
                                    <button class="btn btn-danger py-1" onclick="tolakPembayaran(${item.id})">
                                        Tolak
                                    </button>`;
                        } else if (item.bukti_pembayaran.status == 'paid') {
                            htmls += ` <span class="badge badge-success">Diterima</span>`;
                        } else {
                            htmls += ` <span class="badge badge-danger">Ditolak</span>`;
                        }
                    } else {
                        htmls += ` <button class="btn btn-primary py-1" onclick="editData(${item.id})">
                                        Bayar
                                    </button>`;
                    }
                    `@endif`
                    htmls += ` </td></tr>`;
                    dt.append(htmls);
                });
                $('#dataTable').DataTable();
            }
        });
    }

    getData();

    function addData() {
        $('#addModal').find('input').each(function() {
            if ($(this).val() == '') {
                $(this).val('');
            }
        });
        $('#addModal').find('textarea').val('');
        $('#addModal').find('select').val('');
        $('#addModal').modal('show');
    }

    function storeData() {
        const data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        `@if(auth()->user()->role != 'pelanggan')`
        data.append('user_id', $('#addModal').find('select[name="user_id"]').val());
        `@endif`
        data.append('obat_id', $('#addModal').find('select[name="obat_id"]').val());
        data.append('jumlah', $('#addModal').find('input[name="jumlah"]').val());

        $.ajax({
            url: api_url,
            type: "POST",
            headers: {
                Authorization: ` Bearer {{ session('api_token') }}`
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
                Authorization: ` Bearer {{ session('api_token') }}`
            },
            dataType: "json",
            success: function(x) {
                const data = x.data;
                $('#editModal').find('input[name="id"]').val(data.id);
                $('#editModal').modal('show');
            }
        });
    }

    function uploadBukti() {
        const id = $('#editModal').find('input[name="id"]').val();
        let data = new FormData();
        data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        data.append('bukti_pembayaran', $('#editModal').find('input[name="bukti_pembayaran"]')[0].files[0]);

        $.ajax({
            url: api_url + "/" + id + "/bukti",
            type: "POST",
            headers: {
                Authorization: ` Bearer {{ session('api_token') }}`
            },
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(x) {
                $('#editModal').modal('hide');
                Swal.fire(
                    'Berhasil!',
                    'Bukti berhasil diupload.',
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
        uploadBukti();
    });

    `@if(auth()->user()->role != 'pelanggan')`

    function konfirmasiPembayaran(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: "Apakah anda yakin ingin mengkonfirmasi pembayaran ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: api_url + "/" + id + "/confirm",
                    type: "PUT",
                    headers: {
                        Authorization: ` Bearer {{ session('api_token') }}`
                    },
                    dataType: "json",
                    success: function(x) {
                        Swal.fire(
                            'Dikonfirmasi!',
                            'Transaksi selesai.',
                            'success'
                        );
                        getData();
                    }
                });
            }
        });
    }

    function tolakPembayaran(id) {
        Swal.fire({
            title: 'Tolak Pembayaran',
            text: "Apakah anda yakin ingin menolak pembayaran ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Tolak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: api_url + "/" + id + "/reject",
                    type: "PUT",
                    headers: {
                        Authorization: ` Bearer {{ session('api_token') }}`
                    },
                    dataType: "json",
                    success: function(x) {
                        Swal.fire(
                            'Ditolak!',
                            'Pembayaran ditolak.',
                            'success'
                        );
                        getData();
                    }
                });
            }
        });
    }
    `@endif`
</script>
@endpush
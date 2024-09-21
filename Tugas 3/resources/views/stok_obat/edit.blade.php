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
                                                Tambah Stok Obat
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <form action="{{ route('stok.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <table class="table">
                                                                <tr>
                                                                    <td>Nama Obat</td>
                                                                    <td><input type="text" class="form-control" readonly value="{{ $obat->nama_obat }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Stok Sekarang</td>
                                                                    <td><input type="number" class="form-control" readonly value="{{ $obat->stok }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jumlah Tambah</td>
                                                                    <td><input type="number" name="jumlah_stok" class="form-control" required id="jumlah" min="1" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Total</td>
                                                                    <td><input type="number" class="form-control" readonly value="{{ $obat->stok }}" id="total"></td>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#jumlah').keyup(function() {
            var jumlah_stok = $(this).val() ? $(this).val() : 0;
            if (jumlah_stok < 0) {
                jumlah_stok = 0;
            }
            var stok_sekarang = '{{ $obat->stok }}';
            var total = parseInt(jumlah_stok) + parseInt(stok_sekarang);
            $('#total').val(total);
        });
    });
</script>
@endpush

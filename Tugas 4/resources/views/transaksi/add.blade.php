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
                                                Tambah Transaksi
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
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
                                                            <div class="text-center mt-5">
                                                                <button class="btn btn-success">Proses</button>
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
    });
</script>
@endpush

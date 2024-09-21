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
                                                Upload Bukti Pembayaran
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="container-fluid">
                                                        <form action="{{ route('transaksi.bukti', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <table class="table">
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
                                                            <div class="text-center mt-5">
                                                                <button class="btn btn-success">Upload</button>
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
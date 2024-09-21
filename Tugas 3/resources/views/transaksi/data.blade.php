@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold ">Transaksi</h6>
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary"><i class="fa fa-plus fs-5"
                        aria-hidden="true"></i></a>
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
                            <?php
                        $nomor = 1;
                        foreach ($data as $x) { ?>
                            <tr class="text-center">
                                <td>{{ $nomor++ }}</td>
                                @can('confirm-transaksi')
                                    <td>{{ $x->user->name }}</td>
                                @endcan
                                <td><img src="{{ Storage::url($x->obat->gambar) }}" class="rounded"
                                        style="width: 200px; height:200px"></td>
                                <td>{{ $x->obat->nama_obat }}</td>
                                <td>{{ $x->jumlah }}</td>
                                <td>Rp. {{ number_format($x->total_harga, 0, ',', '.') }}</td>
                                <td align="center">
                                    @if (auth()->user()->role == 'pelanggan')
                                        @if (!$x->bukti_pembayaran)
                                            <a href="{{ route('transaksi.show', $x->id) }}" class="btn btn-primary py-1">
                                                Bayar
                                            </a>
                                        @else
                                            @if ($x->bukti_pembayaran->status == 'pending')
                                                <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                            @elseif ($x->bukti_pembayaran->status == 'paid')
                                                <span class="badge badge-success">Diterima</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        @endif
                                    @else
                                        @if ($x->bukti_pembayaran)
                                            @if ($x->bukti_pembayaran->status == 'pending')
                                                <a href="{{ route('transaksi.confirm', $x->id) }}"
                                                    class="btn btn-primary py-1">
                                                    Konfirmasi
                                                </a>
                                                <a href="{{ route('transaksi.reject', $x->id) }}"
                                                    class="btn btn-danger py-1">
                                                    Tolak
                                                </a>
                                            @elseif ($x->bukti_pembayaran->status == 'paid')
                                                <span class="badge badge-success">Diterima</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        @else
                                            <a href="{{ route('transaksi.show', $x->id) }}" class="btn btn-primary py-1">
                                                Bayar
                                            </a>
                                            <!-- <span class="badge badge-warning">Menunggu Pembayaran</span> -->
                                        @endif
                                    @endif
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

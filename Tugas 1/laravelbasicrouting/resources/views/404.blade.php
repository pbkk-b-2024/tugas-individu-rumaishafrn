@extends('app.layout')

@section('header')
@endsection

@section('content')
<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
        <p>
            Kita tidak dapat menemukan halaman yang Anda cari.
            Selain itu, Anda dapat <a href="{{ route('home') }}">kembali ke dashboard</a>.
        </p>
    </div>

</div>
@endsection
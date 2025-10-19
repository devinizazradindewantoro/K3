@extends('layouts.template')

@section('title', 'Dashboard K3')
@section('page_title', 'Dashboard K3')

@section('content')
<div class="card p-3">
    <h3 class="mb-3 text-center text-danger">Dashboard K3 PT HM Sampoerna Tbk</h3>
    <p class="text-center mb-4">Selamat datang di sistem Kesehatan dan Keselamatan Kerja PT HM Sampoerna Tbk.</p>

    <!-- Carousel -->
    <div id="carouselK3" class="carousel slide" data-ride="carousel" data-interval="5000">
        <div class="carousel-inner rounded shadow">

            <div class="carousel-item active">
                <img src="{{ asset('adminlte/dist/img/background.avif') }}" class="d-block w-100 carousel-img" alt="Foto 1">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('adminlte/dist/img/background2.avif') }}" class="d-block w-100 carousel-img" alt="Foto 2">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('adminlte/dist/img/background3.avif') }}" class="d-block w-100 carousel-img" alt="Foto 3">
            </div>

            <div class="carousel-item">
                <img src="{{ asset('adminlte/dist/img/background4.avif') }}" class="d-block w-100 carousel-img" alt="Foto 4">
            </div>
        </div>

        <!-- Kontrol navigasi -->
        <a class="carousel-control-prev" href="#carouselK3" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Sebelumnya</span>
        </a>
        <a class="carousel-control-next" href="#carouselK3" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Berikutnya</span>
        </a>
    </div>
</div>

@push('styles')
<style>
/* Ukuran gambar carousel responsif */
.carousel-img {
    height: 420px; /* tinggi default (bisa disesuaikan) */
    object-fit: cover; /* menjaga proporsi gambar tetap bagus */
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .carousel-img {
        height: 250px;
    }
}

/* Untuk layar besar */
@media (min-width: 1200px) {
    .carousel-img {
        height: 450px;
    }
}
</style>
@endpush
@endsection

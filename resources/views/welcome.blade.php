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
                <img src="{{ asset('adminlte/dist/img/sampoerna.jpeg') }}" class="d-block w-100" alt="Foto 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('adminlte/dist/img/hmsampoerna.png') }}" class="d-block w-100" alt="Foto 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('adminlte/dist/img/hmsampoerna1.png') }}" class="d-block w-100" alt="Foto 3">
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
@endsection

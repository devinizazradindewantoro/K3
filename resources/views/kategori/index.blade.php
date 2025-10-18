@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">

    {{-- Banner Gambar di Atas --}}
    <div class="breadcrumb-banner position-relative mb-3">
        <img src="{{ asset('adminlte/dist/img/background.avif') }}" 
             alt="Banner Kebijakan K3" 
             class="img-fluid w-100" 
             style="max-height: 250px; object-fit: cover; border-radius: .25rem;">
    </div>

    <div class="card-body" style="max-height: 550px; overflow-y: auto;">
        <h4 class="fw-bold mb-3 text-primary">Kebijakan Keselamatan dan Kesehatan Kerja (K3) Sampoerna</h4>

        <p style="text-align: justify;">
            Kebijakan Keselamatan dan Kesehatan Kerja (K3) Sampoerna berfokus pada kepatuhan terhadap standar perusahaan, 
            standar perundang-undangan, dan penerapan praktik terbaik untuk memastikan keselamatan karyawan, pelanggan, 
            masyarakat, dan lingkungan. Perusahaan ini mengutamakan pencegahan kecelakaan dan penyakit akibat kerja dengan 
            menerapkan sistem manajemen K3 yang berkelanjutan dan mendorong partisipasi aktif dari seluruh pemangku kepentingan.
        </p>

        <h5 class="mt-4 fw-semibold">Poin Utama Kebijakan K3 Sampoerna:</h5>
        <ul style="text-align: justify;">
            <li>
                <b>Kepatuhan dan Standar:</b> Mematuhi semua peraturan perundang-undangan yang berlaku dan persyaratan lain 
                terkait K3, baik di tingkat nasional maupun standar internal perusahaan.
            </li>
            <li>
                <b>Keselamatan Operasional:</b> Mengutamakan keselamatan kerja dan operasi untuk meminimalkan risiko kecelakaan 
                dan gangguan kesehatan bagi karyawan.
            </li>
            <li>
                <b>Lingkungan Kerja:</b> Menciptakan lingkungan kerja yang aman, sehat, dan produktif bagi seluruh karyawan serta 
                pihak ketiga seperti pengunjung dan pemasok.
            </li>
            <li>
                <b>Budaya K3:</b> Membangun budaya keselamatan yang kuat melalui pendidikan, pelatihan, dan partisipasi aktif 
                dari semua pihak, mulai dari pimpinan hingga karyawan.
            </li>
            <li>
                <b>Perbaikan Berkelanjutan:</b> Melakukan perbaikan berkelanjutan pada sistem manajemen dan kinerja K3 untuk 
                meningkatkan budaya K3 di tempat kerja.
            </li>
            <li>
                <b>Pelatihan K3:</b> Memberikan pelatihan kepada tenaga kerja untuk meningkatkan kesadaran dan kinerja K3 mereka.
            </li>
        </ul>
    </div>
</div>

{{-- CSS tambahan --}}
@push('styles')
<style>
.breadcrumb-banner {
    position: relative;
    overflow: hidden;
}
.breadcrumb-banner img {
    transition: transform 0.4s ease;
}
.breadcrumb-banner:hover img {
    transform: scale(1.05);
}
ul {
    margin-left: 20px;
}
ul ul {
    margin-left: 25px;
    list-style-type: circle;
}
</style>
@endpush

@endsection

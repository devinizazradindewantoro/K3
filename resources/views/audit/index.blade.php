@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">
            Materi K3 (Keselamatan dan Kesehatan Kerja) - PT HM Sampoerna Tbk
        </h3>
    </div>

    <div class="card-body" style="max-height: 750px; overflow-y: auto;">
        <div class="row">
            
            {{-- Kolom kiri: teks materi --}}
            <div class="col-md-6"> 

                <div style="text-align: justify;">
                    <p><b>1. Simulasi Kebakaran - K3:</b>  
                    Menjelaskan langkah-langkah menghadapi kebakaran di tempat kerja. Karyawan diajarkan untuk mengenali sumber api, tetap tenang, menggunakan APAR dengan benar, dan mengikuti jalur evakuasi yang aman.</p>

                    <p><b>2. Prosedur Evakuasi Darurat:</b>  
                    Menampilkan prosedur evakuasi saat alarm darurat berbunyi. Materi ini menekankan pentingnya ketertiban, kecepatan, dan keselamatan menuju titik kumpul tanpa menimbulkan kepanikan.</p>

                    <p><b>3. Penggunaan APAR dengan Benar:</b>  
                    Memberikan panduan dalam menggunakan Alat Pemadam Api Ringan (APAR) menggunakan metode PASS (Pull, Aim, Squeeze, Sweep). Tujuannya agar karyawan dapat memadamkan api kecil secara aman dan efektif.</p>

                    <p><b>4. Tanggap Bencana Gempa:</b>  
                    Mengajarkan tindakan yang harus dilakukan ketika terjadi gempa bumi di area kerja, seperti berlindung di bawah meja yang kuat, menjauhi jendela, serta menuju area aman sesuai jalur evakuasi.</p>
                </div>
            </div>

            {{-- Kolom kanan: video --}}
            <div class="col-md-6">
                

                <div class="video-list">
                    {{-- Video 1 --}}
                    <div class="card mb-3 shadow-sm video-card">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/OGHycJ76OQg?si=lkv7fopkAzeYVRyE"
                                    title="Simulasi Kebakaran - K3" 
                                    allowfullscreen></iframe>
                        </div>
                        <div class="card-body py-2 text-center">
                            <h6 class="fw-semibold mb-0">Simulasi Kebakaran - K3</h6>
                        </div>
                    </div>

                    {{-- Video 2 --}}
                    <div class="card mb-3 shadow-sm video-card">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/vGogkOOh5KQ?si=w7liaVgACZmnkqZr" 
                                    title="Prosedur Evakuasi Darurat" 
                                    allowfullscreen></iframe>
                        </div>
                        <div class="card-body py-2 text-center">
                            <h6 class="fw-semibold mb-0">Prosedur Evakuasi Darurat</h6>
                        </div>
                    </div>

                    {{-- Video 3 --}}
                    <div class="card mb-3 shadow-sm video-card">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/qS1IfnVLNJ8?si=kznPs_mdRuujufOg" 
                                    title="Penggunaan APAR dengan Benar" 
                                    allowfullscreen></iframe>
                        </div>
                        <div class="card-body py-2 text-center">
                            <h6 class="fw-semibold mb-0">Penggunaan APAR dengan Benar</h6>
                        </div>
                    </div>

                    {{-- Video 4 --}}
                    <div class="card mb-3 shadow-sm video-card">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/dUBzPCNXy6U?si=x8iMVsizf9NsupzQ"
                                    title="Tanggap Bencana Gempa" 
                                    allowfullscreen></iframe>
                        </div>
                        <div class="card-body py-2 text-center">
                            <h6 class="fw-semibold mb-0">Tanggap Bencana Gempa</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambahan CSS --}}
@push('styles')
<style>
.video-card iframe {
    width: 100%;
    height: 300px;
    border: none;
    transition: transform 0.3s ease;
}
.video-card:hover iframe {
    transform: scale(1.03);
}
.video-card h6 {
    color: #222;
    font-weight: 600;
}
.video-card:hover h6 {
    color: #8B0000;
}
</style>
@endpush
@endsection

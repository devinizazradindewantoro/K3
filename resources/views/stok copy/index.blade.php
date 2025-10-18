@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">

    {{-- Banner --}}
    <div class="breadcrumb-banner position-relative mb-3">
        <img src="{{ asset('adminlte/dist/img/background.avif') }}" 
             alt="Banner K3" 
             class="img-fluid w-100" 
             style="max-height: 250px; object-fit: cover; border-radius: .25rem;">
    </div>

    {{-- Isi Card --}}
    <div class="card-body" style="max-height: 750px; overflow-y: auto; position: relative; z-index: 1;">
        <div class="row">
            {{-- Kolom kiri: teks materi --}}
            <div class="col-md-6">
                <h4 class="fw-bold mb-3 text-primary">
                    <i class="fas fa-exclamation-triangle text-warning"></i> 
                    Sikap dan Tindakan Saat Mengetahui Situasi Darurat
                </h4>

                <h5 class="fw-semibold mt-3">
                    <i class="fas fa-user-shield text-primary"></i> Sikap dan tindakan saat mengetahui situasi darurat:
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Tetap tenang:</b> Hindari berteriak agar tidak menimbulkan kepanikan.</li>
                    <li><b>Tanggap:</b> Bertindak cepat untuk menyelesaikan masalah.</li>
                    <li><b>Bertanggung jawab:</b> Menyelesaikan masalah sesuai dengan prosedur yang berlaku di perusahaan.</li>
                </ul>

                <h5 class="fw-semibold mt-4">
                    <i class="fas fa-fire-extinguisher text-danger"></i> Tindakan dalam menghadapi situasi darurat:
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Ikuti prosedur:</b> Lakukan tindakan sesuai prosedur darurat perusahaan.</li>
                    <li><b>Patuhi tanda bahaya:</b> Patuhi semua tanda peringatan atau instruksi dari sistem alarm.</li>
                    <li><b>Operasikan peralatan darurat:</b> Gunakan pemadam kebakaran atau alat keselamatan lain bila perlu.</li>
                    <li><b>Cari bantuan:</b> Segera cari bantuan dari rekan kerja atau pihak berwenang.</li>
                    <li><b>Laporkan insiden:</b> Laporkan kejadian kepada atasan atau pihak yang bertanggung jawab.</li>
                </ul>

                <h5 class="fw-semibold mt-4">
                    <i class="fas fa-fire text-danger"></i> Skenario darurat tertentu:
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Kebakaran:</b> Hindari bahaya asap dan panas, gunakan APD jika memungkinkan.</li>
                    <li><b>Pelanggan terganggu mental:</b> Segera bawa ke ruang kesehatan atau laporkan ke petugas medis.</li>
                </ul>
            </div>

            {{-- Kolom kanan: video --}}
            <div class="col-md-6">
                <h5 class="fw-semibold mb-3 text-center text-primary">
                    <i class="fab fa-youtube text-danger"></i> Video Tutorial K3
                </h5>

                {{-- Video landscape full width --}}
                <div class="video-list">
                    {{-- Video 1 --}}
                    <div class="card mb-3 shadow-sm video-card">
                        <div class="ratio ratio-16x9 rounded-top overflow-hidden">
                            <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"
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
                            <iframe src="https://www.youtube.com/embed/ysz5S6PUM-U"
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
                            <iframe src="https://www.youtube.com/embed/aqz-KE-bpKQ"
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
                            <iframe src="https://www.youtube.com/embed/ScMzIvxBSi4"
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

/* Video style */
.video-card iframe {
    width: 100%;
    height: 350px; /* Biar landscape dan panjang */
    border: none;
    transition: transform 0.25s ease;
}
.video-card:hover iframe {
    transform: scale(1.02);
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

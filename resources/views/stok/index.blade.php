@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <!-- <i class="fas fa-exclamation-triangle text-warning"></i>  -->
            Sikap dan Tindakan Saat Mengetahui Situasi Darurat
        </h3>
    </div>

    <div class="card-body" style="max-height: 750px; overflow-y: auto;">
        <div class="row">
            
            {{-- Kolom kiri: teks materi --}}
            <div class="col-md-6">
                <p style="text-align: justify;">
                    Dalam menghadapi situasi darurat, setiap karyawan diharapkan memiliki kesiapsiagaan dan ketenangan agar dapat mengambil langkah yang tepat sesuai prosedur perusahaan.
                </p>

                <h5 class="mt-3 fw-semibold text-primary">
                    <i class="fas fa-user-shield"></i> Sikap dan Tindakan Saat Mengetahui Situasi Darurat
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Tetap Tenang:</b> Hindari berteriak agar tidak menimbulkan kepanikan.</li>
                    <li><b>Tanggap:</b> Bertindak cepat untuk menyelesaikan masalah.</li>
                    <li><b>Bertanggung Jawab:</b> Menyelesaikan masalah sesuai prosedur yang berlaku di perusahaan.</li>
                </ul>

                <h5 class="mt-4 fw-semibold text-primary">
                    <i class="fas fa-fire-extinguisher text-danger"></i> Tindakan Dalam Menghadapi Situasi Darurat
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Ikuti Prosedur:</b> Lakukan tindakan sesuai prosedur darurat perusahaan.</li>
                    <li><b>Patuhi Tanda Bahaya:</b> Patuhi semua tanda peringatan atau instruksi dari sistem alarm.</li>
                    <li><b>Operasikan Peralatan Darurat:</b> Gunakan pemadam kebakaran atau alat keselamatan lain bila perlu.</li>
                    <li><b>Cari Bantuan:</b> Segera cari bantuan dari rekan kerja atau pihak berwenang.</li>
                    <li><b>Laporkan Insiden:</b> Laporkan kejadian kepada atasan atau pihak yang bertanggung jawab.</li>
                </ul>

                <h5 class="mt-4 fw-semibold text-primary">
                    <i class="fas fa-fire text-danger"></i> Skenario Darurat Tertentu
                </h5>
                <ul style="text-align: justify;">
                    <li><b>Kebakaran:</b> Hindari bahaya asap dan panas, gunakan APD jika memungkinkan.</li>
                    <li><b>Pelanggan Terganggu Mental:</b> Segera bawa ke ruang kesehatan atau laporkan ke petugas medis.</li>
                </ul>
            </div>

            {{-- Kolom kanan: video --}}
            <div class="col-md-6">
                <h5 class="fw-semibold mb-3 text-center text-primary">
                    <i class="fab fa-youtube text-danger"></i> Video Materi K3
                </h5>

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

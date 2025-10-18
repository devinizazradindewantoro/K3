@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">

    {{-- Banner Gambar di Atas --}}
    <div class="breadcrumb-banner position-relative mb-3">
        <img src="{{ asset('adminlte/dist/img/background.avif') }}" 
             alt="Banner Situasi Darurat" 
             class="img-fluid w-100" 
             style="max-height: 250px; object-fit: cover; border-radius: .25rem;">
    </div>

    <div class="card-body" style="max-height: 550px; overflow-y: auto;">
        <h4 class="fw-bold mb-3 text-primary">
            <i class="fas fa-exclamation-triangle text-warning"></i> 
            Sikap dan Tindakan Saat Mengetahui Situasi Darurat
        </h4>

        <h5 class="fw-semibold mt-3">
            <i class="fas fa-user-shield text-primary"></i> Sikap dan tindakan saat mengetahui situasi darurat:
        </h5>
        <ul style="text-align: justify;">
            <li><i class="fas fa-smile text-success"></i> <b>Tetap tenang:</b> Hindari berteriak agar tidak menimbulkan kepanikan.</li>
            <li><i class="fas fa-bolt text-warning"></i> <b>Tanggap:</b> Bertindak cepat untuk menyelesaikan masalah.</li>
            <li><i class="fas fa-clipboard-check text-info"></i> <b>Bertanggung jawab:</b> Menyelesaikan masalah sesuai dengan prosedur yang berlaku di perusahaan.</li>
        </ul>

        <h5 class="fw-semibold mt-4">
            <i class="fas fa-fire-extinguisher text-danger"></i> Tindakan dalam menghadapi situasi darurat:
        </h5>
        <ul style="text-align: justify;">
            <li><i class="fas fa-list-ol text-secondary"></i> <b>Ikuti prosedur:</b> Lakukan tindakan sesuai dengan prosedur darurat perusahaan yang telah ditetapkan.</li>
            <li><i class="fas fa-bullhorn text-danger"></i> <b>Patuhi tanda bahaya:</b> Patuhi semua tanda peringatan atau instruksi yang diberikan melalui sistem alarm.</li>
            <li><i class="fas fa-tools text-dark"></i> <b>Operasikan peralatan darurat:</b> Gunakan peralatan darurat seperti pemadam kebakaran atau perlengkapan keselamatan lainnya jika diperlukan.</li>
            <li><i class="fas fa-hands-helping text-primary"></i> <b>Cari bantuan:</b> Segera cari bantuan dari rekan kerja atau pihak yang berwenang.</li>
            <li><i class="fas fa-file-alt text-success"></i> <b>Laporkan insiden:</b> Laporkan kejadian secara lisan atau tertulis kepada atasan atau pihak yang bertanggung jawab.</li>
        </ul>

        <h5 class="fw-semibold mt-4">
            <i class="fas fa-fire text-danger"></i> Skenario darurat tertentu:
        </h5>
        <ul style="text-align: justify;">
            <li><i class="fas fa-fire text-danger"></i> <b>Kebakaran:</b> Hindari bahaya asap dan panas dengan menggunakan pakaian pelindung jika memungkinkan.</li>
            <li><i class="fas fa-user-injured text-warning"></i> <b>Pelanggan yang terganggu mentalnya:</b> Segera bawa ke ruang kesehatan dan keselamatan kerja atau laporkan ke petugas kesehatan terdekat.</li>
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
ul li {
    margin-bottom: 6px;
}
ul ul {
    margin-left: 25px;
    list-style-type: circle;
}
</style>
@endpush

@endsection

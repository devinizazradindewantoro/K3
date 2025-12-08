@extends('layouts.template')

@section('content')
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">
                Struktur Organisasi & Deskripsi Peran – PT HM Sampoerna Tbk
            </h3>
        </div>

        <div class="card-body" style="max-height: 750px; overflow-y: auto;">

            {{-- FOTO STRUKTUR ORGANISASI --}}
            <div class="text-center mb-4">
                <img src="adminlte/dist/img/struktur.jpg" alt="Struktur Organisasi" class="img-fluid rounded shadow"
                    style="max-width: 85%; border: 2px solid #c00;">
                <h5 class="mt-3 fw-bold">Struktur Organisasi PT HM Sampoerna Tbk</h5>
            </div>

            <hr class="mb-4">

            <div class="row">
                {{-- <div class="row mt-4"> --}}
                <div class="col-md-12">
                    <h4 class="text-center fw-bold mb-3">Deskripsi Struktur</h4>
                </div>

                {{-- Kolom kiri: DESKRIPSI STRUKTUR --}}
                <div class="col-md-6">
                    <div style="text-align: justify; line-height: 1.5;">

                        <p><b>1. Direktur Utama – Bapak Vasilius Santoso</b><br>
                            Penanggung jawab tertinggi kebijakan keselamatan dan kesehatan kerja.</p>
                        <ul>
                            <li>Menetapkan visi dan misi keselamatan di seluruh area operasional.</li>
                            <li>Mengawasi kepatuhan terhadap regulasi K3 nasional.</li>
                            <li>Memberikan dukungan sumber daya dan anggaran bagi pelaksanaan program K3.</li>
                        </ul>

                        <p><b>2. Direktur Operasional – Ibu Dina Lombardi</b><br>
                            Bertanggung jawab atas implementasi kebijakan keselamatan di seluruh lini produksi.</p>
                        <ul>
                            <li>Memastikan standar keselamatan diterapkan di pabrik linting, pengemasan, dan gudang.</li>
                            <li>Mengkoordinasikan setiap kepala pabrik terkait laporan periodik K3.</li>
                            <li>Melakukan evaluasi risiko kecelakaan serta efektivitas prosedur kerja aman.</li>
                        </ul>

                        <p><b>3. Kepala Teknik & Keselamatan – Ir. Ahmad Mashuri</b><br>
                            Pemimpin bidang teknis yang mengawasi penerapan K3 di fasilitas produksi.</p>
                        <ul>
                            <li>Mengontrol kondisi mesin linting, ventilasi, dan instalasi listrik.</li>
                            <li>Mengidentifikasi potensi bahaya teknis dan mengembangkan sistem perawatan preventif.</li>
                            <li>Berkoordinasi dengan tim HSE untuk memastikan mesin memenuhi standar industri.</li>
                        </ul>

                        <p><b>4. Kepala Pabrik Linting – Ibu Sinta Hartanto</b><br>
                            Mengawasi area kerja berisiko ergonomis tinggi.</p>
                        <ul>
                            <li>Pengawasan penggunaan APD (masker, sarung tangan, kursi ergonomis).</li>
                            <li>Menyusun jadwal istirahat & rotasi kerja untuk mencegah kelelahan.</li>
                            <li>Melaporkan insiden kerja ringan ke petugas K3.</li>
                        </ul>

                        <p><b>5. Kepala Pabrik Barat – Bapak Kurnia Sulistyawan</b><br>
                            Fokus pada keselamatan alat berat & otomatisasi.</p>
                        <ul>
                            <li>Memastikan pelatihan keselamatan operator mesin.</li>
                            <li>Mengawasi pelaksanaan lock-out tag-out saat perbaikan mesin.</li>
                            <li>Melakukan inspeksi area berisiko seperti gudang bahan bakar dan boiler.</li>
                        </ul>
                    </div>
                </div>

                {{-- Kolom kanan: lanjutan deskripsi --}}
                <div class="col-md-6">
                    <div style="text-align: justify; line-height: 1.5;">

                        <p><b>6. Kepala Pabrik Timur – Bapak Aji Sumantoro</b><br>
                            Bertanggung jawab atas logistik & penyimpanan bahan baku.</p>
                        <ul>
                            <li>Mengelola tata letak gudang agar aman dari bahaya kebakaran/kimia.</li>
                            <li>Memastikan pengemasan bahan tembakau sesuai standar higienitas.</li>
                            <li>Berkolaborasi dengan tim pemadam internal.</li>
                        </ul>

                        <p><b>7. Kepala Sustainability – Ibu Imron Hamzah</b><br>
                            Pemimpin program keberlanjutan lingkungan & kesehatan kerja.</p>
                        <ul>
                            <li>Mengembangkan program pengelolaan limbah & udara bersih.</li>
                            <li>Memastikan kepatuhan terhadap ISO 45001.</li>
                            <li>Menyelenggarakan kampanye budaya kerja sehat.</li>
                        </ul>

                        <p><b>8. Manajer K3 – Bapak Rendy Mahardika</b><br>
                            Pemimpin pelaksanaan teknis K3 di seluruh fasilitas.</p>
                        <ul>
                            <li>Mengkoordinasikan petugas K3 tiap pabrik.</li>
                            <li>Melakukan investigasi kecelakaan & analisis akar penyebab.</li>
                            <li>Menyusun laporan K3 kepada Disnaker setiap triwulan.</li>
                        </ul>

                        <p><b>9. Petugas K3 Pabrik – Ibu Laras Kusumawardani</b><br>
                            Penanggung jawab memastikan standar keselamatan harian.</p>
                        <ul>
                            <li>Melakukan inspeksi rutin APD & APAR.</li>
                            <li>Memberikan pelatihan singkat bahaya kerja.</li>
                            <li>Membuat catatan near miss untuk perbaikan sistem.</li>
                        </ul>

                        <p><b>10. Petugas P3K – Bapak Yoga Saputra</b><br>
                            Tenaga pertolongan pertama pabrik.</p>
                        <ul>
                            <li>Menyiapkan peralatan medis dasar & stok obat.</li>
                            <li>Menangani luka ringan & iritasi bahan kimia.</li>
                            <li>Melaporkan kejadian medis kepada Manajer K3.</li>
                        </ul>

                        <p><b>11. Tim Pemadam Internal – Ibu Ratri Anindya</b><br>
                            Tim darurat kebakaran & evakuasi.</p>
                        <ul>
                            <li>Melakukan simulasi evakuasi setiap 6 bulan.</li>
                            <li>Memastikan APAR/hydrant/sprinkler siap pakai.</li>
                            <li>Berkolaborasi dengan dinas pemadam setempat.</li>
                        </ul>
                    </div>

                    <hr class="my-4">
                </div>

            </div>
        </div>
    </div>
    </div>

    {{-- @push('styles')
        <style>
            .video-card iframe {
                width: 100%;
                height: 280px;
                border: none;
                transition: transform 0.3s ease;
            }

            .video-card:hover iframe {
                transform: scale(1.03);
            }
        </style>
    @endpush --}}
@endsection

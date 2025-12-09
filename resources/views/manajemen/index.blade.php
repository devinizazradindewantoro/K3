@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">
    <div class="card-header">
        <h3 class="card-title">Identifikasi dan Pengendalian Risiko K3 – Pabrik Rokok Sampoerna</h3>
    </div>

    <div class="card-body">

        {{-- ======================= POIN 1 ======================= --}}
        <h5 class="mt-3 text-danger">1. Identifikasi Potensi Sumber Bahaya</h5>

        <h6 class="mt-2 text-primary">1.1 Bahaya Fisik</h6>
        <ul style="text-align: justify;">
            <li>Mesin pelinting dan pengemas rokok (roller, belt conveyor, pisau potong otomatis).</li>
            <li>Bagian mesin bergerak tanpa pelindung yang memadai.</li>
            <li>Lantai licin akibat tumpahan bahan baku tembakau dan kemasan.</li>
            <li>Kebisingan tinggi dari mesin produksi (≥85 dB).</li>
            <li>Debu tembakau yang tersebar di area produksi.</li>
            <li>Pencahayaan kurang memadai di beberapa area.</li>
            <li>Suhu ruang produksi panas akibat mesin dan proses pengeringan.</li>
        </ul>

        <h6 class="mt-2 text-primary">1.2 Bahaya Kimia</h6>
        <ul style="text-align: justify;">
            <li>Paparan debu tembakau yang terhirup terus-menerus.</li>
            <li>Bahan kimia untuk perawatan mesin (minyak, pelumas, pelarut).</li>
            <li>Bahan perekat/lem untuk kemasan rokok.</li>
            <li>Tinta percetakan mengandung logam berat.</li>
            <li>Asap rokok pada area pengujian kualitas.</li>
        </ul>

        <h6 class="mt-2 text-primary">1.3 Bahaya Ergonomi</h6>
        <ul style="text-align: justify;">
            <li>Pekerjaan repetitif pada proses sortir & pengemasan.</li>
            <li>Posisi duduk/berdiri statis dalam waktu lama.</li>
            <li>Pengangkatan bal tembakau (±15–20 kg) secara manual.</li>
            <li>Pengangkatan karton rokok (±10–15 kg) berulang setiap hari.</li>
            <li>Ketegangan otot leher, pundak, dan lengan.</li>
        </ul>

        <h6 class="mt-2 text-primary">1.4 Bahaya Kebakaran & Ledakan</h6>
        <ul style="text-align: justify;">
            <li>Akumulasi debu tembakau kering yang mudah menyala.</li>
            <li>Material kemasan kertas dan karton yang mudah terbakar.</li>
            <li>Instalasi listrik berpotensi korsleting.</li>
            <li>Solvent mudah terbakar pada pembersihan & percetakan.</li>
            <li>Area cigarette lighting station dengan api terbuka.</li>
        </ul>

        <h6 class="mt-2 text-primary">1.5 Bahaya Biologis & Psikososial</h6>
        <ul style="text-align: justify;">
            <li>Jamur pada tembakau lembab (penyakit pernapasan).</li>
            <li>Stres kerja akibat target produksi.</li>
            <li>Shift malam panjang yang mengganggu ritme tubuh.</li>
            <li>Tekanan dari manajemen.</li>
            <li>Hubungan kerja kurang harmonis.</li>
        </ul>

        <hr>

        {{-- ======================= POIN 2 ======================= --}}
        <h5 class="mt-3 text-danger">2. Penilaian Kemungkinan dan Tingkat Keparahan Risiko</h5>
        <p style="text-align: justify;">
            Penilaian risiko dilakukan menggunakan matriks risiko berdasarkan tingkat kemungkinan dan tingkat keparahan.
        </p>

        <h6 class="text-primary">Kategori Penilaian</h6>
        <ul style="text-align: justify;">
            <li><strong>1–2:</strong> Risiko Rendah (dapat diabaikan)</li>
            <li><strong>3–4:</strong> Risiko Sedang (dapat ditoleransi)</li>
            <li><strong>6–9:</strong> Risiko Tinggi (harus dikontrol)</li>
            <li><strong>12–16:</strong> Risiko Sangat Tinggi (penanganan segera)</li>
        </ul>

        <h6 class="text-primary mt-2">Contoh Penilaian Risiko Utama</h6>
        <ul style="text-align: justify;">
            <li>Terjepit mesin pelinting → Risiko 9 (Tinggi)</li>
            <li>Paparan debu tembakau → Risiko 8 (Tinggi)</li>
            <li>Kebakaran debu + kemasan → Risiko 8 (Tinggi)</li>
            <li>Cedera ergonomi (MSDs) → Risiko 6 (Sedang)</li>
            <li>Kebisingan berlebih → Risiko 8 (Tinggi)</li>
        </ul>

        <hr>

        {{-- ======================= POIN 3 ======================= --}}
        <h5 class="mt-3 text-danger">3. Tindakan Mengurangi atau Menghilangkan Risiko</h5>
        <p style="text-align: justify;">Pengendalian risiko mengikuti hierarki dari paling efektif ke paling rendah.</p>

        <h6 class="text-primary">3.1 Eliminasi & Substitusi</h6>
        <ul style="text-align: justify;">
            <li>Menghapus proses uji hisap di area produksi.</li>
            <li>Mengganti bahan solvent mudah terbakar dengan bahan berbasis air.</li>
            <li>Mengganti tinta percetakan dengan tinta berbasis air.</li>
        </ul>

        <h6 class="text-primary">3.2 Rekayasa Teknik</h6>
        <ul style="text-align: justify;">
            <li>Pemasangan guard di mesin pelinting & pengemas.</li>
            <li>Pemasangan emergency stop button.</li>
            <li>Ventilasi umum & Local Exhaust Ventilation (LEV).</li>
            <li>Sprinkler otomatis, detektor asap, hydrant.</li>
            <li>Penerangan minimal 300 lux.</li>
            <li>Upgrade instalasi listrik sesuai standar IEC & PUIL.</li>
        </ul>

        <h6 class="text-primary">3.3 Pengendalian Administratif</h6>
        <ul style="text-align: justify;">
            <li>Penerapan SOP operasi mesin.</li>
            <li>LOTO saat maintenance.</li>
            <li>Permit to Work untuk pekerjaan panas & listrik.</li>
            <li>Pelatihan K3 dasar, pelatihan APD, training tanggap darurat.</li>
            <li>Rotasi kerja & pembatasan lembur.</li>
        </ul>

        <h6 class="text-primary">3.4 APD</h6>
        <ul style="text-align: justify;">
            <li>Helm keselamatan.</li>
            <li>Sarung tangan sesuai kebutuhan kerja.</li>
            <li>Kacamata keselamatan & face shield.</li>
            <li>Masker N95/KN95 atau respirator.</li>
            <li>Sepatu safety anti-slip & anti-statis.</li>
            <li>Ear plug/ear muff untuk area ≥85 dB.</li>
        </ul>

        <hr>

        {{-- ======================= POIN 4 ======================= --}}
        <h5 class="mt-3 text-danger">4. Pemantauan Efektivitas Pengendalian Risiko dan Review Berkala</h5>

        <h6 class="text-primary">4.1 Pemantauan Efektivitas</h6>
        <ul style="text-align: justify;">
            <li>Inspeksi harian & mingguan area produksi.</li>
            <li>Pemeriksaan sistem ventilasi & panel listrik.</li>
            <li>Pencatatan kecelakaan & near miss.</li>
            <li>Pengukuran kebisingan, debu, penerangan, suhu & kelembapan.</li>
        </ul>

        <h6 class="text-primary">4.2 Review Berkala</h6>
        <ul style="text-align: justify;">
            <li>Review bulanan: SOP, APD, data kecelakaan.</li>
            <li>Review triwulanan: tren kecelakaan, evaluasi pelatihan.</li>
            <li>Review tahunan: revisi HIRADC, audit internal SMK3.</li>
            <li>Audit eksternal pihak ketiga minimal 1x per tahun.</li>
        </ul>

        <h6 class="text-primary">4.3 Mekanisme Umpan Balik</h6>
        <ul style="text-align: justify;">
            <li>Rapat K3 bulanan.</li>
            <li>Sistem pelaporan near miss.</li>
            <li>Kotak saran K3 & reward system.</li>
            <li>PDCA dalam setiap perbaikan.</li>
        </ul>

    </div>
</div>
@endsection

@extends('layouts.template')

@section('content')
<div class="card card-outline card-danger">

    {{-- Banner Gambar di Atas --}}
    <div class="breadcrumb-banner position-relative mb-3">
        <img src="{{ asset('adminlte/dist/img/background.avif') }}" 
             alt="Banner Profil Perusahaan" 
             class="img-fluid w-100" 
             style="max-height: 250px; object-fit: cover; border-radius: .25rem;">
        <!-- <div class="position-absolute top-50 start-50 translate-middle text-white text-center"
             style="background: rgba(0,0,0,0.5); padding: 8px 20px; border-radius: 8px;">
            <h4 class="fw-bold mb-0">Profil Perusahaan</h4>
        </div> -->
    </div>

    <div class="card-body" style="max-height: 550px; overflow-y: auto;">
        <div class="text-center mb-4">
            <!-- <img src="{{ asset('adminlte/dist/img/hmsampoerna1.png') }}" alt="Logo Sampoerna" class="img-fluid" style="max-width: 180px;"> -->
        </div>

         <!-- Konten scrollable -->
        <p style="text-align: justify;">
            PT Hanjaya Mandala Sampoerna Tbk. (“Sampoerna”) telah menjadi bagian penting dari industri tembakau Indonesia selama lebih dari seratus tahun sejak berdiri tahun 1913, dengan produk legendaris Dji Sam Soe atau dikenal dengan “Raja Kretek”.
        </p>

        <p style="text-align: justify;">
            Selama lebih dari 111 tahun, Perseroan memimpin pasar rokok Indonesia dengan pangsa pasar sebesar 27.4% pada tahun 2024. Sampoerna merupakan pelopor kategori Sigaret Kretek Mesin Kadar Rendah (SKM LT) di Indonesia dengan memperkenalkan produk Sampoerna A pada tahun 1989.
        </p>

        <p style="text-align: justify;">
            Perseroan juga memproduksi sejumlah merek rokok kretek yang telah dikenal luas, termasuk Dji Sam Soe Magnum, Marlboro Filter Black, dan Sampoerna Kretek.
        </p>

        <p style="text-align: justify;">
            Sampoerna merupakan anak perusahaan PT Philip Morris Indonesia (“PMID”) dan memiliki afiliasi dengan Philip Morris International Inc. (“PMI”) sejak 2005. PMI adalah perusahaan rokok internasional terkemuka dengan merek global, Marlboro. Ruang lingkup kegiatan Perseroan meliputi, antara lain memproduksi, memperdagangkan, dan mendistribusikan rokok termasuk juga mendistribusikan Marlboro, merek rokok internasional terkemuka yang diproduksi oleh PMID.
        </p>

        <p style="text-align: justify;">
            Tim manajemen Sampoerna yang berpengalaman senantiasa menerapkan praktik global terbaik dan sistem kelas dunia dalam mengelola lebih dari 90.000 tenaga kerja, baik secara langsung dan tidak langsung.
        </p>

        <p style="text-align: justify;">
            Selain itu, Sampoerna juga bekerja sama dengan 43 Mitra Produksi Sigaret (MPS) yang dimiliki oleh koperasi dan pengusaha daerah yang memproduksi produk-produk Sigaret Kretek Tangan (SKT). Perseroan menjual dan mendistribusikan rokok melalui 105 lokasi kantor cabang zona, kantor penjualan, dan pusat distribusi di seluruh Indonesia.
        </p>

        <p style="text-align: justify;">
            Sampoerna memiliki sejumlah anak perusahaan yang secara aktif berkontribusi terhadap kinerja keseluruhan bisnis Sampoerna dari tahun ke tahun. Seluruh saham anak perusahaan ini dimiliki sepenuhnya oleh Sampoerna, baik secara langsung maupun tidak langsung.
        </p>

        <p style="text-align: justify;">
            PT Perusahaan Dagang dan Industri Panamas (Panamas) adalah anak perusahaan Sampoerna yang merupakan perseroan terbatas yang menjalankan berbagai kegiatan usaha, termasuk distribusi barang (terutama produk tembakau), pengangkutan dan pergudangan, periklanan, perumahan, dan konsultasi manajemen. Panamas memiliki lebih dari 5.000 tenaga kerja yang tersebar di seluruh Indonesia dan jaringan distribusi luas yang mencakup lebih dari 90% kota/kabupaten di Indonesia.
        </p>

        <p style="text-align: justify;">
            PT SRC Indonesia Sembilan (SRCIS) adalah perseroan terbatas yang sebelumnya bernama PT Union Sampoerna Dinamika. Anak perusahaan Sampoerna ini resmi didirikan pada tanggal 18 September 1999, sebelum mengganti namanya menjadi PT SRC Indonesia Sembilan pada tanggal 8 Juni 2018. SRCIS bergerak di bidang perdagangan umum, platform digital untuk komersial, dan agensi.
        </p>

        <p style="text-align: justify;">
            PT Sampoerna Karya Bangsa (SKB) adalah perseroan terbatas yang dahulu dikenal dengan nama PT Wahana Sampoerna. SKB didirikan pada tanggal 10 April 1989 dan bergerak di bidang pelatihan kerja.
        </p>

        <p style="text-align: justify;">
            PT Harapan Karya Sembilan (HKS), yang sebelumnya dikenal sebagai PT Harapan Maju Sentosa, merupakan anak perusahaan Sampoerna yang didirikan berdasarkan hukum Indonesia. Saat ini, HKS bergerak di industri jasa kreatif, mencakup konsultasi manajemen, periklanan, dan jasa manajemen merek. Tujuan utama HKS adalah membantu membangun merek yang kuat dan menjalankan aktivitas pemasaran yang efektif untuk memastikan merek-merek tersebut unggul di kelasnya.
        </p>

        <p style="text-align: justify;">
            PT Persada Makmur Indonesia (Persada Makmur) adalah anak perusahaan Sampoerna yang merupakan perseroan terbatas. Persada Makmur didirikan pada tanggal 2 September 2003 dan bergerak di bidang perdagangan rokok.
        </p>

        <p style="text-align: justify;">
            PT Sampoerna Indonesia Sembilan (SIS) adalah perseroan terbatas yang sebelumnya bernama PT Asia Tembakau. Anak perusahaan Sampoerna ini resmi didirikan pada tanggal 13 Februari 2002 sebelum mengganti namanya menjadi PT Sampoerna Indonesia Sembilan pada tanggal 30 Januari 2015. SIS bergerak di bidang manufaktur dan perdagangan rokok.
        </p>

        <p style="text-align: justify;">
            Sampoerna International Pte. Ltd. (SIP) adalah anak perusahaan Sampoerna yang didirikan pada tanggal 21 Februari 1995 dan bergerak di bidang investasi saham pada perusahaan-perusahaan lain di Singapura.
        </p>
    </div>
</div>

{{-- CSS untuk efek hover banner --}}
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
</style>
@endpush

@endsection

<?php

namespace App\Http\Controllers;

use App\Models\AuditModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

class AuditController extends Controller
{
    // Menampilkan halaman awal Audit user
    public function index(Request $request)
    {
        // ================= BREADCRUMB (BIAR LAYOUT AMAN) =================
        $breadcrumb = (object) [
            'title' => '',
            'list' => [],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Audit user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Audit';

        // ================= DATA AUDIT =================
        $data = [
            ['no' => '1.1.1', 'kriteria' => 'Terdapat kebijakan K3 yang tertulis, bertanggal, ditandatangani oleh pengusaha atau pengurus, serta menyatakan tujuan, sasaran, dan komitmen peningkatan K3', 'acuan' => 'PP 50/2012 – Sistem Manajemen K3'],
            ['no' => '1.1.2', 'kriteria' => 'Kebijakan K3 disusun oleh pengusaha dan/atau pengurus melalui proses konsultasi dengan wakil tenaga kerja', 'acuan' => 'PP 50/2012'],
            ['no' => '1.1.3', 'kriteria' => 'Perusahaan mengkomunikasikan kebijakan K3 kepada seluruh tenaga kerja, tamu, kontraktor, pelanggan, dan pemasok dengan tata cara yang tepat', 'acuan' => 'UU 1/1970 K3'],
            ['no' => '1.1.4', 'kriteria' => 'Kebijakan khusus dibuat untuk masalah K3 yang bersifat khusus', 'acuan' => ''],
            ['no' => '1.1.5', 'kriteria' => 'Kebijakan K3 dan kebijakan khusus ditinjau ulang secara berkala sesuai perubahan perusahaan dan peraturan perundang-undangan', 'acuan' => ''],

            ['no' => '1.2.1', 'kriteria' => 'Tanggung jawab dan wewenang untuk mengambil tindakan dan melaporkan K3 telah ditetapkan dan dikomunikasikan', 'acuan' => 'PP 50/2012'],
            ['no' => '1.2.2', 'kriteria' => 'Penunjukan penanggung jawab K3 sesuai dengan peraturan perundang-undangan', 'acuan' => ''],
            ['no' => '1.2.3', 'kriteria' => 'Pimpinan unit kerja bertanggung jawab atas kinerja K3 pada unit kerjanya', 'acuan' => ''],
            ['no' => '1.2.4', 'kriteria' => 'Pengusaha atau pengurus bertanggung jawab penuh atas pelaksanaan SMK3', 'acuan' => ''],
            ['no' => '1.2.5', 'kriteria' => 'Petugas penanganan keadaan darurat telah ditetapkan dan memperoleh pelatihan', 'acuan' => ''],
            ['no' => '1.2.6', 'kriteria' => 'Perusahaan memperoleh saran K3 dari ahli K3 dalam dan/atau luar perusahaan', 'acuan' => ''],
            ['no' => '1.2.7', 'kriteria' => 'Kinerja K3 dimuat dalam laporan tahunan perusahaan atau laporan setingkat', 'acuan' => ''],

            ['no' => '1.3.1', 'kriteria' => 'Tinjauan penerapan SMK3 meliputi kebijakan, perencanaan, pelaksanaan, pemantauan, dan evaluasi telah dilakukan serta didokumentasikan', 'acuan' => ''],
            ['no' => '1.3.2', 'kriteria' => 'Hasil tinjauan SMK3 dimasukkan dalam perencanaan tindakan manajemen', 'acuan' => ''],
            ['no' => '1.3.3', 'kriteria' => 'Pengurus meninjau ulang pelaksanaan SMK3 secara berkala untuk menilai kesesuaian dan efektivitas', 'acuan' => ''],

            ['no' => '1.4.1', 'kriteria' => 'Keterlibatan dan jadwal konsultasi tenaga kerja dengan wakil perusahaan didokumentasikan dan disosialisasikan', 'acuan' => ''],
            ['no' => '1.4.2', 'kriteria' => 'Terdapat prosedur untuk konsultasi terkait perubahan yang berdampak pada K3', 'acuan' => ''],
            ['no' => '1.4.3', 'kriteria' => 'Perusahaan membentuk P2K3 sesuai peraturan perundang-undangan', 'acuan' => 'Permenaker 04/1987 – P2K3'],
            ['no' => '1.4.4', 'kriteria' => 'Ketua P2K3 adalah pimpinan puncak atau pengurus', 'acuan' => ''],
            ['no' => '1.4.5', 'kriteria' => 'Sekretaris P2K3 adalah Ahli K3 sesuai peraturan perundang-undangan', 'acuan' => ''],
            ['no' => '1.4.6', 'kriteria' => 'Kegiatan P2K3 berfokus pada pengembangan kebijakan dan prosedur pengendalian risiko', 'acuan' => ''],
            ['no' => '1.4.7', 'kriteria' => 'Susunan pengurus P2K3 didokumentasikan dan diinformasikan kepada tenaga kerja', 'acuan' => ''],
            ['no' => '1.4.8', 'kriteria' => 'P2K3 mengadakan pertemuan secara berkala dan hasilnya disebarluaskan', 'acuan' => ''],
            ['no' => '1.4.9', 'kriteria' => 'P2K3 melaporkan kegiatannya secara rutin sesuai peraturan', 'acuan' => ''],
            ['no' => '1.4.10', 'kriteria' => 'Kelompok kerja K3 dibentuk dan anggotanya mendapatkan pelatihan sesuai peraturan', 'acuan' => ''],
            ['no' => '1.4.11', 'kriteria' => 'Susunan kelompok kerja K3 didokumentasikan dan diinformasikan kepada tenaga kerja', 'acuan' => ''],

            ['no' => '2.1.1', 'kriteria' => 'Terdapat prosedur terdokumentasi untuk identifikasi potensi bahaya, penilaian dan pengendalian risiko K3', 'acuan' => ''],
            ['no' => '2.1.2', 'kriteria' => 'Identifikasi potensi bahaya, penilaian, dan pengendalian risiko K3 dilakukan oleh petugas yang berkompeten', 'acuan' => ''],
            ['no' => '2.1.3', 'kriteria' => 'Rencana strategi K3 disusun berdasarkan tinjauan awal, identifikasi bahaya, penilaian risiko, pengendalian risiko dan peraturan perundang-undangan', 'acuan' => ''],
            ['no' => '2.1.4', 'kriteria' => 'Rencana strategi K3 digunakan untuk mengendalikan risiko K3 dengan menetapkan tujuan, sasaran terukur dan penyediaan sumber daya', 'acuan' => ''],
            ['no' => '2.1.5', 'kriteria' => 'Rencana kerja dan rencana khusus telah dibuat dengan tujuan terukur, waktu pencapaian dan penyediaan sumber daya', 'acuan' => ''],
            ['no' => '2.1.6', 'kriteria' => 'Rencana K3 diselaraskan dengan rencana sistem manajemen perusahaan', 'acuan' => ''],

            ['no' => '2.2.1', 'kriteria' => 'Manual SMK3 mencakup kebijakan, tujuan, rencana, prosedur, instruksi kerja, formulir, catatan, tanggung jawab dan wewenang K3', 'acuan' => ''],
            ['no' => '2.2.2', 'kriteria' => 'Terdapat manual khusus yang berkaitan dengan produk, proses, atau tempat kerja tertentu', 'acuan' => ''],
            ['no' => '2.2.3', 'kriteria' => 'Manual SMK3 mudah diakses oleh seluruh personil sesuai kebutuhan', 'acuan' => ''],

            ['no' => '2.3.1', 'kriteria' => 'Terdapat prosedur untuk mengidentifikasi dan memelihara peraturan, standar, pedoman dan persyaratan K3 yang relevan', 'acuan' => ''],
            ['no' => '2.3.2', 'kriteria' => 'Penanggung jawab pemeliharaan dan distribusi informasi peraturan K3 telah ditetapkan', 'acuan' => ''],
            ['no' => '2.3.3', 'kriteria' => 'Persyaratan peraturan K3 dimasukkan dalam prosedur dan petunjuk kerja', 'acuan' => ''],
            ['no' => '2.3.4', 'kriteria' => 'Perubahan peraturan K3 digunakan untuk meninjau prosedur dan petunjuk kerja', 'acuan' => ''],

            ['no' => '2.4.1', 'kriteria' => 'Informasi K3 disebarluaskan secara sistematis kepada tenaga kerja, tamu, kontraktor, pelanggan dan pemasok', 'acuan' => ''],

            ['no' => '3.1.1', 'kriteria' => 'Perancangan mempertimbangkan identifikasi bahaya, penilaian dan pengendalian risiko K3', 'acuan' => ''],
            ['no' => '3.1.2', 'kriteria' => 'Instruksi kerja dan informasi K3 dikembangkan selama perancangan atau modifikasi', 'acuan' => ''],
            ['no' => '3.1.3', 'kriteria' => 'Perancangan diverifikasi oleh petugas kompeten sebelum digunakan', 'acuan' => ''],
            ['no' => '3.1.4', 'kriteria' => 'Perubahan perancangan yang berdampak pada K3 ditinjau dan disetujui sebelum pelaksanaan', 'acuan' => ''],

            ['no' => '3.2.1', 'kriteria' => 'Prosedur kontrak mengidentifikasi bahaya dan menilai risiko K3', 'acuan' => ''],
            ['no' => '3.2.2', 'kriteria' => 'Identifikasi bahaya kontrak dilakukan oleh petugas berkompeten', 'acuan' => ''],
            ['no' => '3.2.3', 'kriteria' => 'Kontrak ditinjau ulang untuk menjamin pemenuhan persyaratan K3', 'acuan' => ''],
            ['no' => '3.2.4', 'kriteria' => 'Catatan tinjauan kontrak dipelihara dan didokumentasikan', 'acuan' => ''],

            ['no' => '4.1.1', 'kriteria' => 'Dokumen K3 memiliki identifikasi status, wewenang dan tanggal pengesahan', 'acuan' => ''],
            ['no' => '4.1.2', 'kriteria' => 'Distribusi dokumen tercantum dalam dokumen', 'acuan' => ''],
            ['no' => '4.1.3', 'kriteria' => 'Dokumen K3 terbaru disimpan secara sistematis', 'acuan' => ''],
            ['no' => '4.1.4', 'kriteria' => 'Dokumen usang ditarik dari peredaran dan diberi tanda khusus', 'acuan' => ''],

            ['no' => '4.2.1', 'kriteria' => 'Terdapat sistem persetujuan perubahan dokumen K3', 'acuan' => ''],
            ['no' => '4.2.2', 'kriteria' => 'Setiap perubahan dokumen dijelaskan alasannya dan diinformasikan', 'acuan' => ''],
            ['no' => '4.2.3', 'kriteria' => 'Terdapat daftar pengendalian dokumen untuk mencegah penggunaan dokumen usang', 'acuan' => ''],

            ['no' => '5.1.1', 'kriteria' => 'Spesifikasi pembelian menjamin persyaratan K3 telah diperiksa', 'acuan' => ''],
            ['no' => '5.1.2', 'kriteria' => 'Spesifikasi pembelian sesuai peraturan dan standar K3', 'acuan' => ''],
            ['no' => '5.1.3', 'kriteria' => 'Tenaga kerja berkompeten dilibatkan dalam keputusan pembelian', 'acuan' => ''],
            ['no' => '5.1.4', 'kriteria' => 'Kebutuhan pelatihan dan APD dipertimbangkan sebelum pembelian', 'acuan' => ''],
            ['no' => '5.1.5', 'kriteria' => 'Persyaratan K3 menjadi pertimbangan seleksi vendor', 'acuan' => ''],

            ['no' => '5.2.1', 'kriteria' => 'Barang dan jasa yang dibeli diverifikasi sesuai spesifikasi', 'acuan' => ''],

            ['no' => '5.4.1', 'kriteria' => 'Produk dapat ditelusuri pada seluruh tahapan produksi bila terdapat potensi K3', 'acuan' => ''],
            ['no' => '5.4.2', 'kriteria' => 'Terdapat prosedur penelusuran produk yang telah dijual', 'acuan' => ''],

            ['no' => '6.1.1', 'kriteria' => 'Bahaya kerja diidentifikasi dan risiko dikendalikan oleh petugas kompeten', 'acuan' => ''],
            ['no' => '6.1.2', 'kriteria' => 'Pengendalian risiko ditetapkan sesuai tingkat bahaya', 'acuan' => ''],
            ['no' => '6.1.3', 'kriteria' => 'Terdapat prosedur kerja terdokumentasi untuk pengendalian risiko', 'acuan' => ''],
            ['no' => '6.1.4', 'kriteria' => 'Pengembangan prosedur memperhatikan peraturan dan standar K3', 'acuan' => ''],
            ['no' => '6.1.5', 'kriteria' => 'Terdapat sistem izin kerja untuk pekerjaan berisiko tinggi', 'acuan' => ''],
            ['no' => '6.1.6', 'kriteria' => 'APD disediakan dan digunakan dengan benar', 'acuan' => ''],
            ['no' => '6.1.7', 'kriteria' => 'APD memenuhi standar dan peraturan yang berlaku', 'acuan' => ''],
            ['no' => '6.1.8', 'kriteria' => 'Pengendalian risiko dievaluasi secara berkala', 'acuan' => ''],

            ['no' => '6.2.1', 'kriteria' => 'Pengawasan dilakukan untuk memastikan pekerjaan aman dan sesuai prosedur', 'acuan' => ''],
            ['no' => '6.2.2', 'kriteria' => 'Pengawasan disesuaikan dengan tingkat risiko pekerjaan', 'acuan' => ''],
            ['no' => '6.2.4', 'kriteria' => 'Pengawas ikut serta dalam penyelidikan kecelakaan kerja', 'acuan' => ''],
            ['no' => '6.2.5', 'kriteria' => 'Pengawas terlibat dalam proses konsultasi K3', 'acuan' => ''],

            ['no' => '6.3.1', 'kriteria' => 'Persyaratan tugas dan kesehatan digunakan untuk seleksi dan penempatan tenaga kerja', 'acuan' => ''],
            ['no' => '6.3.2', 'kriteria' => 'Penugasan kerja berdasarkan kemampuan dan kewenangan tenaga kerja', 'acuan' => ''],

            ['no' => '6.4.1', 'kriteria' => 'Penilaian risiko dilakukan untuk menentukan area terbatas', 'acuan' => ''],
            ['no' => '6.4.2', 'kriteria' => 'Area terbatas dikendalikan dengan sistem izin masuk', 'acuan' => ''],
            ['no' => '6.4.3', 'kriteria' => 'Fasilitas kerja sesuai standar K3 tersedia', 'acuan' => ''],
            ['no' => '6.4.4', 'kriteria' => 'Rambu-rambu K3 dipasang sesuai standar', 'acuan' => ''],

            ['no' => '6.5.1', 'kriteria' => 'Pemeriksaan dan pemeliharaan sarana produksi dijadwalkan', 'acuan' => ''],
            ['no' => '6.5.2', 'kriteria' => 'Catatan pemeliharaan dan perbaikan disimpan dengan baik', 'acuan' => ''],
            ['no' => '6.5.3', 'kriteria' => 'Sarana produksi memiliki sertifikat yang berlaku', 'acuan' => ''],
            ['no' => '6.5.4', 'kriteria' => 'Pemeliharaan dilakukan oleh petugas berwenang', 'acuan' => ''],
            ['no' => '6.5.7', 'kriteria' => 'Peralatan tidak aman diberi tanda khusus', 'acuan' => ''],
            ['no' => '6.5.8', 'kriteria' => 'Lock out system diterapkan bila diperlukan', 'acuan' => ''],
            ['no' => '6.5.9', 'kriteria' => 'Prosedur keselamatan selama perawatan diterapkan', 'acuan' => ''],
            ['no' => '6.5.10', 'kriteria' => 'Penanggung jawab menyetujui kelayakan peralatan pasca pemeliharaan', 'acuan' => ''],

            ['no' => '6.6.1', 'kriteria' => 'Pelayanan jasa memenuhi standar dan peraturan K3', 'acuan' => ''],
            ['no' => '6.6.2', 'kriteria' => 'Pelayanan yang diterima melalui kontrak memenuhi persyaratan K3', 'acuan' => ''],

            ['no' => '6.7.1', 'kriteria' => 'Keadaan darurat diidentifikasi dan prosedur terdokumentasi', 'acuan' => ''],
            ['no' => '6.7.2', 'kriteria' => 'Sarana darurat disseuaikan hasil identifikasi risiko', 'acuan' => ''],
            ['no' => '6.7.3', 'kriteria' => 'Tenaga kerja dilatih prosedur keadaan darurat', 'acuan' => ''],
            ['no' => '6.7.4', 'kriteria' => 'Petugas darurat ditetapkan dan dilatih', 'acuan' => ''],
            ['no' => '6.7.6', 'kriteria' => 'Peralatan darurat diperiksa dan dipelihara', 'acuan' => ''],
            ['no' => '6.7.7', 'kriteria' => 'Jumlah dan penempatan alat darurat sesuai standar', 'acuan' => ''],

            ['no' => '6.8.1', 'kriteria' => 'Sistem P3K dievaluasi sesuai peraturan', 'acuan' => ''],
            ['no' => '6.8.2', 'kriteria' => 'Petugas P3K dilatih dan ditunjuk resmi', 'acuan' => ''],

            ['no' => '6.9.1', 'kriteria' => 'Prosedur pemulihan pasca kecelakaan ditetapkan', 'acuan' => ''],

            ['no' => '7.1.1', 'kriteria' => 'Inspeksi tempat kerja dilakukan secara berkala', 'acuan' => ''],
            ['no' => '7.1.2', 'kriteria' => 'Pemeriksaan dilakukan oleh petugas berkompeten', 'acuan' => ''],
            ['no' => '7.1.3', 'kriteria' => 'Masukan tenaga kerja digunakan dalam inspeksi', 'acuan' => ''],
            ['no' => '7.1.4', 'kriteria' => 'Checklist inspeksi disusun dan digunakan', 'acuan' => ''],
            ['no' => '7.1.5', 'kriteria' => 'Laporan inspeksi memuat rekomendasi perbaikan', 'acuan' => ''],
            ['no' => '7.1.6', 'kriteria' => 'Penanggung jawab tindakan perbaikan ditetapkan', 'acuan' => ''],

            ['no' => '7.2.1', 'kriteria' => 'Pemantauan lingkungan kerja dilakukan dan didokumentasikan', 'acuan' => ''],
            ['no' => '7.2.2', 'kriteria' => 'Pemantauan mencakup faktor fisik, kimia, biologi, ergonomi dan psikologi', 'acuan' => ''],
            ['no' => '7.2.3', 'kriteria' => 'Pemantauan dilakukan oleh petugas berwenang', 'acuan' => ''],

            ['no' => '7.3.1', 'kriteria' => 'Terdapat prosedur kalibrasi dan pemeliharaan alat ukur K3', 'acuan' => ''],
            ['no' => '7.3.2', 'kriteria' => 'Alat ukur dipelihara oleh petugas kompeten', 'acuan' => ''],

            ['no' => '7.4.1', 'kriteria' => 'Pemantauan kesehatan tenaga kerja berisiko tinggi dilakukan', 'acuan' => ''],
            ['no' => '7.4.2', 'kriteria' => 'Sistem pemeriksaan kesehatan tenaga kerja diterapkan', 'acuan' => ''],
            ['no' => '7.4.3', 'kriteria' => 'Pemeriksaan kesehatan dilakukan dokter yang ditunjuk', 'acuan' => ''],
            ['no' => '7.4.4', 'kriteria' => 'Pelayanan kesehatan kerja disediakan', 'acuan' => ''],
            ['no' => '7.4.5', 'kriteria' => 'Catatan kesehatan tenaga kerja disimpan', 'acuan' => ''],

            ['no' => '8.1.1', 'kriteria' => 'Terdapat prosedur pelaporan bahaya K3', 'acuan' => ''],

            ['no' => '8.3.1', 'kriteria' => 'Terdapat prosedur pemeriksaan kecelakaan kerja', 'acuan' => ''],
            ['no' => '8.3.2', 'kriteria' => 'Investigasi kecelakaan dilakukan oleh petugas berkompeten', 'acuan' => ''],
            ['no' => '8.3.3', 'kriteria' => 'Laporan kecelakaan memuat sebab, akibat dan rekomendasi', 'acuan' => ''],
            ['no' => '8.3.4', 'kriteria' => 'Penanggung jawab tindakan perbaikan ditetapkan', 'acuan' => ''],
            ['no' => '8.3.5', 'kriteria' => 'Hasil investigasi diinformasikan kepada tenaga kerja', 'acuan' => ''],
            ['no' => '8.3.6', 'kriteria' => 'Tindakan perbaikan dipantau dan didokumentasikan', 'acuan' => ''],

            ['no' => '8.4.1', 'kriteria' => 'Prosedur penanganan masalah K3 diterapkan', 'acuan' => ''],

            ['no' => '9.1.1', 'kriteria' => 'Risiko penanganan manual dan mekanis diidentifikasi', 'acuan' => ''],
            ['no' => '9.1.2', 'kriteria' => 'Risiko ditangani oleh petugas berkompeten', 'acuan' => ''],
            ['no' => '9.1.3', 'kriteria' => 'Pengendalian risiko manual dan mekanis diterapkan', 'acuan' => ''],
            ['no' => '9.1.4', 'kriteria' => 'Prosedur penanganan tumpahan dan kebocoran diterapkan', 'acuan' => ''],

            ['no' => '9.2.1', 'kriteria' => 'Bahan disimpan dan dipindahkan secara aman', 'acuan' => ''],
            ['no' => '9.2.3', 'kriteria' => 'Bahan dibuang sesuai peraturan', 'acuan' => ''],

            ['no' => '9.3.1', 'kriteria' => 'Prosedur pengendalian bahan kimia berbahaya diterapkan', 'acuan' => ''],
            ['no' => '9.3.2', 'kriteria' => 'MSDS tersedia dan mudah diakses', 'acuan' => ''],
            ['no' => '9.3.3', 'kriteria' => 'Bahan kimia berbahaya diberi label jelas', 'acuan' => ''],
            ['no' => '9.3.4', 'kriteria' => 'Rambu bahaya bahan kimia terpasang', 'acuan' => ''],
            ['no' => '9.3.5', 'kriteria' => 'Penanganan BKB dilakukan petugas berkompeten', 'acuan' => ''],

            ['no' => '10.1.1', 'kriteria' => 'Prosedur pengelolaan catatan K3 diterapkan', 'acuan' => ''],
            ['no' => '10.1.2', 'kriteria' => 'Standar dan peraturan K3 mudah diakses', 'acuan' => ''],
            ['no' => '10.1.3', 'kriteria' => 'Kerahasiaan catatan K3 dijaga', 'acuan' => ''],
            ['no' => '10.1.4', 'kriteria' => 'Catatan kompensasi kecelakaan disimpan', 'acuan' => ''],

            ['no' => '10.2.1', 'kriteria' => 'Data K3 dianalisis secara berkala', 'acuan' => ''],
            ['no' => '10.2.2', 'kriteria' => 'Laporan kinerja K3 disebarluaskan', 'acuan' => ''],

            ['no' => '11.1.1', 'kriteria' => 'Audit internal SMK3 dilakukan terjadwal', 'acuan' => ''],
            ['no' => '11.1.3', 'kriteria' => 'Laporan audit didistribusikan dan dipantau tindak lanjutnya', 'acuan' => ''],

            ['no' => '12.1.1', 'kriteria' => 'Analisis kebutuhan pelatihan K3 dilakukan', 'acuan' => ''],
            ['no' => '12.1.2', 'kriteria' => 'Rencana pelatihan K3 disusun', 'acuan' => ''],
            ['no' => '12.1.3', 'kriteria' => 'Jenis pelatihan disesuaikan kebutuhan pengendalian bahaya', 'acuan' => ''],
            ['no' => '12.1.4', 'kriteria' => 'Pelatihan dilakukan oleh pihak berkompeten', 'acuan' => ''],
            ['no' => '12.1.5', 'kriteria' => 'Fasilitas pelatihan tersedia', 'acuan' => ''],
            ['no' => '12.1.6', 'kriteria' => 'Catatan pelatihan disimpan', 'acuan' => ''],
            ['no' => '12.1.7', 'kriteria' => 'Program pelatihan ditinjau secara berkala', 'acuan' => ''],

            ['no' => '12.2.1', 'kriteria' => 'Manajemen mengikuti pelatihan kewajiban hukum dan prinsip K3', 'acuan' => ''],
            ['no' => '12.2.2', 'kriteria' => 'Pengawas menerima pelatihan sesuai tanggung jawab', 'acuan' => ''],

            ['no' => '12.3.1', 'kriteria' => 'Tenaga kerja menerima pelatihan K3', 'acuan' => ''],
            ['no' => '12.3.2', 'kriteria' => 'Pelatihan diberikan bila terjadi perubahan proses', 'acuan' => ''],
            ['no' => '12.3.3', 'kriteria' => 'Pelatihan penyegaran diberikan secara berkala', 'acuan' => ''],

            ['no' => '12.4.1', 'kriteria' => 'Pengunjung dan kontraktor menerima briefing K3', 'acuan' => ''],

            ['no' => '12.5.1', 'kriteria' => 'Perusahaan mempunyai sistem yang menjamin kepatuhan terhadap persyaratan lisensi atau kualifikasi sesuai dengan peraturan perundangan untuk melaksanakan tugas khusus, melaksanakan pekerjaan atau mengoperasikan peralatan.', 'acuan' => ''],

        ];

        // ================= PAGINATION =================
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $currentItems = array_slice(
            $data,
            ($currentPage - 1) * $perPage,
            $perPage
        );

        $paginatedData = new LengthAwarePaginator(
            $currentItems,
            count($data),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        );

        // ================= RETURN VIEW =================
        return view('Audit.index', compact(
            'breadcrumb',
            'page',
            'activeMenu',
            'paginatedData'
        ));
    }

    // Ambil data Audit user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $Audit = AuditModel::select('Audit_id', 'Audit_kode', 'Audit_nama');

        // filter data user berdasarkan Audit_id
        if ($request->Audit_id) {
            $Audit->where('Audit_id', $request->Audit_id);
        };


        return DataTables::of($Audit)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($Audit) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/Audit/' . $Audit->Audit_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/Audit/' . $Audit->Audit_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/Audit/'.$Audit->Audit_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/Audit/' . $Audit->Audit_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Audit/' . $Audit->Audit_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Audit/' . $Audit->Audit_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Audit user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Audit User',
            'list' => ['Home', 'Audit', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Audit user baru'
        ];

        $Audit = AuditModel::all();
        $activeMenu = 'Audit'; // set menu yang sedang aktif

        return view('Audit.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Audit' => $Audit, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data Audit user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Audit kolom Audit_kode dan Audit_nama
            'Audit_kode' => 'required|string|unique:m_Audit,Audit_kode',
            'Audit_nama' => 'required|string'
        ]);

        AuditModel::create([
            'Audit_kode' => $request->Audit_kode,
            'Audit_name' => $request->Audit_name
        ]);

        return redirect('/Audit')->with('success', 'Data Audit berhasil disimpan');
    }


    // Menampilkan detail Audit user

    public function show(string $id)
    {
        $Audit = AuditModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Audit',
            'list' => ['Home', 'Audit', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Audit'
        ];

        $activeMenu = 'Audit'; // set menu yang sedang aktif

        return view('Audit.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Audit' => $Audit, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Audit user

    public function edit(string $id)
    {
        $Audit = AuditModel::find($id);
        $allAudit = AuditModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Audit',
            'list' => ['Home', 'Audit', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Audit'
        ];

        $activeMenu = 'Audit'; // set menu yang sedang aktif

        return view('Audit.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Audit' => $Audit, 'allAudit' => $allAudit, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data Audit user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Audit_kode' => 'required|string|unique:m_Audit,Audit_kode,' . $id . ',Audit_id',
            'Audit_name' => 'required|string'
        ]);

        $Audit = AuditModel::findOrFail($id);
        $Audit->update([

            'Audit_kode' => $request->Audit_kode,
            'Audit_name' => $request->Audit_name
        ]);

        return redirect('/Audit')->with('success', 'Data Audit berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('Audit.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Audit_kode' => 'required|string|min:3|max:20|unique:m_Audit,Audit_kode',
                'Audit_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            AuditModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Audit berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $Audit = AuditModel::find($id);

        return view('Audit.edit_ajax', ['Audit' => $Audit]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Audit_kode' => 'required|string|min:3|max:20|unique:m_Audit,Audit_kode,' . $id . ',Audit_id',
                'Audit_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = AuditModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Audit berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $Audit = AuditModel::find($id);

        return view('Audit.confirm_ajax', ['Audit' => $Audit]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $Audit = AuditModel::find($id);
            if ($Audit) {
                $Audit->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Audit berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    // Menghapus data Audit user
    public function destroy(string $id)
    {
        $Audit = AuditModel::find($id);
        if (!$Audit) { // untuk mengecek apakah data Audit user dengan id yang dimaksud ada atau tidak
            return redirect('/Audit')->with('error', 'Data Audit tidak ditemukan');
        }

        try {
            AuditModel::destroy($id); // Hapus data Audit user
            return redirect('/Audit')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/Audit')->with('error', 'Data Audit gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('Audit.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_Audit' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_Audit');

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'Audit_kode' => $value['A'],
                            'Audit_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    AuditModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data Audit berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        $Audit = AuditModel::select('Audit_kode', 'Audit_nama')
            ->orderBy('Audit_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'no');
        $sheet->setCellValue('B1', 'Kode Audit');
        $sheet->setCellValue('C1', 'Nama Audit');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($Audit as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->Audit_kode);
            $sheet->setCellValue('C' . $baris, $value->Audit_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Audit');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Audit ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $Audit = AuditModel::select('Audit_kode', 'Audit_nama')
            ->orderBy('Audit_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('Audit.export_pdf', ['Audit' => $Audit]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Audit ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

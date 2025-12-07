<?php

namespace App\Http\Controllers;

use App\Models\informasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class InformasiController extends Controller
{
    // Menampilkan halaman awal informasi user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar informasi user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'informasi'; // set menu yang sedang aktif

        return view('informasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data informasi user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $informasi = informasiModel::select('informasi_id', 'informasi_kode', 'informasi_nama');

        // filter data user berdasarkan informasi_id
        if ($request->informasi_id) {
            $informasi->where('informasi_id', $request->informasi_id);
        };


        return DataTables::of($informasi)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($informasi) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/informasi/' . $informasi->informasi_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/informasi/' . $informasi->informasi_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/informasi/'.$informasi->informasi_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/informasi/' . $informasi->informasi_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/informasi/' . $informasi->informasi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/informasi/' . $informasi->informasi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah informasi user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah informasi User',
            'list' => ['Home', 'informasi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah informasi user baru'
        ];

        $informasi = informasiModel::all();
        $activeMenu = 'informasi'; // set menu yang sedang aktif

        return view('informasi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'informasi' => $informasi, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data informasi user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_informasi kolom informasi_kode dan informasi_nama
            'informasi_kode' => 'required|string|unique:m_informasi,informasi_kode',
            'informasi_nama' => 'required|string'
        ]);

        informasiModel::create([
            'informasi_kode' => $request->informasi_kode,
            'informasi_name' => $request->informasi_name
        ]);

        return redirect('/informasi')->with('success', 'Data informasi berhasil disimpan');
    }


    // Menampilkan detail informasi user

    public function show(string $id)
    {
        $informasi = informasiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail informasi',
            'list' => ['Home', 'informasi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail informasi'
        ];

        $activeMenu = 'informasi'; // set menu yang sedang aktif

        return view('informasi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'informasi' => $informasi, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit informasi user

    public function edit(string $id)
    {
        $informasi = informasiModel::find($id);
        $allinformasi = informasiModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit informasi',
            'list' => ['Home', 'informasi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit informasi'
        ];

        $activeMenu = 'informasi'; // set menu yang sedang aktif

        return view('informasi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'informasi' => $informasi, 'allinformasi' => $allinformasi, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data informasi user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'informasi_kode' => 'required|string|unique:m_informasi,informasi_kode,' . $id . ',informasi_id',
            'informasi_name' => 'required|string'
        ]);

        $informasi = informasiModel::findOrFail($id);
        $informasi->update([

            'informasi_kode' => $request->informasi_kode,
            'informasi_name' => $request->informasi_name
        ]);

        return redirect('/informasi')->with('success', 'Data informasi berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('informasi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'informasi_kode' => 'required|string|min:3|max:20|unique:m_informasi,informasi_kode',
                'informasi_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            informasiModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data informasi berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $informasi = informasiModel::find($id);

        return view('informasi.edit_ajax', ['informasi' => $informasi]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'informasi_kode' => 'required|string|min:3|max:20|unique:m_informasi,informasi_kode,' . $id . ',informasi_id',
                'informasi_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = informasiModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data informasi berhasil diupdate'
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
        $informasi = informasiModel::find($id);

        return view('informasi.confirm_ajax', ['informasi' => $informasi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $informasi = informasiModel::find($id);
            if ($informasi) {
                $informasi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data informasi berhasil dihapus'
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

    // Menghapus data informasi user
    public function destroy(string $id)
    {
        $informasi = informasiModel::find($id);
        if (!$informasi) { // untuk mengecek apakah data informasi user dengan id yang dimaksud ada atau tidak
            return redirect('/informasi')->with('error', 'Data informasi tidak ditemukan');
        }

        try {
            informasiModel::destroy($id); // Hapus data informasi user
            return redirect('/informasi')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/informasi')->with('error', 'Data informasi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('informasi.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_informasi' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_informasi');

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
                            'informasi_kode' => $value['A'],
                            'informasi_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    informasiModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data informasi berhasil diimport'
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
        $informasi = informasiModel::select('informasi_kode', 'informasi_nama')
            ->orderBy('informasi_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode informasi');
        $sheet->setCellValue('C1', 'Nama informasi');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($informasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->informasi_kode);
            $sheet->setCellValue('C' . $baris, $value->informasi_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data informasi');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data informasi ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $informasi = informasiModel::select('informasi_kode', 'informasi_nama')
            ->orderBy('informasi_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('informasi.export_pdf', ['informasi' => $informasi]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data informasi ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

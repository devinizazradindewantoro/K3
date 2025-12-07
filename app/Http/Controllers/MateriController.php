<?php

namespace App\Http\Controllers;

use App\Models\MateriModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class MateriController extends Controller
{
    // Menampilkan halaman awal Materi user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Materi user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Materi'; // set menu yang sedang aktif

        return view('Materi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Materi user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $Materi = MateriModel::select('Materi_id', 'Materi_kode', 'Materi_nama');

        // filter data user berdasarkan Materi_id
        if ($request->Materi_id) {
            $Materi->where('Materi_id', $request->Materi_id);
        };


        return DataTables::of($Materi)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($Materi) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/Materi/' . $Materi->Materi_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/Materi/' . $Materi->Materi_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/Materi/'.$Materi->Materi_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/Materi/' . $Materi->Materi_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Materi/' . $Materi->Materi_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Materi/' . $Materi->Materi_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Materi user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Materi User',
            'list' => ['Home', 'Materi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Materi user baru'
        ];

        $Materi = MateriModel::all();
        $activeMenu = 'Materi'; // set menu yang sedang aktif

        return view('Materi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Materi' => $Materi, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data Materi user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Materi kolom Materi_kode dan Materi_nama
            'Materi_kode' => 'required|string|unique:m_Materi,Materi_kode',
            'Materi_nama' => 'required|string'
        ]);

        MateriModel::create([
            'Materi_kode' => $request->Materi_kode,
            'Materi_name' => $request->Materi_name
        ]);

        return redirect('/Materi')->with('success', 'Data Materi berhasil disimpan');
    }


    // Menampilkan detail Materi user

    public function show(string $id)
    {
        $Materi = MateriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Materi',
            'list' => ['Home', 'Materi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Materi'
        ];

        $activeMenu = 'Materi'; // set menu yang sedang aktif

        return view('Materi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Materi' => $Materi, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Materi user

    public function edit(string $id)
    {
        $Materi = MateriModel::find($id);
        $allMateri = MateriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Materi',
            'list' => ['Home', 'Materi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Materi'
        ];

        $activeMenu = 'Materi'; // set menu yang sedang aktif

        return view('Materi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Materi' => $Materi, 'allMateri' => $allMateri, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data Materi user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Materi_kode' => 'required|string|unique:m_Materi,Materi_kode,' . $id . ',Materi_id',
            'Materi_name' => 'required|string'
        ]);

        $Materi = MateriModel::findOrFail($id);
        $Materi->update([

            'Materi_kode' => $request->Materi_kode,
            'Materi_name' => $request->Materi_name
        ]);

        return redirect('/Materi')->with('success', 'Data Materi berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('Materi.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Materi_kode' => 'required|string|min:3|max:20|unique:m_Materi,Materi_kode',
                'Materi_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            MateriModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Materi berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $Materi = MateriModel::find($id);

        return view('Materi.edit_ajax', ['Materi' => $Materi]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Materi_kode' => 'required|string|min:3|max:20|unique:m_Materi,Materi_kode,' . $id . ',Materi_id',
                'Materi_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = MateriModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Materi berhasil diupdate'
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
        $Materi = MateriModel::find($id);

        return view('Materi.confirm_ajax', ['Materi' => $Materi]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $Materi = MateriModel::find($id);
            if ($Materi) {
                $Materi->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Materi berhasil dihapus'
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

    // Menghapus data Materi user
    public function destroy(string $id)
    {
        $Materi = MateriModel::find($id);
        if (!$Materi) { // untuk mengecek apakah data Materi user dengan id yang dimaksud ada atau tidak
            return redirect('/Materi')->with('error', 'Data Materi tidak ditemukan');
        }

        try {
            MateriModel::destroy($id); // Hapus data Materi user
            return redirect('/Materi')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/Materi')->with('error', 'Data Materi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('Materi.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_Materi' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_Materi');

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
                            'Materi_kode' => $value['A'],
                            'Materi_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    MateriModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data Materi berhasil diimport'
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
        $Materi = MateriModel::select('Materi_kode', 'Materi_nama')
            ->orderBy('Materi_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Materi');
        $sheet->setCellValue('C1', 'Nama Materi');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($Materi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->Materi_kode);
            $sheet->setCellValue('C' . $baris, $value->Materi_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Materi');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Materi ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $Materi = MateriModel::select('Materi_kode', 'Materi_nama')
            ->orderBy('Materi_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('Materi.export_pdf', ['Materi' => $Materi]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Materi ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

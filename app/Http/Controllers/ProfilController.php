<?php

namespace App\Http\Controllers;

use App\Models\profilModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfilController extends Controller
{
    // Menampilkan halaman awal profil user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar profil user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'profil'; // set menu yang sedang aktif

        return view('profil.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data profil user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $profil = profilModel::select('profil_id', 'profil_kode', 'profil_nama');

        // filter data user berdasarkan profil_id
        if ($request->profil_id) {
            $profil->where('profil_id', $request->profil_id);
        };


        return DataTables::of($profil)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($profil) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/profil/' . $profil->profil_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/profil/' . $profil->profil_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/profil/'.$profil->profil_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/profil/' . $profil->profil_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/profil/' . $profil->profil_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/profil/' . $profil->profil_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah profil user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah profil User',
            'list' => ['Home', 'profil', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah profil user baru'
        ];

        $profil = profilModel::all();
        $activeMenu = 'profil'; // set menu yang sedang aktif

        return view('profil.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'profil' => $profil, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data profil user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_profil kolom profil_kode dan profil_nama
            'profil_kode' => 'required|string|unique:m_profil,profil_kode',
            'profil_nama' => 'required|string'
        ]);

        profilModel::create([
            'profil_kode' => $request->profil_kode,
            'profil_name' => $request->profil_name
        ]);

        return redirect('/profil')->with('success', 'Data profil berhasil disimpan');
    }


    // Menampilkan detail profil user

    public function show(string $id)
    {
        $profil = profilModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail profil',
            'list' => ['Home', 'profil', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail profil'
        ];

        $activeMenu = 'profil'; // set menu yang sedang aktif

        return view('profil.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'profil' => $profil, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit profil user

    public function edit(string $id)
    {
        $profil = profilModel::find($id);
        $allProfil = profilModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit profil',
            'list' => ['Home', 'profil', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit profil'
        ];

        $activeMenu = 'profil'; // set menu yang sedang aktif

        return view('profil.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'profil' => $profil, 'allProfil' => $allProfil, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data profil user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'profil_kode' => 'required|string|unique:m_profil,profil_kode,' . $id . ',profil_id',
            'profil_name' => 'required|string'
        ]);

        $profil = profilModel::findOrFail($id);
        $profil->update([

            'profil_kode' => $request->profil_kode,
            'profil_name' => $request->profil_name
        ]);

        return redirect('/profil')->with('success', 'Data profil berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('profil.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'profil_kode' => 'required|string|min:3|max:20|unique:m_profil,profil_kode',
                'profil_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            profilModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data profil berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $profil = profilModel::find($id);

        return view('profil.edit_ajax', ['profil' => $profil]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'profil_kode' => 'required|string|min:3|max:20|unique:m_profil,profil_kode,' . $id . ',profil_id',
                'profil_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = profilModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data profil berhasil diupdate'
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
        $profil = profilModel::find($id);

        return view('profil.confirm_ajax', ['profil' => $profil]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $profil = profilModel::find($id);
            if ($profil) {
                $profil->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data profil berhasil dihapus'
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

    // Menghapus data profil user
    public function destroy(string $id)
    {
        $profil = profilModel::find($id);
        if (!$profil) { // untuk mengecek apakah data profil user dengan id yang dimaksud ada atau tidak
            return redirect('/profil')->with('error', 'Data profil tidak ditemukan');
        }

        try {
            profilModel::destroy($id); // Hapus data profil user
            return redirect('/profil')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/profil')->with('error', 'Data profil gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('profil.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_profil' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_profil');

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
                            'profil_kode' => $value['A'],
                            'profil_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    profilModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data profil berhasil diimport'
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
        $profil = profilModel::select('profil_kode', 'profil_nama')
            ->orderBy('profil_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode profil');
        $sheet->setCellValue('C1', 'Nama profil');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($profil as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->profil_kode);
            $sheet->setCellValue('C' . $baris, $value->profil_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data profil');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data profil ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $profil = profilModel::select('profil_kode', 'profil_nama')
            ->orderBy('profil_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('profil.export_pdf', ['profil' => $profil]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data profil ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

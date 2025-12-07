<?php

namespace App\Http\Controllers;

use App\Models\ProsedurModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ProsedurController extends Controller
{
    // Menampilkan halaman awal Prosedur user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Prosedur user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Prosedur'; // set menu yang sedang aktif

        return view('Prosedur.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Prosedur user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $Prosedur = ProsedurModel::select('Prosedur_id', 'Prosedur_kode', 'Prosedur_nama');

        // filter data user berdasarkan Prosedur_id
        if ($request->Prosedur_id) {
            $Prosedur->where('Prosedur_id', $request->Prosedur_id);
        };


        return DataTables::of($Prosedur)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($Prosedur) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/Prosedur/' . $Prosedur->Prosedur_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/Prosedur/' . $Prosedur->Prosedur_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/Prosedur/'.$Prosedur->Prosedur_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/Prosedur/' . $Prosedur->Prosedur_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Prosedur/' . $Prosedur->Prosedur_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Prosedur/' . $Prosedur->Prosedur_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Prosedur user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Prosedur User',
            'list' => ['Home', 'Prosedur', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Prosedur user baru'
        ];

        $Prosedur = ProsedurModel::all();
        $activeMenu = 'Prosedur'; // set menu yang sedang aktif

        return view('Prosedur.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Prosedur' => $Prosedur, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data Prosedur user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Prosedur kolom Prosedur_kode dan Prosedur_nama
            'Prosedur_kode' => 'required|string|unique:m_Prosedur,Prosedur_kode',
            'Prosedur_nama' => 'required|string'
        ]);

        ProsedurModel::create([
            'Prosedur_kode' => $request->Prosedur_kode,
            'Prosedur_name' => $request->Prosedur_name
        ]);

        return redirect('/Prosedur')->with('success', 'Data Prosedur berhasil disimpan');
    }


    // Menampilkan detail Prosedur user

    public function show(string $id)
    {
        $Prosedur = ProsedurModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Prosedur',
            'list' => ['Home', 'Prosedur', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Prosedur'
        ];

        $activeMenu = 'Prosedur'; // set menu yang sedang aktif

        return view('Prosedur.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Prosedur' => $Prosedur, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Prosedur user

    public function edit(string $id)
    {
        $Prosedur = ProsedurModel::find($id);
        $allProsedur = ProsedurModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Prosedur',
            'list' => ['Home', 'Prosedur', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Prosedur'
        ];

        $activeMenu = 'Prosedur'; // set menu yang sedang aktif

        return view('Prosedur.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Prosedur' => $Prosedur, 'allProsedur' => $allProsedur, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data Prosedur user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Prosedur_kode' => 'required|string|unique:m_Prosedur,Prosedur_kode,' . $id . ',Prosedur_id',
            'Prosedur_name' => 'required|string'
        ]);

        $Prosedur = ProsedurModel::findOrFail($id);
        $Prosedur->update([

            'Prosedur_kode' => $request->Prosedur_kode,
            'Prosedur_name' => $request->Prosedur_name
        ]);

        return redirect('/Prosedur')->with('success', 'Data Prosedur berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('Prosedur.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Prosedur_kode' => 'required|string|min:3|max:20|unique:m_Prosedur,Prosedur_kode',
                'Prosedur_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            ProsedurModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Prosedur berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $Prosedur = ProsedurModel::find($id);

        return view('Prosedur.edit_ajax', ['Prosedur' => $Prosedur]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Prosedur_kode' => 'required|string|min:3|max:20|unique:m_Prosedur,Prosedur_kode,' . $id . ',Prosedur_id',
                'Prosedur_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = ProsedurModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Prosedur berhasil diupdate'
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
        $Prosedur = ProsedurModel::find($id);

        return view('Prosedur.confirm_ajax', ['Prosedur' => $Prosedur]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $Prosedur = ProsedurModel::find($id);
            if ($Prosedur) {
                $Prosedur->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Prosedur berhasil dihapus'
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

    // Menghapus data Prosedur user
    public function destroy(string $id)
    {
        $Prosedur = ProsedurModel::find($id);
        if (!$Prosedur) { // untuk mengecek apakah data Prosedur user dengan id yang dimaksud ada atau tidak
            return redirect('/Prosedur')->with('error', 'Data Prosedur tidak ditemukan');
        }

        try {
            ProsedurModel::destroy($id); // Hapus data Prosedur user
            return redirect('/Prosedur')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/Prosedur')->with('error', 'Data Prosedur gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('Prosedur.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_Prosedur' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_Prosedur');

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
                            'Prosedur_kode' => $value['A'],
                            'Prosedur_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    ProsedurModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data Prosedur berhasil diimport'
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
        $Prosedur = ProsedurModel::select('Prosedur_kode', 'Prosedur_nama')
            ->orderBy('Prosedur_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Prosedur');
        $sheet->setCellValue('C1', 'Nama Prosedur');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($Prosedur as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->Prosedur_kode);
            $sheet->setCellValue('C' . $baris, $value->Prosedur_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Prosedur');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Prosedur ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $Prosedur = ProsedurModel::select('Prosedur_kode', 'Prosedur_nama')
            ->orderBy('Prosedur_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('Prosedur.export_pdf', ['Prosedur' => $Prosedur]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Prosedur ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

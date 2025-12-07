<?php

namespace App\Http\Controllers;

use App\Models\AuditModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditController extends Controller
{
    // Menampilkan halaman awal Audit user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Audit user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Audit'; // set menu yang sedang aktif

        return view('Audit.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
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

        $sheet->setCellValue('A1', 'No');
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

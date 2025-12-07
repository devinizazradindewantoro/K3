<?php

namespace App\Http\Controllers;

use App\Models\KebijakanModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class KebijakanController extends Controller
{
    // Menampilkan halaman awal Kebijakan user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Kebijakan user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Kebijakan'; // set menu yang sedang aktif

        return view('Kebijakan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Kebijakan user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $Kebijakan = KebijakanModel::select('Kebijakan_id', 'Kebijakan_kode', 'Kebijakan_nama');

        // filter data user berdasarkan Kebijakan_id
        if ($request->Kebijakan_id) {
            $Kebijakan->where('Kebijakan_id', $request->Kebijakan_id);
        };


        return DataTables::of($Kebijakan)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($Kebijakan) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/Kebijakan/' . $Kebijakan->Kebijakan_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/Kebijakan/' . $Kebijakan->Kebijakan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/Kebijakan/'.$Kebijakan->Kebijakan_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/Kebijakan/' . $Kebijakan->Kebijakan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Kebijakan/' . $Kebijakan->Kebijakan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Kebijakan/' . $Kebijakan->Kebijakan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Kebijakan user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kebijakan User',
            'list' => ['Home', 'Kebijakan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kebijakan user baru'
        ];

        $Kebijakan = KebijakanModel::all();
        $activeMenu = 'Kebijakan'; // set menu yang sedang aktif

        return view('Kebijakan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Kebijakan' => $Kebijakan, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data Kebijakan user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Kebijakan kolom Kebijakan_kode dan Kebijakan_nama
            'Kebijakan_kode' => 'required|string|unique:m_Kebijakan,Kebijakan_kode',
            'Kebijakan_nama' => 'required|string'
        ]);

        KebijakanModel::create([
            'Kebijakan_kode' => $request->Kebijakan_kode,
            'Kebijakan_name' => $request->Kebijakan_name
        ]);

        return redirect('/Kebijakan')->with('success', 'Data Kebijakan berhasil disimpan');
    }


    // Menampilkan detail Kebijakan user

    public function show(string $id)
    {
        $Kebijakan = KebijakanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kebijakan',
            'list' => ['Home', 'Kebijakan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kebijakan'
        ];

        $activeMenu = 'Kebijakan'; // set menu yang sedang aktif

        return view('Kebijakan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Kebijakan' => $Kebijakan, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Kebijakan user

    public function edit(string $id)
    {
        $Kebijakan = KebijakanModel::find($id);
        $allKebijakan = KebijakanModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Kebijakan',
            'list' => ['Home', 'Kebijakan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kebijakan'
        ];

        $activeMenu = 'Kebijakan'; // set menu yang sedang aktif

        return view('Kebijakan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Kebijakan' => $Kebijakan, 'allKebijakan' => $allKebijakan, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data Kebijakan user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Kebijakan_kode' => 'required|string|unique:m_Kebijakan,Kebijakan_kode,' . $id . ',Kebijakan_id',
            'Kebijakan_name' => 'required|string'
        ]);

        $Kebijakan = KebijakanModel::findOrFail($id);
        $Kebijakan->update([

            'Kebijakan_kode' => $request->Kebijakan_kode,
            'Kebijakan_name' => $request->Kebijakan_name
        ]);

        return redirect('/Kebijakan')->with('success', 'Data Kebijakan berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('Kebijakan.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Kebijakan_kode' => 'required|string|min:3|max:20|unique:m_Kebijakan,Kebijakan_kode',
                'Kebijakan_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KebijakanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Kebijakan berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $Kebijakan = KebijakanModel::find($id);

        return view('Kebijakan.edit_ajax', ['Kebijakan' => $Kebijakan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Kebijakan_kode' => 'required|string|min:3|max:20|unique:m_Kebijakan,Kebijakan_kode,' . $id . ',Kebijakan_id',
                'Kebijakan_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = KebijakanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Kebijakan berhasil diupdate'
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
        $Kebijakan = KebijakanModel::find($id);

        return view('Kebijakan.confirm_ajax', ['Kebijakan' => $Kebijakan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $Kebijakan = KebijakanModel::find($id);
            if ($Kebijakan) {
                $Kebijakan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Kebijakan berhasil dihapus'
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

    // Menghapus data Kebijakan user
    public function destroy(string $id)
    {
        $Kebijakan = KebijakanModel::find($id);
        if (!$Kebijakan) { // untuk mengecek apakah data Kebijakan user dengan id yang dimaksud ada atau tidak
            return redirect('/Kebijakan')->with('error', 'Data Kebijakan tidak ditemukan');
        }

        try {
            KebijakanModel::destroy($id); // Hapus data Kebijakan user
            return redirect('/Kebijakan')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/Kebijakan')->with('error', 'Data Kebijakan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('Kebijakan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_Kebijakan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_Kebijakan');

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
                            'Kebijakan_kode' => $value['A'],
                            'Kebijakan_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    KebijakanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data Kebijakan berhasil diimport'
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
        $Kebijakan = KebijakanModel::select('Kebijakan_kode', 'Kebijakan_nama')
            ->orderBy('Kebijakan_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kebijakan');
        $sheet->setCellValue('C1', 'Nama Kebijakan');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($Kebijakan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->Kebijakan_kode);
            $sheet->setCellValue('C' . $baris, $value->Kebijakan_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Kebijakan');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Kebijakan ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $Kebijakan = KebijakanModel::select('Kebijakan_kode', 'Kebijakan_nama')
            ->orderBy('Kebijakan_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('Kebijakan.export_pdf', ['Kebijakan' => $Kebijakan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Kebijakan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

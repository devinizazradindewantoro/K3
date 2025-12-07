<?php

namespace App\Http\Controllers;

use App\Models\PelindungModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class PelindungController extends Controller
{
    // Menampilkan halaman awal Pelindung user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar Pelindung user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'Pelindung'; // set menu yang sedang aktif

        return view('Pelindung.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data Pelindung user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $Pelindung = PelindungModel::select('Pelindung_id', 'Pelindung_kode', 'Pelindung_nama');

        // filter data user berdasarkan Pelindung_id
        if ($request->Pelindung_id) {
            $Pelindung->where('Pelindung_id', $request->Pelindung_id);
        };


        return DataTables::of($Pelindung)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($Pelindung) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/Pelindung/' . $Pelindung->Pelindung_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/Pelindung/' . $Pelindung->Pelindung_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/Pelindung/'.$Pelindung->Pelindung_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/Pelindung/' . $Pelindung->Pelindung_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Pelindung/' . $Pelindung->Pelindung_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/Pelindung/' . $Pelindung->Pelindung_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah Pelindung user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Pelindung User',
            'list' => ['Home', 'Pelindung', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Pelindung user baru'
        ];

        $Pelindung = PelindungModel::all();
        $activeMenu = 'Pelindung'; // set menu yang sedang aktif

        return view('Pelindung.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Pelindung' => $Pelindung, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data Pelindung user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_Pelindung kolom Pelindung_kode dan Pelindung_nama
            'Pelindung_kode' => 'required|string|unique:m_Pelindung,Pelindung_kode',
            'Pelindung_nama' => 'required|string'
        ]);

        PelindungModel::create([
            'Pelindung_kode' => $request->Pelindung_kode,
            'Pelindung_name' => $request->Pelindung_name
        ]);

        return redirect('/Pelindung')->with('success', 'Data Pelindung berhasil disimpan');
    }


    // Menampilkan detail Pelindung user

    public function show(string $id)
    {
        $Pelindung = PelindungModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Pelindung',
            'list' => ['Home', 'Pelindung', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Pelindung'
        ];

        $activeMenu = 'Pelindung'; // set menu yang sedang aktif

        return view('Pelindung.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Pelindung' => $Pelindung, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit Pelindung user

    public function edit(string $id)
    {
        $Pelindung = PelindungModel::find($id);
        $allPelindung = PelindungModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Pelindung',
            'list' => ['Home', 'Pelindung', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Pelindung'
        ];

        $activeMenu = 'Pelindung'; // set menu yang sedang aktif

        return view('Pelindung.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'Pelindung' => $Pelindung, 'allPelindung' => $allPelindung, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data Pelindung user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Pelindung_kode' => 'required|string|unique:m_Pelindung,Pelindung_kode,' . $id . ',Pelindung_id',
            'Pelindung_name' => 'required|string'
        ]);

        $Pelindung = PelindungModel::findOrFail($id);
        $Pelindung->update([

            'Pelindung_kode' => $request->Pelindung_kode,
            'Pelindung_name' => $request->Pelindung_name
        ]);

        return redirect('/Pelindung')->with('success', 'Data Pelindung berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('Pelindung.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Pelindung_kode' => 'required|string|min:3|max:20|unique:m_Pelindung,Pelindung_kode',
                'Pelindung_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            PelindungModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Pelindung berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $Pelindung = PelindungModel::find($id);

        return view('Pelindung.edit_ajax', ['Pelindung' => $Pelindung]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'Pelindung_kode' => 'required|string|min:3|max:20|unique:m_Pelindung,Pelindung_kode,' . $id . ',Pelindung_id',
                'Pelindung_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = PelindungModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Pelindung berhasil diupdate'
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
        $Pelindung = PelindungModel::find($id);

        return view('Pelindung.confirm_ajax', ['Pelindung' => $Pelindung]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $Pelindung = PelindungModel::find($id);
            if ($Pelindung) {
                $Pelindung->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Pelindung berhasil dihapus'
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

    // Menghapus data Pelindung user
    public function destroy(string $id)
    {
        $Pelindung = PelindungModel::find($id);
        if (!$Pelindung) { // untuk mengecek apakah data Pelindung user dengan id yang dimaksud ada atau tidak
            return redirect('/Pelindung')->with('error', 'Data Pelindung tidak ditemukan');
        }

        try {
            PelindungModel::destroy($id); // Hapus data Pelindung user
            return redirect('/Pelindung')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/Pelindung')->with('error', 'Data Pelindung gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('Pelindung.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_Pelindung' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_Pelindung');

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
                            'Pelindung_kode' => $value['A'],
                            'Pelindung_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    PelindungModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data Pelindung berhasil diimport'
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
        $Pelindung = PelindungModel::select('Pelindung_kode', 'Pelindung_nama')
            ->orderBy('Pelindung_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Pelindung');
        $sheet->setCellValue('C1', 'Nama Pelindung');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($Pelindung as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->Pelindung_kode);
            $sheet->setCellValue('C' . $baris, $value->Pelindung_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Pelindung');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Pelindung ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $Pelindung = PelindungModel::select('Pelindung_kode', 'Pelindung_nama')
            ->orderBy('Pelindung_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('Pelindung.export_pdf', ['Pelindung' => $Pelindung]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Pelindung ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

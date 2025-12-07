<?php

namespace App\Http\Controllers;

use App\Models\P3KModel;
use App\Models\InformasiModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class P3KController extends Controller
{
    // Menampilkan halaman awal P3K user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list' => [''],
            'image' => 'img/background.avif'
        ];

        $page = (object) [
            'title' => 'Daftar P3K user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'P3K'; // set menu yang sedang aktif

        return view('P3K.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data P3K user dalam bentuk json untuk datatables public function list(Request $request)
    public function list(Request $request)
    {
        $P3K = P3KModel::select('P3K_id', 'P3K_kode', 'P3K_nama');

        // filter data user berdasarkan P3K_id
        if ($request->P3K_id) {
            $P3K->where('P3K_id', $request->P3K_id);
        };


        return DataTables::of($P3K)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($P3K) { // menambahkan kolom aksi
                // $btn = '<a href="'.url('/P3K/' . $P3K->P3K_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/P3K/' . $P3K->P3K_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/P3K/'.$P3K->P3K_id).'">'
                // . csrf_field() . method_field('DELETE') .
                // '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                //  return $btn;

                $btn = '<button onclick="modalAction(\'' . url('/P3K/' . $P3K->P3K_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/P3K/' . $P3K->P3K_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/P3K/' . $P3K->P3K_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah P3K user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah P3K User',
            'list' => ['Home', 'P3K', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah P3K user baru'
        ];

        $P3K = P3KModel::all();
        $activeMenu = 'P3K'; // set menu yang sedang aktif

        return view('P3K.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'P3K' => $P3K, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data P3K user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_P3K kolom P3K_kode dan P3K_nama
            'P3K_kode' => 'required|string|unique:m_P3K,P3K_kode',
            'P3K_nama' => 'required|string'
        ]);

        P3KModel::create([
            'P3K_kode' => $request->P3K_kode,
            'P3K_name' => $request->P3K_name
        ]);

        return redirect('/P3K')->with('success', 'Data P3K berhasil disimpan');
    }


    // Menampilkan detail P3K user

    public function show(string $id)
    {
        $P3K = P3KModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail P3K',
            'list' => ['Home', 'P3K', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail P3K'
        ];

        $activeMenu = 'P3K'; // set menu yang sedang aktif

        return view('P3K.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'P3K' => $P3K, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit P3K user

    public function edit(string $id)
    {
        $P3K = P3KModel::find($id);
        $allP3K = P3KModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit P3K',
            'list' => ['Home', 'P3K', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit P3K'
        ];

        $activeMenu = 'P3K'; // set menu yang sedang aktif

        return view('P3K.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'P3K' => $P3K, 'allP3K' => $allP3K, 'activeMenu' => $activeMenu]);
    }


    // Menyimpan perubahan data P3K user

    public function update(Request $request, string $id)
    {
        $request->validate([
            'P3K_kode' => 'required|string|unique:m_P3K,P3K_kode,' . $id . ',P3K_id',
            'P3K_name' => 'required|string'
        ]);

        $P3K = P3KModel::findOrFail($id);
        $P3K->update([

            'P3K_kode' => $request->P3K_kode,
            'P3K_name' => $request->P3K_name
        ]);

        return redirect('/P3K')->with('success', 'Data P3K berhasil diperbarui');
    }

    public function create_ajax()
    {
        return view('P3K.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'P3K_kode' => 'required|string|min:3|max:20|unique:m_P3K,P3K_kode',
                'P3K_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            P3KModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data P3K berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $P3K = P3KModel::find($id);

        return view('P3K.edit_ajax', ['P3K' => $P3K]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'P3K_kode' => 'required|string|min:3|max:20|unique:m_P3K,P3K_kode,' . $id . ',P3K_id',
                'P3K_nama' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = P3KModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data P3K berhasil diupdate'
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
        $P3K = P3KModel::find($id);

        return view('P3K.confirm_ajax', ['P3K' => $P3K]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $P3K = P3KModel::find($id);
            if ($P3K) {
                $P3K->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data P3K berhasil dihapus'
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

    // Menghapus data P3K user
    public function destroy(string $id)
    {
        $P3K = P3KModel::find($id);
        if (!$P3K) { // untuk mengecek apakah data P3K user dengan id yang dimaksud ada atau tidak
            return redirect('/P3K')->with('error', 'Data P3K tidak ditemukan');
        }

        try {
            P3KModel::destroy($id); // Hapus data P3K user
            return redirect('/P3K')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/P3K')->with('error', 'Data P3K gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('P3K.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_P3K' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_P3K');

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
                            'P3K_kode' => $value['A'],
                            'P3K_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    P3KModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data P3K berhasil diimport'
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
        $P3K = P3KModel::select('P3K_kode', 'P3K_nama')
            ->orderBy('P3K_kode')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode P3K');
        $sheet->setCellValue('C1', 'Nama P3K');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($P3K as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->P3K_kode);
            $sheet->setCellValue('C' . $baris, $value->P3K_nama);
            $baris++;
            $no++;
        }

        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data P3K');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data P3K ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $P3K = P3KModel::select('P3K_kode', 'P3K_nama')
            ->orderBy('P3K_kode')
            ->get();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = Pdf::loadView('P3K.export_pdf', ['P3K' => $P3K]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data P3K ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

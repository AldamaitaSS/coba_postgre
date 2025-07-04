<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\UserModels;

class EditorController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Diri Editor',
            'list' => ['Home', 'Data Editor']
        ];
        
        $activeMenu = 'editor'; 
        $editor = UserModels::where('id_level', 3)->get(); 
        return view('admin.data_editor.index', [
            'breadcrumb' => $breadcrumb,
            'editor' => $editor, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {

        $editor = UserModels::all();

        return DataTables::of($editor)
          
            ->addIndexColumn()
            ->addColumn('aksi', function ($editor) {  // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\'' . url('/admin/data_editor/' . $editor->id_user . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data_editor/' . $editor->id_user . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/admin/data_editor/' . $editor->id_user . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {

        $data = [
            'editor' => UserModels::all(),
        ];

        return view('admin.data_editor.create_ajax', $data);
    }

    public function store_ajax(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_level' => 'required|exists:m_level,id_level',
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:100|unique:m_user,username',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            UserModels::create([
                'nama' => $request->nama,
                'id_level' => $request->id_level,
                'username' => $request->username,
                'password' => $request->password,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data Editor berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal simpan editor: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage() // tampilkan pesan error
            ]);
        }
    }

    public function edit_ajax(string $id)
    {
        $editor = UserModels::find($id);
        return view('admin.data_editor.edit_ajax', ['editor' => $editor]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_level' => 'required|exists:m_level,id_level',
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:100|unique:m_user,username',
                'password' => 'required|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $editor = UserModels::find($id);

            if ($editor) {
                $editor->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data Editor berhasil diperbarui.',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $editor = UserModels::find($id);
        return view('admin.data_editor.confirm_ajax', ['editor' => $editor]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $editor = UserModels::find($id);

            if ($editor) {
                $editor->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Editor berhasil dihapus.',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $editor = UserModels::find($id);
        return view('admin.data_editor.show_ajax', ['editor' => $editor]);
    }

//     public function import()
//     {
//         return view('admin.data_editor.import');
//     }
//     public function import_ajax(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
//                 'file_editor' => ['required', 'mimes:xlsx', 'max:1024'],
//             ];

//             $validator = Validator::make($request->all(), $rules);

//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi gagal.',
//                     'msgField' => $validator->errors(),
//                 ]);
//             }

//             $file = $request->file('file_editor');
//             $reader = IOFactory::createReader('Xlsx');
//             $spreadsheet = $reader->load($file->getRealPath());
//             $data = $spreadsheet->getActiveSheet()->toArray(null, false, true, true);

//             $insert = [];
//             foreach ($data as $key => $row) {
//                 if ($key > 1) {
//                     $insert[] = [
//                         'level_id' => $row['A'],
//                         'nama' => $row['B'],
//                         'created_at' => now(),
//                     ];
//                 }
//             }

//             if (count($insert) > 0) {
//                 UserModels::insertOrIgnore($insert);
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data Editor berhasil diimport.',
//                 ]);
//             }

//             return response()->json([
//                 'status' => false,
//                 'message' => 'Tidak ada data yang diimport.',
//             ]);
//         }

//         return redirect('/');
//     }

//     public function export_excel()
//     {
//        $editor = UserModels::where('id_level', 3)->get();

//         $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
//         $sheet = $spreadsheet->getActiveSheet();

//         $sheet->setCellValue('A1', 'No');
//         $sheet->setCellValue('B1', 'Level');
//         $sheet->setCellValue('C1', 'Nama Editor');
//         $sheet->getStyle('A1:C1')->getFont()->setBold(true);

//         $row = 2;
//         $no = 1;

//         foreach ($editor as $v) {
//             $sheet->setCellValue('A' . $row, $no);
//             $sheet->setCellValue('B' . $row, $editor->level->nama_level);
//             $sheet->setCellValue('C' . $row, $v->nama);

//             $row++;
//             $no++;
//         }

//         foreach (range('A', 'C') as $columnID) {
//             $sheet->getColumnDimension($columnID)->setAutoSize(true);
//         }

//         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//         $filename = 'Data Editor.xlsx';

//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header("Content-Disposition: attachment; filename=$filename");
//         $writer->save("php://output");
//     }

//     public function exportTemplate()
// {
//     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
//     $sheet = $spreadsheet->getActiveSheet();

//     // Set judul kolom
//     $sheet->setCellValue('A1', 'No');
//     $sheet->setCellValue('B1', 'Level');
//     $sheet->setCellValue('C1', 'Nama Editor');

//  $sheet->getStyle('A1:C1')->getFont()->setBold(true);

//     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//     $filename = 'Template_Editor.xlsx';

//     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//     header("Content-Disposition: attachment; filename=$filename");
//     $writer->save("php://output");
//     exit;
// }

//     public function export_pdf()
//     {
//         $editor = UserModels::where('id_level', 3)->get();
//         $pdf = Pdf::loadView('editor.export_pdf', ['editor' => $editor]);
//         $pdf->setPaper('a4', 'portrait');
//         $pdf->setOption('isRemoteEnabled', true); // Aktifkan akses remote untuk gambar
//         return $pdf->stream('Data Editor ' . date('Y-m-d H:i:s') . '.pdf');

//     }
}

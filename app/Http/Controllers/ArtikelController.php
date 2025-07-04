<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtikelModels;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class ArtikelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Artikel',
            'list' => ['Home', 'Artikel']
        ];
        
        $page = (object) [
            'title' => 'Artikel',
        ];
     
        $activeMenu = 'artikel'; 
        
     
        return view('admin.artikel.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request){
        $artikel = ArtikelModels::all();
        return DataTables::of($artikel)
            
            ->addIndexColumn()
            ->addColumn('aksi', function ($artikel) {  // menambahkan kolom aksi 
                $btn  = '<button onclick="modalAction(\''.url('/admin/artikel/' . $artikel->id_artikel . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/artikel/' . $artikel->id_artikel . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/artikel/' . $artikel->id_artikel . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create_ajax()
    {
        $data = [
            'artikel' => ArtikelModels::all(),
        ];
            
        return view('admin.artikel.create_ajax', $data);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            
            dd($request->all());
            $rules = [
                'id_jenis' => 'required|exists:m_jenis_artikel,id_jenis',
                'judul' => 'nullable|string|max:255',
                'isi_Artikel' => 'required|string',
                'gambar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Ubah ke 10MB
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
    
            try {
                DB::beginTransaction();
    
                // Handle file upload
                $gambar = null;
                if ($request->hasFile('gambar')) {
                    $file = $request->file('gambar');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    // Pastikan direktori exists
                    $uploadPath = storage_path('app/public/gambar');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    $file->move($uploadPath, $fileName);
                    $gambar = $fileName; // Perbaikan: langsung assign ke variable yang benar
                }

                ArtikelModels::create([
                    'id_jenis' => $request->id_jenis,
                    'judul' => $request->judul,
                    'isi_Artikel' => $request->isi_Artikel,
                    'gambar' => $request->gambar
                ]);
    
                DB::commit();
                
                return response()->json([
                    'status' => true,
                    'message' => 'Artikel berhasil disimpan.'
                ]);
    
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan gambar: ' . $e->getMessage()
                ]);
            }
        }
    
        return redirect('/');
    }
    
    public function show_ajax($id)
    {
        $artikel = ArtikelModels::findOrFail($id);
        return view('admin.artikel.show_ajax', compact('artikel'));
    }
    public function edit_ajax($id)
    {
        $artikel = ArtikelModels::findOrFail($id);
        return view('admin.artikel.edit_ajax', compact('artikel'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $artikel = ArtikelModels::findOrFail($id);
    
            $rules = [
                'id_jenis' => 'required|exists:m_jenis_artikel,id_jenis',
                'judul' => 'nullable|string|max:255',
                'isi_Artikel' => 'nullable|string|max:255',
                'gambar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Ubah ke 10MB
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
    
            try {
                DB::beginTransaction();
    
                // Handle file upload if there's new file
                if ($request->hasFile('gambar')) {
                    // Delete old file
                    if ($artikel->gambar) {
                        $oldFilePath = storage_path('app/public/gambar/' . $artikel->gambar);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
    
                    $file = $request->file('gambar');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(storage_path('app/public/gambar'), $fileName);
                    $artikel->gambar = $fileName;
                }
    
                $artikel->id_jenis = $request->id_jenis;
                $artikel->judul = $request->judul;
                $artikel->isi_Artikel = $request->isi_Artikel;
                $artikel->save();
    
                DB::commit();
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diperbarui.'
                ]);
    
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $artikel = ArtikelModels::findOrFail($id);
        return view('admin.artikel.confirm_ajax', compact('artikel'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                DB::beginTransaction();
                
                $artikel = ArtikelModels::findOrFail($id);
                
                // Delete file if exists
                if ($artikel->gambar) {
                    Storage::delete('public/gambar/' . $artikel->gambar);
                }
                
                $artikel->delete();
                
                DB::commit();
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ]);
            }
        }
    }
}

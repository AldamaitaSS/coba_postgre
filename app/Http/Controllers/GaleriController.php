<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GaleriModels;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class GaleriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Galeri',
            'list' => ['Home', 'Galeri']
        ];
        
        $page = (object) [
            'title' => 'Galeri',
        ];
     
        $activeMenu = 'galeri'; 
     
        return view('admin.galeri.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request){
        $galeri = GaleriModels::all();
        return DataTables::of($galeri)
            
            ->addIndexColumn()
            ->addColumn('aksi', function ($galeri) {  // menambahkan kolom aksi 
                $btn  = '<button onclick="modalAction(\''.url('/admin/galeri/' . $galeri->id_galeri . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/galeri/' . $galeri->id_galeri . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/galeri/' . $galeri->id_galeri . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create_ajax()
    {
        $data = [
            'galeri' => GaleriModels::all(),
        ];
            
        return view('admin.galeri.create_ajax', $data);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_galeri' => 'required|string|max:255',
                'tanggal_upload' => 'required|date',
                'upload_gambar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // Ubah ke 10MB
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
                $upload_gambar = null;
                if ($request->hasFile('upload_gambar')) {
                    $file = $request->file('upload_gambar');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    // Pastikan direktori exists
                    $uploadPath = storage_path('app/public/gambar');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    $file->move($uploadPath, $fileName);
                    $upload_gambar = $fileName; // Perbaikan: langsung assign ke variable yang benar
                }
    
                // Create record - hapus id_galeri jika tidak diperlukan
                GaleriModels::create([
                    'nama_galeri' => $request->nama_galeri,
                    'tanggal_upload' => $request->tanggal_upload,
                    'upload_gambar' => $upload_gambar
                ]);
    
                DB::commit();
                
                return response()->json([
                    'status' => true,
                    'message' => 'Gambar berhasil disimpan.'
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
        $galeri = GaleriModels::findOrFail($id);
        return view('admin.galeri.show_ajax', compact('galeri'));
    }
    public function edit_ajax($id)
    {
        $galeri = GaleriModels::findOrFail($id);
        return view('admin.galeri.edit_ajax', compact('galeri'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $galeri = GaleriModels::findOrFail($id);
    
            $rules = [
                'nama_galeri' => 'required|string|max:255',
                'tanggal_upload' => 'required|date',
                'upload_gambar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // nullable untuk update
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
                if ($request->hasFile('upload_gambar')) {
                    // Delete old file
                    if ($galeri->upload_gambar) {
                        $oldFilePath = storage_path('app/public/gambar/' . $galeri->upload_gambar);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
    
                    $file = $request->file('upload_gambar');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(storage_path('app/public/gambar'), $fileName);
                    $galeri->upload_gambar = $fileName;
                }
    
                $galeri->nama_galeri = $request->nama_galeri;
                $galeri->tanggal_upload = $request->tanggal_upload;
                $galeri->save();
    
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
        $galeri = GaleriModels::findOrFail($id);
        return view('admin.galeri.confirm_ajax', compact('galeri'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                DB::beginTransaction();
                
                $galeri = GaleriModels::findOrFail($id);
                
                // Delete file if exists
                if ($galeri->upload_gambar) {
                    Storage::delete('public/gambar/' . $galeri->upload_gambar);
                }
                
                $galeri->delete();
                
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

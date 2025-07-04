<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriModels extends Model
{
    use HasFactory;
    protected $table = 'm_galeri';
    protected $primaryKey = 'id_galeri';
    protected $fillable = ['nama_galeri', 'deskripsi', 'tanggal_upload', 'upload_gambar'];
}

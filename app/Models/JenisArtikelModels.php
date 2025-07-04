<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisArtikelModels extends Model
{
    use HasFactory;
    protected $table = 'm_jenis_artikel';
    protected $primaryKey = 'id_jenis';
    protected $fillable = ['jenis_artikel'];
}

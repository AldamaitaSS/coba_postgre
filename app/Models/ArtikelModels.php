<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtikelModels extends Model
{
    use HasFactory;
    protected $table = 'm_artikel';
    protected $primaryKey = 'id_artikel';
    protected $fillable = ['id_jenis', 'judul', 'isi_artikel', 'gambar'];
    
    public $timestamps = false;
     public function artikel(): BelongsTo
    {
        return $this->belongsTo(LevelModels::class, 'id_jenis', 'id_jenis');
    }
}

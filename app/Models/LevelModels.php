<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModels extends Model
{
    use HasFactory;
    protected $table = 'm_level';
    protected $primaryKey = 'id_level';
    protected $fillable = ['nama_level'];
}

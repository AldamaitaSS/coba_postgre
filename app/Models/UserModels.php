<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModels extends Model
{
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey ='id_user';
    protected $fillable = ['username', 'nama', 'id_level', 'password'];

    protected $hidden   = ['password']; // jangan di tampilkan saat select
    protected $casts    = ['password' => 'hashed']; // casting password agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModels::class, 'id_level', 'id_level');
    }
}

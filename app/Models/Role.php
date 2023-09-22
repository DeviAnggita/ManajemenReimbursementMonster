<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_role';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'nama_role',
        'status_active',
        'created_at', 
        'updated_at'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
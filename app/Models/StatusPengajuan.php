<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPengajuan extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_status_pengajuan';
    protected $primaryKey = 'id_status_pengajuan';
    protected $fillable = [
        'nama_status_pengajuan',
        'id_role',
        'status_active',
        'created_at', 
        'updated_at'
    ];
    
    public function role()
    {
    return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}
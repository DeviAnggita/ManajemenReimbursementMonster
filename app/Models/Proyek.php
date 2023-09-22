<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_proyek';
    protected $primaryKey = 'id_proyek';
    protected $fillable = [
        'nomor_proyek',
        'nama_proyek',
        'status_active',
        'created_at', 
        'updated_at'
    ];  
}
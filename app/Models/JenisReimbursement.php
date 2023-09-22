<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisReimbursement extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_jenis_reimbursement';
    protected $primaryKey = 'id_jenis_reimbursement';
    protected $fillable = [
        'memiliki_supplier',
        'memiliki_proyek',
        'nama_jenis_reimbursement',
        'created_at', 
        'updated_at'
    ];
}
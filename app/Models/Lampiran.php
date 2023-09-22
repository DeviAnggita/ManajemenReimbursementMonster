<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_lampiran';
    protected $primaryKey = 'id_lampiran';
    protected $fillable = [
        'id_reimbursement',
        'id_supplier',
        'id_proyek',
        'id_jenis_reimbursement',
        'nomor_kwitansi',
        'tanggal_kwitansi',
        'judul_kwitansi',
        'nama_kwitansi',
        'file',
        'keterangan',
        'created_at', 
        'updated_at'
    ];

    // Define the relationship with Supplier model
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier')->nullable();
    }
    
    // Define the relationship with Supplier model
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek')->nullable();
    }

    public function role()
    {
    return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function reimbursement()
    {
        return $this->belongsTo(Reimbursement::class, 'id_reimbursement');
    }

}
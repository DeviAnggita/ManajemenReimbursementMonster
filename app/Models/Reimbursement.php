<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_reimbursement';
    protected $primaryKey = 'id_reimbursement';
    protected $fillable = [
        'id_jenis_reimbursement',
        'id_karyawan',
        'id_status_pengajuan',
        'nomor_identitas_karyawan',
        'nama_karyawan',
        'tanggal_bayar',
        'tanggal_reimbursement',
        'keterangan',
        'total',
        'id_user_verifikasi',
        'alasan_revisi_kd',
        'alasan_ditolak_kd',
        'id_user_verifikasi_mk',
        'alasan_revisi_mk',
        'alasan_ditolak_mk',
        'tanggal_verifikasi',
        'created_at', 
        'updated_at'
    ];
    
    public function jenisReimbursement()
    {
        return $this->belongsTo(JenisReimbursement::class, 'id_jenis_reimbursement');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
        
    public function statusPengajuan()
    {
        return $this->belongsTo(StatusPengajuan::class, 'id_status_pengajuan');
    }
    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'id_reimbursement');
    }

    public function setStatusPengajuan()
    {
        // Cek apakah nilai id_status_pengajuan adalah 8
        if ($this->id_status_pengajuan == 8) {
            // Menghitung 2 menit kemudian
            $duaMenitKemudian = now()->addMinutes(2);

            // Cek apakah tanggal sekarang melebihi atau sama dengan duaMenitKemudian
            if (now() >= $duaMenitKemudian) {
                // Mengubah id_status_pengajuan menjadi 26 atau 17 secara acak
                $this->id_status_pengajuan = rand(26, 17);
                $this->save();
            }
        }
    }
}
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_divisi',
        'id_strata',
        'id_role',
        'nomor_identitas_karyawan',
        'nama_karyawan',
        'email_karyawan',
        'password',
        'gaji',
        'status_active',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function username() {
        return 'email_karyawan';
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function strata()
    {
        return $this->belongsTo(Strata::class, 'id_strata');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
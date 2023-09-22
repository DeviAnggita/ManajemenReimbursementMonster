<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_divisi';
    protected $primaryKey = 'id_divisi';
    protected $fillable = [
        'nama_divisi',
        'status_active',
        'created_at', 
        'updated_at'
    ];
}
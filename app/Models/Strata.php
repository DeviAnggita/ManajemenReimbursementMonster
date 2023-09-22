<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strata extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_strata';
    protected $primaryKey = 'id_strata';
    protected $fillable = [
        'nama_strata',
        'status_active',
        'created_at', 
        'updated_at'
    ];
}
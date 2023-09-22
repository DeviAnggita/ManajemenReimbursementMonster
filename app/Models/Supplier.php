<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tb_supplier';
    protected $primaryKey = 'id_supplier';
    protected $fillable = [
        'nama_supplier',
        'status_active',
        'created_at', 
        'updated_at'
    ];
}
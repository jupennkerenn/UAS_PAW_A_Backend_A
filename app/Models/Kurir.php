<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    /**
    * fillable
    *
    * @var array
    */

    protected $fillable = [
        'nama_kurir',
        'umur_kurir',
        'gender_kurir',
        'telp_kurir',
    ];
}

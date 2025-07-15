<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    // Nama tabel jika tidak mengikuti konvensi Laravel (opsional, default: site_settings)
    // protected $table = 'site_settings';

    // Field yang boleh diisi massal
    protected $fillable = [
        'key',
        'value',
    ];

    // Nonaktifkan timestamps
    public $timestamps = false;

    // Optional: Cast value jika kamu menyimpan JSON atau tipe lain
    // protected $casts = [
    //     'value' => 'array',
    // ];
}

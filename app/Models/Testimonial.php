<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // <-- Tambahkan ini
        'customer_job',
        'customer_image',
        'comment',
        'rating',
        'is_visible',
    ];

    /**
     * Definisikan relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

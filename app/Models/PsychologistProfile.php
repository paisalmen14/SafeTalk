<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychologistProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_image_path',
        'price_per_hour',     
        'ktp_number', 
        'university',
        'graduation_year',
        'certificate_path',
        'ktp_path', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
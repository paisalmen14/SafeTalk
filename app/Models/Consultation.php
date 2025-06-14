<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'psychologist_id',
        'availability_id',
        'requested_start_time',
        'duration_minutes',
        'psychologist_price',
        'admin_fee',
        'total_payment',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'requested_start_time' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function psychologist()
    {
        return $this->belongsTo(User::class, 'psychologist_id');
    }

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    public function paymentConfirmation()
    {
        return $this->hasOne(PaymentConfirmation::class);
    }

    /**
     * Mendefinisikan relasi bahwa satu sesi konsultasi memiliki banyak chat.
     */
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
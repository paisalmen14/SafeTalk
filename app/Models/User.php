<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'psychologist_status',
        'chosen_psychologist_id',
    ];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'membership_expires_at' => 'datetime',
    ];

    public function chosenPsychologist()
{
    return $this->belongsTo(User::class, 'chosen_psychologist_id');
}

    // RELASI YANG HILANG (INI PERBAIKANNYA)
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // AKHIR DARI PERBAIKAN

    public function paymentConfirmations()
    {
        return $this->hasMany(PaymentConfirmation::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
    
    public function isMember(): bool
    {
        return $this->membership_expires_at && $this->membership_expires_at->isFuture();
    }
        public function psychologistProfile()
    {
        return $this->hasOne(PsychologistProfile::class);
    }
}
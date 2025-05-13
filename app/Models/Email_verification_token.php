<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email_verification_token extends Model
{
    protected $table = 'email_verification_tokens';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'user_id',
        'token'
    ];

    protected $visible = [
        'email',
        'user_id',
        'token'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}

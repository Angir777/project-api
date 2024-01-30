<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    public $incrementing = false;

    protected $fillable = [
        'email',
        'token'
    ];
}

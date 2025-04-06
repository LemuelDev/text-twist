<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetsToken extends Model
{
    use HasFactory;

    protected $table = "password_resets_token";
    protected $fillable = ['email', 'token', 'created_at', 'expires_at', 'updated_at'];
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    
}

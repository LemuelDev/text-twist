<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'word', 'meaning'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}

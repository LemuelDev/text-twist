<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ['level_number', 'question', 'mode'];

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Userprofile extends Model
{
    use HasFactory;

    protected $fillable = [
        "firstname",
        "middlename",
        "lastname",
        "fullname",
        "email",
        "year",
        "student_number",
        "isPending",
        "user_type",
        "highscore",
        "lvl_cleared"
        
    ];

    protected $table = 'userprofiles';

    
    public function user()
    {
        return $this->hasOne(User::class, 'userprofile_id'); // ✅ No onDelete() here
    }
}

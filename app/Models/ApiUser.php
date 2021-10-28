<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiUser extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function canCreateToken()
    {
        if ($user = ApiUser::find(Auth::id())) {
            if ($user->status == "disabled") return false;
            return true;
        }
        return false;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtsoOwner extends Model
{
    use HasFactory;

    public function ftso()
    {
        $this->hasOne(Ftso::class);
    }
    public static function isOwner(Ftso $ftso, User $user)
    {
        if ($ftso->owner->contains('user_id', $user->id)) {
            return true;
        }
        return false;
    }
}
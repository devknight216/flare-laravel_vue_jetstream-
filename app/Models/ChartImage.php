<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartImage extends Model
{
    use HasFactory;

    public function getSnapshot($token)
    {
        $snapshot = $this->where('token', $token)->get();
        return $snapshot->last()->url;
    }
}
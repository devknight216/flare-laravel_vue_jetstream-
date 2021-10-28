<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderPool extends Model
{
    use HasFactory;

    protected $hidden = ['ftso_id'];
    protected $appends = ['provider_name'];

    public function provider()
    {
        return $this->belongsTo(Ftso::class, 'ftso_id', 'id');
    }

    public function getProviderNameAttribute()
    {
        return $this->provider()->first()->name ?? 'anon';
    }
}

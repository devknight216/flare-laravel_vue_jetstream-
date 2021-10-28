<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtsoUserRewardState extends Model
{
    use HasFactory;
    protected $appends = ['delegated_providers'];

    public function getDelegatedProvidersAttribute()
    {
        // return $this->provider_id_1;
        if ($this->provider_id_1 && $this->provider_id_1) {
            return Ftso::where('uid', $this->provider_id_1)->orWhere('uid', $this->provider_id_2)->get();
        } else {
            return Ftso::where('uid', $this->provider_id_1)->get();
        }
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeatureInviteCode extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateCode();
        });
    }
    private function generateCode()
    {
        $bytes = random_bytes(3);
        $code = strtoupper((string)(bin2hex($bytes)));
        if (count($this->where('code', $code)->get())) {
            $this->generateCode();
            return;
        }
        $this->code = $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateInvite($user_id, $feature, $max_redemptions = 2)
    {
        if (FeatureInviteCode::where('user_id', $user_id)->where('feature', $feature)->count()) {
            return FeatureInviteCode::where('user_id', $user_id)->where('feature', $feature)->first();
        }
        $code = new FeatureInviteCode();
        $code->user_id = $user_id;
        $code->feature = $feature;
        $code->max_redemptions = $max_redemptions;
        $code->expiry = Carbon::now()->addWeeks(52);
        $code->save();
        return $code;
    }
}
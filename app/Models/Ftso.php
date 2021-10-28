<?php

namespace App\Models;

use App\Models\ProviderPool;
use App\Models\ProviderRewardState;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ftso extends Model
{
    protected $casts = [
        'info' => 'array',
        'socials' => 'array',
        'verified' => 'boolean',
        'info->established' => 'datetime:d M y (h:i)',

    ];

    protected $fillable = [
        'name',
        'code',
        'emblem',
        'logo',
        'description',
        'extended_description',
        'website',
        'website_url',
        'info',
        'socials',
        'admin_email',
        'verified',
        'meta_images',
        'feature_video',
        'site_description'

    ];

    protected $appends = ['pools', 'reward_state', 'average_reward_rate'];

    protected $hidden = array('admin_email');

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ftso) {
            $ftso->uid = $ftso::generateUid();
        });
    }

    public function owner()
    {
        return $this->hasMany(FtsoOwner::class, 'ftsos_id');
    }

    public function applications()
    {
        return $this->hasMany(FtsoApplication::class, 'ftsos_id');
    }

    public function pools()
    {
        return $this->hasMany(ProviderPool::class, "ftso_id");
    }

    public function getPoolsAttribute()
    {
        return
            cache()->remember(
                'provider_pools_query-' . $this->uid,
                now()->addMinutes(10),
                function () {
                    return $this->pools()->get();
                }
            );
    }
    public function getRewardStateAttribute()
    {
        $state =
            cache()->remember(
                'provider_reward_state_query-' . $this->uid,
                now()->addMinutes(10),
                function () {
                    return ProviderRewardState::where('provider_id', $this->uid)->latest()->first();
                }
            );
        return $state;
    }
    public function getAverageRewardRateAttribute()
    {
        // return 1;

        $latestRewardEpoch = cache()->remember('latest_reward_epoch', now()->addMinutes(30), function () {
            return (ProviderRewardState::orderBy('reward_epoch', 'desc')->select('reward_epoch')->first())->reward_epoch;
        });

        $group = cache()->remember('provider_reward_rate_query-' . $this->uid, now()->addMinutes(10), function () use ($latestRewardEpoch) {
            return ProviderRewardState::orderBy('provider_reward_state', 'desc')->where('reward_epoch', '>', $latestRewardEpoch - 3)->where('provider_id', $this->uid)->select('provider_reward_state', 'provider_votepower', 'provider_fee', 'reward_epoch')->get()->groupBy(function ($item) {
                return $item->reward_epoch;
            });
        });
        $reward_rate_key = 'provider_average_reward_rate' . $this->uid;
        if (cache()->has($reward_rate_key)) {
            return cache()->get($reward_rate_key);
        }
        $average = cache()->remember($reward_rate_key, now()->addMinutes(10), function ()  use ($group, $reward_rate_key) {
            $reward_rates = [];
            foreach ($group as $g) {
                $epoch_rewards_high = $g->max('provider_reward_state');
                $epoch_votepower = $g[0]['provider_votepower'];
                $epoch_fee = $g[0]['provider_fee'];

                if (!$epoch_rewards_high) break;
                if (!$epoch_votepower) break;
                if (!$epoch_fee) break;

                $multiplier = 100 - $epoch_fee;
                $multiplier = $multiplier / $epoch_fee;

                $reward_rate = $multiplier * $epoch_rewards_high / $epoch_votepower * 100;
                array_push($reward_rates, $reward_rate);
            }
            if (count($reward_rates) == 0) return 0;
            $reward_rates = array_filter($reward_rates);
            return array_sum($reward_rates) / count($reward_rates);
        });


        return $average;
    }

    public static function generateUid()
    {
        $uid = mt_rand(1000000, 9999999);
        if (self::uidExists($uid)) {
            return self::generateUid();
        }

        return $uid;
    }

    public static function uidExists($uid)
    {
        return Ftso::where('uid', $uid)->exists();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtsoApplication extends Model
{
    use HasFactory;
    protected $casts = [
        'info' => 'array',
        'socials' => 'array',
        'verified' => 'boolean',
        'created_at' => 'datetime:d M y (h:i)',
    ];

    protected $fillable = [
        'name',
        'code',
        'emblem',
        'logo',
        'description',
        'extended_description',
        'website_url',
        'info',
        'socials',
        'admin_email',
        'verified',
        'meta_images',
        'feature_video',
        'additional_comments',
        'status',
        'type',
        'user_id',
        'ftsos_id'
    ];
}
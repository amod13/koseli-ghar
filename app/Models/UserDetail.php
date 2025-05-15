<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'designation',
        'website',
        'address',
        'image',
        'facebook',
        'whatsapp',
        'twitter',
        'exclusive_offers',
        'daily_messages',
        'weekly_summary',
        'company_name',
        'city',
    ];
}

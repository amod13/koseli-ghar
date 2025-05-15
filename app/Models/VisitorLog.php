<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs';

    protected $fillable = [
        'user_id',
        'ip_address',
        'url',
        'user_agent',
    ];
}

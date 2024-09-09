<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'nepali_start_date',
        'nepali_end_date',
        'ticket_price',
        'match_price_9',
        'match_price_8',
        'match_price_7',
        'match_price_6',
        'match_price_5',
        'match_price_0',
        'serial_match_price_9',
        'serial_match_price_8',
        'serial_match_price_7',
        'serial_match_price_6',
        'serial_match_price_5',
        'serial_match_price_4',
        'live_at_date',
        'nepali_live_at_date',
        'is_completed'
    ];
}

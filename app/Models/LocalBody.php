<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalBody extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'ward_count', 'state_id', 'district_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\AgentBalanceLog;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'agent_code',
        'is_master_agent',
        'is_active',
        'street_addr',
        'ward',
        'local_body_id',
        'district_id',
        'state_id',
        'user_id',
        'balance',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agent) {
            do {
                $agent->agent_code = strtoupper('AGT-' . Str::random(6));
            } while (self::where('agent_code', $agent->agent_code)->exists());
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function balanceLogs()
    {
        return $this->hasMany(AgentBalanceLog::class);
    }

    public function referrer()
    {
        return $this->belongsTo(Agent::class, 'referrer_id');
    }

    /**
     * Get the agents referred by this agent.
     */
    public function referrals()
    {
        return $this->hasMany(Agent::class, 'referrer_id');
    }
}

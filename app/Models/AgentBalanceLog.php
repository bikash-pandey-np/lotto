<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agent;

class AgentBalanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'amount', 'desc'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}

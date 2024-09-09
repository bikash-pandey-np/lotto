<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use Validator;
use Auth;
use App\Models\Agent;

class SettingController extends Controller
{
    public function getProfile()
    {
        $agent = Auth::user();
        return response()->json(['data' => $agent], 200);
    }
}

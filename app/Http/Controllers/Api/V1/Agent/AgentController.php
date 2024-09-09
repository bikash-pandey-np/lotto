<?php

namespace App\Http\Controllers\Api\V1\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use Validator;
use Throwable;
use App\Models\Agent;
use Hash;

class AgentController extends Controller
{
    public function createAgent(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required|unique:agents,email',
            'phone' => 'required|unique:agents,phone',
            'password' => 'required',
            'street_addr' => 'required',
            'ward' => 'required|numeric',
            'local_body_id' => 'required|exists:local_bodies,id',
            'district_id' => 'required|exists:districts,id',
            'state_id' => 'required|exists:states,id',
        ];
        $validate = Validator::make($request->all(), $rules);

        if($validate->fails())
        {
            return response()->json([
                'error' => true,
                'errors' => $validate->errors(),
                'message' => 'Validation Error'
            ],400);
        }

        $agentData = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'street_addr' => $request->street_addr,
            'ward' => $request->ward,
            'local_body_id' => $request->local_body_id,
            'district_id' => $request->district_id,
            'state_id' => $request->state_id,
            'referrer_id' => 1,
        ];

        try{

            Agent::create($agentData);

            return response()->json([
                'error' => false,
                'message' => 'Agent Created Successfully',
                'errors' => null,
            ],200);

        }
        catch(Throwable $th)
        {
            Log::error("AGENT CREATE ERROR: " . $th->getMessage());

            return response()->json([
                'error' => true,
                'errors' => null,
                'message' => 'Create Agent Error'
            ],500);
        }

                        
    }

    public function getReferrals(Request $request)
    {
        // $id = Auth::guard('agent')->id();
        $id = 1;

        // Retrieve the selected agent by ID
        $selectedAgent = Agent::find($id);
    
        // Check if the agent exists
        if (!$selectedAgent) {
            return response()->json([
                'error' => true,
                'message' => 'Agent Not Found'
            ], 404);
        }
    
        // Fetch the referrals of the selected agent
        $agents = $selectedAgent->referrals;
    
        return response()->json([
            'error' => false,
            'message' => 'Referrals Found',
            'data' => $agents
        ], 200);
    }


}

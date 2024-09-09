<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agent;
use Log;
use Validator;
use Hash;
use Throwable;

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
            'is_master_agent' => 'required|boolean'
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
            'is_master_agent' => $request->is_master_agent
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
            \Log::error("AGENT CREATE ERROR: " . $th->getMessage());

            return response()->json([
                'error' => true,
                'errors' => null,
                'message' => 'Create Agent Error'
            ],500);
        }




    }

    public function getAllAgents(Request $request)
    {
        $query = Agent::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('street_addr', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        //Payload True or false
        if ($request->has('active_only') && !empty($request->active_only)) {
            $query->where('is_active', $request->active_only);
        }


        //Payload Any value
        if ($request->has('only_master_agent') && !empty($request->only_master_agent)) {
            $query->where('is_master_agent', true);
        }

        //Payload any value 
        if ($request->has('only_agent') && !empty($request->only_agent)) {
            $query->where('is_master_agent', false);    
        }

        $agents = $query->latest()->paginate(20);

        return response()->json([
            'error' => false,
            'data' => $agents,
            'message' => 'Agents retrieved successfully',
        ], 200);
    }

    public function getSingleAgent($id)
    {
        $agent = Agent::query();

        $agent = $agent->where('id', $id)->first();

        if(!$agent)
        {
            return response()->json([
                'error' => true,
                'errors' => null,
                'message' => 'Agent not found'
            ],404);
        }

        $agent->with([
            'createdBy', 
            'balanceLogs'
        ]);

        return response()->json([
            'error' => false,
            'data' => $agent,
            'message' => 'Agent retrieved successfully',
        ], 200);
    }
}

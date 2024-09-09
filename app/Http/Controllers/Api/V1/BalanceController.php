<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Agent;
use App\Models\AgentBalanceLog;

use Throwable;
use Illuminate\Support\Facades\DB;
class BalanceController extends Controller
{
    public function addBalance(Request $request)
    {
        $rules = [
            'agent_id' => 'required|exists:agents,id',
            'amount' => 'required|numeric',
            'remark' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {

            return response()->json([
                'error' => true,
                'errors' => $validator->errors(),
                'message' => 'Validation Error'
            ],400);
        }

        $agent = Agent::find($request->agent_id);

        if(!$agent)
        {
            return response()->json([
                'error' => true,
                'message' => 'Agent not found',
            ],404);
        }

        try{
            DB::beginTransaction();
            $agent->balance += $request->amount;

            $agent->save();

            AgentBalanceLog::create([
                'agent_id' => $agent->id,
                'amount' => $request->amount,
                'desc' => $request->remark
            ]);
            
            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Balance added successfully',
            ],200);
        }
        catch(Throwable $e)
        {
            DB::rollBack();

            \Log::info('Error while adding balance: '.$e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ],500);
        }


    }

    
}

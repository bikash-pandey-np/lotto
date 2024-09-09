<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Log;
use Throwable;
use Validator;
use Nilambar\NepaliDate\NepaliDate;

class EventController extends Controller
{
    public function createEvent(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'ticket_price' => 'nullable|numeric',
            'match_price_9' => 'nullable|numeric',
            'match_price_8' => 'nullable|numeric',
            'match_price_7' => 'nullable|numeric',
            'match_price_6' => 'nullable|numeric',
            'match_price_5' => 'nullable|numeric',
            'match_price_0' => 'nullable|numeric',
            'serial_match_price_9' => 'nullable|numeric',
            'serial_match_price_8' => 'nullable|numeric',
            'serial_match_price_7' => 'nullable|numeric',
            'serial_match_price_6' => 'nullable|numeric',
            'serial_match_price_5' => 'nullable|numeric',
            'serial_match_price_4' => 'nullable|numeric',
            'live_at_date' => 'required|date',
            'is_completed' => 'nullable|boolean',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json([
                'error' => true,
                'errors' => $validate->errors(),
                'message' => 'Validation Error'
            ], 400);
        }
        $obj = new NepaliDate();

        $eventData = [
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nepali_start_date' => $obj->convertAdToBs($request->start_date->year, $request->start_date->month, $request->start_date->day),
            'nepali_end_date' => $obj->convertAdToBs($request->end_date->year, $request->end_date->month, $request->end_date->day),
            'ticket_price' => $request->ticket_price,
            'match_price_9' => $request->match_price_9,
            'match_price_8' => $request->match_price_8,
            'match_price_7' => $request->match_price_7,
            'match_price_6' => $request->match_price_6,
            'match_price_5' => $request->match_price_5,
            'match_price_0' => $request->match_price_0,
            'serial_match_price_9' => $request->serial_match_price_9,
            'serial_match_price_8' => $request->serial_match_price_8,
            'serial_match_price_7' => $request->serial_match_price_7,
            'serial_match_price_6' => $request->serial_match_price_6,
            'serial_match_price_5' => $request->serial_match_price_5,
            'serial_match_price_4' => $request->serial_match_price_4,
            'live_at_date' => $request->live_at_date,
            'nepali_live_at_date' => $obj->convertBsToAd($request->live_at_date->year, $request->live_at_date->month, $request->live_at_date->day),
            'is_completed' => $request->is_completed ?? false,
        ];

        try {
            Event::create($eventData);

            return response()->json([
                'error' => false,
                'message' => 'Event Created Successfully',
                'errors' => null,
            ], 200);
        } catch (Throwable $th) {
            Log::error("EVENT CREATE ERROR: " . $th->getMessage());

            return response()->json([
                'error' => true,
                'errors' => null,
                'message' => 'Create Event Error'
            ], 500);
        }
    }

    public function updateEvent(Request $request, $id)
    {
        $rules = [
            'title' => 'sometimes|required',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'ticket_price' => 'sometimes|numeric',
            'match_price_9' => 'sometimes|numeric',
            'match_price_8' => 'sometimes|numeric',
            'match_price_7' => 'sometimes|numeric',
            'match_price_6' => 'sometimes|numeric',
            'match_price_5' => 'sometimes|numeric',
            'match_price_0' => 'sometimes|numeric',
            'serial_match_price_9' => 'sometimes|numeric',
            'serial_match_price_8' => 'sometimes|numeric',
            'serial_match_price_7' => 'sometimes|numeric',
            'serial_match_price_6' => 'sometimes|numeric',
            'serial_match_price_5' => 'sometimes|numeric',
            'serial_match_price_4' => 'sometimes|numeric',
            'live_at_date' => 'sometimes|required|date',
            'is_completed' => 'sometimes|boolean',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json([
                'error' => true,
                'errors' => $validate->errors(),
                'message' => 'Validation Error'
            ], 400);
        }

        $event = Event::find($id);
        if (!$event) {
            return response()->json([
                'error' => true,
                'message' => 'Event not found'
            ], 404);
        }

        $obj = new NepaliDate();
        $eventData = array_filter([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'nepali_start_date' => isset($request->start_date) ? $obj->convertAdToBs($request->start_date->year, $request->start_date->month, $request->start_date->day) : null,
            'nepali_end_date' => isset($request->end_date) ? $obj->convertAdToBs($request->end_date->year, $request->end_date->month, $request->end_date->day) : null,
            'ticket_price' => $request->ticket_price,
            'match_price_9' => $request->match_price_9,
            'match_price_8' => $request->match_price_8,
            'match_price_7' => $request->match_price_7,
            'match_price_6' => $request->match_price_6,
            'match_price_5' => $request->match_price_5,
            'match_price_0' => $request->match_price_0,
            'serial_match_price_9' => $request->serial_match_price_9,
            'serial_match_price_8' => $request->serial_match_price_8,
            'serial_match_price_7' => $request->serial_match_price_7,
            'serial_match_price_6' => $request->serial_match_price_6,
            'serial_match_price_5' => $request->serial_match_price_5,
            'serial_match_price_4' => $request->serial_match_price_4,
            'live_at_date' => $request->live_at_date,
            'nepali_live_at_date' => isset($request->live_at_date) ? $obj->convertBsToAd($request->live_at_date->year, $request->live_at_date->month, $request->live_at_date->day) : null,
            'is_completed' => $request->is_completed ?? false,
        ]);

        try {
            $event->update($eventData);

            return response()->json([
                'error' => false,
                'message' => 'Event Updated Successfully',
                'errors' => null,
            ], 200);
        } catch (Throwable $th) {
            Log::error("EVENT UPDATE ERROR: " . $th->getMessage());

            return response()->json([
                'error' => true,
                'errors' => null,
                'message' => 'Update Event Error'
            ], 500);
        }
    }

    public function getAllEvents(Request $request)
    {
        $query = Event::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('nepali_start_date', 'like', '%' . $request->search . '%')
                ->orWhere('nepali_end_date', 'like', '%' . $request->search . '%');
            });
        }


        //Payload True or false
        if ($request->has('is_completed') && !empty($request->is_completed)) {
            $query->where('is_completed', $request->is_completed);
        }

        $events = $query->latest()->paginate(10);

        return response()->json([
            'error' => false,
            'data' => $events,
            'message' => 'Events retrieved successfully',
        ], 200);
    }

    public function getEventById($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'error' => true,
                'message' => 'Event not found',
            ], 404);
        }

        return response()->json([
            'error' => false,
            'data' => $event,
            'message' => 'Event retrieved successfully',
        ], 200);
    }
}

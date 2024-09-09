<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AgentController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\BalanceController as AdminBalanceController;
use App\Http\Controllers\Api\V1\Agent\BalanceController;
use App\Http\Controllers\Api\V1\Agent\AgentController as AController;








Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admin routes
Route::prefix('admin-routes')->group(function () {

    Route::prefix('agents')->group(function () {
        Route::post('/create', [AgentController::class, 'createAgent']);

        Route::get('/', [AgentController::class, 'getAllAgents']);

        Route::get('/{id}', [AgentController::class, 'getSingleAgent']);
    });

    Route::prefix('events')->group(function () {
        Route::post('/create', [EventController::class, 'createEvent']);

        Route::post('/{id}/update', [EventController::class, 'updateEvent']);

        Route::get('/', [EventController::class, 'getAllEvents']);

        Route::get('/{id}', [EventController::class, 'getEventById']);
    });

    Route::prefix('balances')->group(function () {
        Route::get('/add', [AdminBalanceController::class, 'addBalance']);
    });


});



//routes for agents 
Route::prefix('agent-routes')->group(function () {

    //Login 

    //Get all events 
    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'getAllEvents']);
        Route::get('/{id}', [EventController::class, 'getEventById']);
    });

    //create agents/view created agents
    Route::prefix('agents')->group(function () {
        Route::get('/create-agent', [AController::class, 'createAgent']);
        Route::get('/referal-list', [AController::class, 'getReferrals']);
    });

});
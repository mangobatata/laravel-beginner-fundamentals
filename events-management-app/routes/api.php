<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas de eventos
// GET|POST  http://localhost:8000/api/events
// GET|PUT|DELETE http://localhost:8000/api/events/{event}
Route::apiResource('events', EventController::class);

// Rutas de asistentes de un evento
// GET|POST  http://localhost:8000/api/events/{event}/attendees
// GET|PUT|DELETE http://localhost:8000/api/events/{event}/attendees/{attendee}
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped(['attendee' => 'event']);

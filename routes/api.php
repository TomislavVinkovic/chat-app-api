<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Events\PlaygroundEvent;
use App\Events\ChatMessageEvent;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('chat', function (Request $request) {
        event(new ChatMessageEvent($request['message'], auth()->user()));
        return null;
    });
});

Route::get('playground', function () {
    event(new PlaygroundEvent());
    return null;
});
<?php

use App\Http\Controllers\TrelloController;
use App\Http\Controllers\TelegramController;
use App\Models\Trello;
use App\Telegram;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/webhook', [TelegramController::class, 'index']);
Route::post('/trello', [TrelloController::class, 'index']);

Route::get('/', function () {
    return view('home', ['lists' => Trello::getLists(config('trello.board_id'))]);
})->name('home');

Route::get('/webhook/create/telegram', [Telegram::class, 'setWebhook']);
Route::get('/webhook/create/trello', [TrelloController::class, 'createWebhook']);

Route::post('/card', [TrelloController::class, 'createCard']);
Route::post('/list', [TrelloController::class, 'createList']);

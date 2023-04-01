<?php

namespace App\Http\Controllers;

use App\Actions\Telegram\AnswerAction;
use App\Actions\Telegram\BindTrelloWithTelegramAction;
use App\Actions\Telegram\WelcomeAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function index(
        Request       $request,
        WelcomeAction $welcomeAction,
        AnswerAction  $answerAction,
        BindTrelloWithTelegramAction $bindTrelloWithTelegramAction
    )
    {
        $data = $request->input();

        if (isset($data['callback_query'])){
            $answerAction->handle($data);
        }elseif (isset($data['message'])){
            $welcomeAction->handle($data);
            $bindTrelloWithTelegramAction->handle($data);
        }

        return response()->json(true, 200);
    }
}

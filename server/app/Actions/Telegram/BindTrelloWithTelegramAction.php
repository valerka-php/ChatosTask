<?php

namespace App\Actions\Telegram;

use App\Models\Trello;
use App\Models\User;
use App\Telegram;
use Illuminate\Support\Facades\Log;

class BindTrelloWithTelegramAction
{
    protected Telegram $telegram;
    private ParseUserRequest $userRequest;
    private Trello $trello;

    public function __construct(Telegram $telegram, ParseUserRequest $userRequest, Trello $trello)
    {
        $this->telegram = $telegram;
        $this->userRequest = $userRequest;
        $this->trello = $trello;
    }

    public function handle(array $data)
    {
        $request = $this->userRequest->handle($data['message']['text']);

        if (is_array($request) && $request['key'] === 'trello') {

            $message = $data['message'];

            $trelloUser = $this->trello->getUser($request['value']);

            if ($trelloUser) {
                $user = User::find($message['from']['id']);
                $user->id_trello = $trelloUser['id'];
                $user->save();

                $this->telegram->sendMessage('Your trello account was linked to telegram', $message['from']['id']);

            } else {
                $this->telegram->sendMessage('This user doesn`t exist', $message['from']['id']);
            }
        }
    }
}

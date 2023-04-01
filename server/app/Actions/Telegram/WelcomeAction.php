<?php

namespace App\Actions\Telegram;

use App\Telegram;

class WelcomeAction
{
    protected CreateUserAction $createUserAction;
    protected Telegram $telegram;

    public function __construct(CreateUserAction $createUserAction, Telegram $telegram)
    {
        $this->telegram = $telegram;
        $this->createUserAction = $createUserAction;
    }

    public function handle(array $data)
    {
        if (isset($data['message']['text']) && $data['message']['text'] == '/start'){
            $message = $data['message'];

            $user = $this->createUserAction->handle($data['message']);

            $chat = $message['chat'];

            $text = "You are welcome -" . $user->first_name . ' ' . $user->last_name . "- Make your choice";

            $welcomeButtons = ['inline_keyboard' => [[
                [
                    'text' => 'Say hello',
                    'callback_data' => 'hello'
                ],
                [
                    'text' => 'Get a gift =^-^=',
                    'callback_data' => 'gift'
                ],
                [
                    'text' => 'Link Trello to Telegram',
                    'callback_data' => 'trello'
                ],
                [
                    'text' => 'Get user report',
                    'callback_data' => 'report'
                ]
            ]]];

            $this->telegram->sendButtons($text, $chat['id'], $welcomeButtons);
        }
    }
}

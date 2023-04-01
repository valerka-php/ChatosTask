<?php

namespace App\Actions\Telegram;

use App\Models\User;

class CreateUserAction
{
    public function handle(array $message)
    {
        $user = User::find($message['from']['id']);

        if (!$user) {
            $user = User::create($message['from']);
        }

        return $user;
    }
}

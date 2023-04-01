<?php

namespace App\Actions\Telegram;

use App\Models\User;
use App\Telegram;
use Illuminate\Support\Facades\Log;

class ReportAction
{
    private Telegram $telegram;

    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle()
    {
        $users = User::all();

        $result = [];

        foreach ($users as $user) {

            if ($this->telegram->checkUserInChat($user->id, config('telegram.group_id'))) {
                $result[$user->first_name] = $user->id;
            }
        }

        return $result;
    }
}

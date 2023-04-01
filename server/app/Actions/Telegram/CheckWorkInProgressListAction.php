<?php

namespace App\Actions\Telegram;

use App\Models\Trello;
use App\Models\TrelloList;
use App\Models\User;
use App\Telegram;
use Illuminate\Support\Facades\Log;

class CheckWorkInProgressListAction
{
    private Telegram $telegram;

    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(int|string $userId, int|string $chatId)
    {
        $workInProgressList = TrelloList::where('list_name', 'Work In Progress')->first();

        $user = User::find($userId);

        if ($user['id_trello'] === null) {
            $this->telegram->sendMessage('User has not trello', $chatId);
        }else{
            $cardsList = json_decode(Trello::getCards($workInProgressList->id_list)->body());

            $countCards = 0;

            foreach ($cardsList as $card) {
                foreach ($card->idMembers as $member) {
                    if ($member == $user->id_trello) {
                        $countCards++;
                    }
                }
            }

            $text = "User has $countCards tasks in status Work in Progress";

            $this->telegram->sendMessage($text, $chatId);
        }
    }
}

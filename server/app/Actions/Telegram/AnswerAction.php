<?php

namespace App\Actions\Telegram;

use App\Telegram;
use Illuminate\Support\Facades\Log;

class AnswerAction
{
    protected Telegram $telegram;
    private ReportAction $reportAction;
    private CreateButtonsFromArrayAction $createButtonsFromArrayAction;
    private ParseUserRequest $parseUserRequest;
    private CheckWorkInProgressListAction $checkWorkInProgressListAction;

    public function __construct(
        Telegram                      $telegram,
        ReportAction                  $reportAction,
        CreateButtonsFromArrayAction  $createButtonsFromArrayAction,
        ParseUserRequest              $parseUserRequest,
        CheckWorkInProgressListAction $checkWorkInProgressListAction
    )
    {
        $this->telegram = $telegram;
        $this->reportAction = $reportAction;
        $this->createButtonsFromArrayAction = $createButtonsFromArrayAction;
        $this->parseUserRequest = $parseUserRequest;
        $this->checkWorkInProgressListAction = $checkWorkInProgressListAction;
    }

    public function handle(array $data)
    {
        if (isset($data['callback_query'])) {
            $callbackQuery = $data['callback_query'];
            $chatId = $callbackQuery['from']['id'];

            if (stripos($callbackQuery['data'], ':')) {

                $parsedRequest = $this->parseUserRequest->handle($callbackQuery['data']);

                $key = $parsedRequest['key'];
                $value = $parsedRequest['value'];

                $callbackQuery['data'] = $key;
            }

            switch ($callbackQuery['data']) {
                case 'hello' :
                    $this->telegram->sendMessage('Hello - hello', $chatId);
                    break;
                case 'gift' :
                    $this->telegram->sendDocument('gift.jpg', $chatId);
                    break;
                case 'trello' :
                    $this->telegram->sendMessage('Write your trello ID or username - in format : "trello: your id or username" ', $chatId);
                    break;
                case 'report' :
                    $result = $this->reportAction->handle();
                    $buttons = $this->createButtonsFromArrayAction->handle($result);
                    $this->telegram->sendButtons('Choose user', $chatId, $buttons);
                    break;
                case 'userReport' :
                    $this->checkWorkInProgressListAction->handle($value, $chatId);
                    break;
            }
        }
    }
}

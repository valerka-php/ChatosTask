<?php

namespace App\Actions\Telegram;

class CreateButtonsFromArrayAction
{
    public function handle(array $array)
    {
        $result['inline_keyboard'] = [];

        foreach ($array as $key => $value) {
            $result['inline_keyboard'][] = [[
                'text' => $key,
                'callback_data' => "userReport:$value"
            ]];
        }

        return $result;
    }
}

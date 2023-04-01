<?php

namespace App\Actions\Telegram;

class ParseUserRequest
{
    public function handle(string $text)
    {
        if (stripos($text,':')) {
            $array = explode(':', $text);

            return [
                'key' =>  $array[0],
                'value' =>$array[1]
            ];
        }

        return $text;
    }
}

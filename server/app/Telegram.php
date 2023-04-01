<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    protected $http;
    protected $apiUrl;
    protected $secret;

    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->apiUrl = config('telegram.api');
        $this->secret = config('telegram.secret');
    }

    public function setWebhook()
    {
        $webhookUrl = "url=" . config('telegram.webhook') . '/webhook';
        $response = $this->http::post($this->apiUrl . $this->secret . "/setWebhook?" . $webhookUrl);
        $data = json_decode($response->body());

        return redirect()->back()->with('message', $data->description);
    }

    public function sendMessage(string $text, int|string $chatId, array $options = [])
    {
        $opt = [
            'chat_id' => "$chatId",
            'text' => $text,
            'parse_mode' => 'html',
        ];

        $this->http::post($this->apiUrl . $this->secret . "/sendMessage", array_merge($opt, $options));
    }

    public function sendButtons(string $text, int $chatId, array $buttons)
    {
        $this->http::post($this->apiUrl . $this->secret . "/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode($buttons)
        ]);
    }

    public function sendDocument(string $fileName, int $chatId)
    {
        $this->http::attach('document', Storage::get("/public/$fileName"), 'document.png')
            ->post($this->apiUrl . $this->secret . "/sendDocument", [
                'chat_id' => $chatId,
            ]);
    }

    public function checkUserInChat(int|string $userId, string $chatId)
    {
        return $this->http::post($this->apiUrl . $this->secret . "/getChatMember", [
            'chat_id' => $chatId,
            'user_id' => $userId
        ]);
    }
}

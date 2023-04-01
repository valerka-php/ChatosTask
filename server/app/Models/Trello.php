<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Trello extends Model
{
    use HasFactory;

    public static function getLists(string $idBoard)
    {
        $query = [
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        ];

        $response = Http::get("https://api.trello.com/1/boards/$idBoard/lists", $query);

        return json_decode($response->body(), true);
    }

    public function getUser(int|string $id)
    {
        $query = [
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        ];

        $response = Http::get("https://api.trello.com/1/members/$id", $query);

        return json_decode($response->body(), true);
    }

    public static function getCards(string $listId)
    {
        $query = array(
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        );

        return Http::get(
            "https://api.trello.com/1/lists/$listId/cards",
            $query
        );
    }
}

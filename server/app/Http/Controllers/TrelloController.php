<?php

namespace App\Http\Controllers;

use App\Models\Trello;
use App\Models\TrelloList;
use App\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrelloController extends Controller
{
    public function index(Request $request, Telegram $telegram, Trello $trello)
    {
        $action = $request->action;

        if (isset($action['data']['listBefore'])) {

            $user = $trello->getUser($action['idMemberCreator']);

            $data = $action['data'];

            $message = "User {" . $user['fullName'] . '} moved task {' . $data['card']['name'] . '} from : {' . $data['listBefore']['name'] . '} to : {' . $data['listAfter']['name'] . '}';

            $telegram->sendMessage($message, config('telegram.group_id'));
        }
    }

    public function createCard(Request $request)
    {
        $query = [
            'name' => $request->name,
            'idList' => $request->list,
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        ];

        $response = Http::post('https://api.trello.com/1/cards', $query,);

        if ($response->ok()) {
            return redirect()->route('home')->with('message', 'Card was created');
        }

        return redirect()->route('home')->with('message', 'Something went wrong');
    }

    public function createList(Request $request)
    {
        $query = [
            'name' => $request->name,
            'idBoard' => config('trello.board_id'),
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        ];

        $response = Http::post('https://api.trello.com/1/lists', $query,);

        if ($response->ok()) {

            TrelloList::create([
                'id_list' => $response['id'],
                'id_board' => $response['idBoard'],
                'list_name' => $response['name'],
            ]);

            return redirect()->route('home')->with('message', 'List was created');
        }

        return redirect()->route('home')->with('message', 'Something went wrong');
    }

    public function createWebhook()
    {
        $query = [
            'callbackURL' => config('trello.webhook') . '/trello',
            'idModel' => '6426d95f6befeddebaa0932e',
            'key' => config('trello.api_key'),
            'token' => config('trello.secret_key')
        ];

        $response = Http::post('https://api.trello.com/1/webhooks/', $query);

        dd($response->body());
    }

}

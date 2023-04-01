<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrelloList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = [
        'id_list',
        'id_board',
        'list_name'
    ];
}

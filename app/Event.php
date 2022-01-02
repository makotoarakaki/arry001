<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Event extends Model
{
    use Favoriteable, Sortable;

    public $sortable = [
        'price', 
        'updated_at'
    ];
}

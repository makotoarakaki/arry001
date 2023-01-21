<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Contract extends Model
{
    use Favoriteable, Sortable;

    public $sortable = [
        'updated_at'
    ];
}

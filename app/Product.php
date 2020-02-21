<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function mall()
    {
        return $this->belongsTo(Mall::class);
    }

}

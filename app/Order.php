<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function mall()
    {
        return $this->belongsTo(Mall::class);
    }

}

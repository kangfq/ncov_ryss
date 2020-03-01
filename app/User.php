<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['total_money'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function address()
    {
        return $this->hasMany(Address::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getTotalMoneyAttribute()
    {
        $order = Order::where('user_id', $this->id)->whereNotNull('pay_time')->get()->toArray();
        return array_sum(array_column($order, 'total_money'));
    }


}

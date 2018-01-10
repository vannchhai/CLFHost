<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Notification extends Authenticatable
{
    use Notifiable;


    protected $table = 'notification';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sender_id', 'reciever_id', 'key', 'value', 'status','main_id','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}

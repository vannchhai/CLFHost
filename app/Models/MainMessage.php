<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MainMessage extends Authenticatable
{
    use Notifiable;


    protected $table = 'main_message';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sender_id', 'reciever_id', 'created_at'
    ];
    
}

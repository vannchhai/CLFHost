<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Location extends Authenticatable
{
    use Notifiable;


    protected $table = 'location';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'country_code', 'location_name', 'longitude', 'latitude', 'feature_code', 'poputation', 'time_zone', 'item_id', 'active', 'created_at', 'updated_at'
    ];
    
}

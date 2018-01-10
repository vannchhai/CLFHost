<?php

namespace App\Http\Resources\views\user;

use Illuminate\Http\Resources\Json\Resource;

class user extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

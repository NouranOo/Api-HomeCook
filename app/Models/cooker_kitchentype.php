<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class cooker_kitchentype extends Model  
{
 
     protected $table="cooker_kitchentypes";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Cooker_id', 'KitchenType_id',
    ];
    protected $casts = [
       
        
    ];


   
}

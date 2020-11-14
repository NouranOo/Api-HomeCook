<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Meal_Photo extends Model  
{
 
     protected $table="meal_photos";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'CookerMeal_id', 'Photo','Created_at','Updated_at'
    ];
   
    protected $casts = [
        'CookerMeal_id' => 'int',
          
    ];
   
}

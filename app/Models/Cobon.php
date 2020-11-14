<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Cobon extends Model  
{
 
     protected $table="cobons";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code','Description','Percentage','isAvailable','Created_at','Updated_at'
    ];
    protected $casts = [
      
    ];
  
   

   
}

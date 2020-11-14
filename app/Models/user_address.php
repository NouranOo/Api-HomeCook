<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class user_address extends Model  
{
 
     protected $table="user_address";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'lat','lng','area','city','country'
    ];
    protected $casts = [
       
        
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }


   
}

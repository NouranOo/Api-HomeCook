<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Cart extends Model  
{
 
     protected $table="carts";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_id','Created_at','Updated_at'
    ];
    protected $casts = [
        'User_id' => 'int',
        
        
    ];
    public function User(){
        return $this->hasOne('App\Models\User','User_id');
    }
    public function CartItems(){
        return $this->hasOne('App\Models\CartItem','Cart_id');
    }

   
}

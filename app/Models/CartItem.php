<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class CartItem extends Model  
{
 
     protected $table="cartitems";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_id','Meal_id','Cart_id','Quantity','Created_at','Updated_at'
    ];
    protected $casts = [
        'User_id' => 'int',
        'Meal_id'=> 'int',
        'Cart_id'=> 'int',
        'Quantity'=> 'int',
        
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
    // public function User(){
    //     return $this->hasOne('App\Models\User','User_id');
    // }
    public function Cart(){
        return $this->hasOne('App\Models\CartItem','Cart_id');
    }
    public function Meal(){
        return $this->belongsTo('App\Models\Cooker_Meal','Meal_id');
    }
   
}

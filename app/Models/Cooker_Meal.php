<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Cooker_Meal extends Model  
{
 
     protected $table="cooker_meals";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Cooker_id', 'Title_en','Title_ar','Description_en','Description_ar','Ingredients_en',
        'Ingredients_ar','KitchenType_id','Price','Expected_time','Saturday','Sunday','Monday',
        'Tuesday','Wednesday','Thursday','Friday','Photo1','Photo2','Photo3','Photo4','Created_at','Updated_at'
    ];
    protected $casts = [
        'Cooker_id' => 'int',
        'KitchenType_id'=>'int',
        'Price'=>'float',
        
    ];
    public function Cooker(){
        return $this->belongsTo('App\Models\User','Cooker_id');
    }
    public function KitchenType(){
        return $this->belongsTo('App\Models\KitchenType','KitchenType_id');
    }
    public function Photos(){
        return $this->hasMany('App\Models\Meal_Photo','CookerMeal_id');
    }
    // public function Rates(){
    //     return $this->hasMany('App\Models\Rate','CookerMeal_id');
    // }
    public function CartItems(){
        return $this->hasMany('App\Models\CartItem','Meal_id');
    }

   
}

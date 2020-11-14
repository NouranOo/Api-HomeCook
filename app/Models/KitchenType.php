<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class KitchenType extends Model  
{
 
     protected $table="kitchentypes";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name_en', 'Name_ar','Created_at','Updated_at'
    ];
    public function CookerMeal(){
        return $this->hasOne('App\Models\Cooker_Meal','KitchenType_id');
    }
    public function cookers(){
        return $this->belongsToMany('App\Models\User','cooker_kitchentypes','KitchenType_id','Cooker_id');
    }

   
}

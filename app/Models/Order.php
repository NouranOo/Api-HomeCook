<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Order extends Model  
{
 
     protected $table="orders";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_id','Cooker_id', 'CookerMeal_id','OrderStatus_id','Total_price','Created_at','Updated_at'
    ];
    protected $casts = [
        'User_id' => 'int',
        'CookerMeal_id'=>'int',
        'OrderStatus_id'=>'int',
        'Total_price'=>'float',
        
    ];
    public function OrderStatus(){
        return $this->hasOne('App\Models\Order_Status','OrderStatus_id');
    }
    public function OrderDeatails(){
        return $this->hasOne('App\Models\Order_Detail','Order_id');
    }
    public function Cooker(){
        return $this->belongsTo('App\Models\User','Cooker_id');
    }
 
   
}

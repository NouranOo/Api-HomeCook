<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Order_Detail extends Model  
{
 
     protected $table="order_details";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Order_id', 'UserMeal_id','Quantity','Total_Price','Created_at','Updated_at'
    ];
    protected $casts = [
        'Order_id' => 'int',
        'UserMeal_id'=>'int',
        'Quantity'=>'int',
        'Total_Price'=>'float',
        
    ];
    public function Order(){
        return $this->belongsTo('App\Models\Order','Order_id');
    }
    
   

   
}

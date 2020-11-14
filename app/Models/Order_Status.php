<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
 

class Order_Status extends Model  
{
 
     protected $table="order_status";
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Description','Created_at','Updated_at'
    ];
   
    public function Order(){
        return $this->belongsTo('App\Models\Order','OrderStatus_id');
    }

   
}

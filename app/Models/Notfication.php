<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;



class Notfication extends Model  
{
 
     protected $table="notifications";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_id', 'Seen','Title','body',
        'notify_target_id','Type',
    ];
    protected $casts = [
    'User_id'=>'int'
    ];
    public function userFrom(){
      return $this->belongsTo('App\Models\User','notify_from');
    }
    

 
    
    

   
}

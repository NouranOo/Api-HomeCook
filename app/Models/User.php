<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        'Name', 'UserName', 'Kitchen_Name', 'Nationality', 'Phone', 'Late', 'Long',
        'Email', 'Photo', 'ApiToken', 'Token', 'IsAvailable', 'IsConfirmed',
        'HavePayment', 'National_ID', 'Bank_Account', 'UserType', 'VerifyCode',
        'IsVerified', 'Created_at', 'Updated_at', 'AvailableNotification', 'Area', 'City', 'Country'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'Password',
    ];

    protected $casts = [
        'Phone' => 'int',
        'Late' => 'float',
        'Long' => 'float',
        'IsAvailable' => 'int',
        'IsConfirmed' => 'int',
        'HavePayment' => 'int',
        'Bank_Account' => 'int',
        'National_ID' => 'int',


    ];

    protected $appends = ['rate'];

    public function CookerMeals()
    {
        return $this->hasMany('App\Models\Cooker_Meal', 'Cooker_id');
    }

    public function Notifications()
    {
        return $this->hasMany('App\Models\Notfication', 'notify_from');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart', 'User_id');
    }

    public function Orders()
    {
        return $this->hasMany('App\Models\Order', 'Cooker_id');
    }

    public function userRating()
    {
        return $this->hasMany('App\Models\Rate', 'User_id');
    }

    public function cookerRating()
    {
        return $this->hasMany('App\Models\Rate', 'Cooker_id');
    }

    public function kitchen_types()
    {
        return $this->belongsToMany('App\Models\KitchenType', 'cooker_kitchentypes', 'Cooker_id', 'KitchenType_id');
    }

    public function adress()
    {
        return $this->hasMany('App\Models\user_address', 'user_id');
    }

    public function getRateAttribute()
    {
        $r = count($this->cookerRating) == 0 ? 0 : ceil($this->cookerRating->sum('Rate') / count($this->cookerRating));

        return $r;
    }

}

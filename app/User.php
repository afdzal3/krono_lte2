<?php

namespace App;
use App\Shared\URHelper;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function state()
    {
        return $this->hasOne(State::class);
    }

    public function companyid()
    {
        return $this->belongsTo(Company::class,'company_id')->withDefault(['company_descr' => 'N/A']);
    }

    public function stateid()
    {
        return $this->belongsTo(State::class,'state_id');
    }

    public function punchList()
    {
        return $this->hasMany(StaffPunch::class);
    }

    public function userRecordLatest()
    {
        return $this->hasOne(UserRecord::class)->latest('upd_sap');
    }

    // public function getreg(){
    //      return URHelper::getRegion($this->perssubarea);
    //    }

       public function rs()
       {
           return $this->belongsTo(UserRecord::class,'id','user_id')->latest('upd_sap');
       }

       public function gajistaff()
       {
           return $this->belongsTo(Salary::class,'user_id','user_id')->latest('upd_sap');
       }

       public function otindistaff()
       {
           return $this->belongsTo(OtIndicator::class,'user_id','user_id')->latest('upd_sap');
       }
       public function report2()
       {
           // return $this->belongsTo(User::class,'reptto');
           return $this->belongsTo(UserRecord::class,'reptto','user_id')->latest('upd_sap');
       }


    public function userShiftPatternLatest()
    {
        return $this->hasOne(UserShiftPattern::class)->latest('upd_sap');
    }

    public function userOtIndicator()
    {
        return $this->hasOne(OtIndicator::class)->latest('upd_sap');
    }


}

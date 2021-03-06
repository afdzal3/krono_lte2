<?php

namespace App;
use App\Shared\URHelper;
use App\UserRecord;
use \Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class StaffPunch extends Model
{
  protected $dates = ['punch_in_time', 'punch_out_time'];

  public function detail()
  {
      return $this->hasMany(OvertimePunch::class, 'punch_id');
  }

  public function URpio(){//User record based on date punch in/out
    $dt = $this->punch_in_time;
    // dd($dt);
    $dt = new Carbon($dt->format('Y-m-d'));

    return URHelper::getUserRecordByDate($this->user_id,$dt);
  }
  public function URecord(){//based on OT date
    return $this->belongsTo(UserRecord::class, 'user_records_id');
  }

}

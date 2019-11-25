<?php

namespace App\Http\Controllers;

use App\Shared\UserHelper;
use App\User;
use App\StaffPunch;
use App\Overtime;
use App\OvertimeMonth;
use App\OvertimeDetail;
use App\OvertimeLog;
use App\OvertimePunch;
use Session;
use Illuminate\Http\Request;

class OvertimeController extends Controller{
    public function list(Request $req){
        $otlist = Overtime::where('user_id', $req->user()->id)->orderBy('status')->orderBy('date_expiry')->orderBy('date')->get();
        return view('staff.overtime', ['otlist' => $otlist]);
    }

    public function form(Request $req){
        // dd($req->session()->get('claim'));
        if($req->session()->get('claim')!=null){
            $day = UserHelper::CheckDay($req->user()->id, $req->session()->get('claim')->date);
            return view('staff.otform', ['draft' =>[], 'claim' => $req->session()->get('claim'), 'day' => $day]);
        }else if($req->session()->get('draft')!=null){
            $draft = $req->session()->get('draft');
            $day = UserHelper::CheckDay($req->user()->id, date('Y-m-d', strtotime($draft[6])));
            return view('staff.otform', ['draft' => $req->session()->get('draft'), 'day' => $day]);
        }else{
            return view('staff.otform', []);
        }
    }

    public function update(Request $req){
        $claim = Overtime::where('id', $req->inputid)->first();
        Session::put(['draft' => [], 'claim' => $claim]);
        return redirect(route('ot.form',[],false));
    }

    public function remove(Request $req){
        $claim = Overtime::where('id', $req->delid)->first();
        $updatemonth = OvertimeMonth::find($claim->month_id);
        $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)-((($claim->total_hour)*60)+$claim->total_minute);
        $updatemonth->hour = (int)($totaltime/60);
        $updatemonth->minute = ($totaltime%60);
        $updatemonth->save();
        OvertimeLog::where('ot_id',$req->delid)->delete();
        OvertimeDetail::where('ot_id',$req->delid)->delete();
        Overtime::find($req->delid)->delete();
        Session::put(['draft' => [], 'claim' => []]);
        return redirect(route('ot.list',[],false))->with([
            'feedback' => true,
            'feedback_text' => "Successfully deleted claim ".$claim->refno,
            'feedback_type' => "warning"
        ]);
    }

    public function submit(Request $req){
        $submit = true;
        $id = explode(" ", $req->submitid);
        for($i = 0; $i<count($id); $i++){
            $claim = Overtime::find($id[$i]);
            $month = OvertimeMonth::where('id', $claim->month_id)->first();
            $totalsubmit = ($month->hour*60+$month->minute);
            if($totalsubmit>(100*60)){
                $submit = false;
            }
        }
        if($submit){
            for($i = 0; $i<count($id); $i++){
                $updateclaim = Overtime::find($id[$i]);
                $execute = UserHelper::LogOT($id[$i], $req->user()->id, "Submitted ".$updateclaim->refno);   
                if($updateclaim->verifier_id==null){
                    $updateclaim->status = 'PA';
                }else{
                    $updateclaim->status = 'PV';
                }
                $updatemonth = OvertimeMonth::find($updateclaim->month_id);
                $totalsubmit = (($updatemonth->total_hour*60)+$updatemonth->total_minute)+(($updateclaim->total_hour*60)+$updateclaim->total_minute);
                $updatemonth->total_hour = (int)($totalsubmit/60);
                $updatemonth->total_minute = $totalsubmit%60;
                $updatemonth->save();
                $updateclaim->save();
            }
            
            return redirect(route('ot.list',[],false))->with([
                'feedback' => true,
                'feedback_text' => "Successfully submitted claim!",
                'feedback_type' => "success"
            ]);
        }else{
            return redirect(route('ot.list',[],false))->with(['error' => true]);
        }
        

        // $claim = Overtime::where('id', $req->delid)->first();
        // $updatemonth = OvertimeMonth::find($claim->month_id);
        // $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)+((($claim->hour)*60)+$claim->minute);
        // $updatemonth->hour = (int)($totaltime/60);
        // $updatemonth->minute = ($totaltime%60);
        // $updatemonth->save();
        // Overtime::find($req->delid)->delete();
        // Session::put(['draft' => [], 'claim' => []]);

        // if($updateclaim->verifier_id==null){
        //     $updateclaim->status = 'PA';
        // }else{
        //     $updateclaim->status = 'PV';
        // }
        // $updateclaim->save();
        // return redirect(route('ot.list',[],false))->with([
        //     'feedback' => true,
        //     'feedback_text' => "Successfully submitted claim!",
        //     'feedback_type' => "success"
        // ]);
    }

    public function formnew(Request $req){
        Session::put(['draft' => [], 'claim' => []]);
        return redirect(route('ot.form',[],false));
    }

    public function formdate(Request $req){
        Session::put(['draft' => []]);  
        $claim = Overtime::where('user_id', $req->user()->id)->where('date', $req->inputdate)->first();
        if(empty($claim)){
            $claimdate = $req->inputdate;
            $claimmonth = date("m", strtotime($claimdate));
            $claimyear = date("y", strtotime($claimdate));
            $claimday = date("l", strtotime($claimdate));
            $claimtime = OvertimeMonth::where('user_id', $req->user()->id)->where('year', $claimyear)->where('month', $claimmonth)->first();
            if(empty($claimtime)){
                $newmonth = new OvertimeMonth;
                $newmonth->user_id = $req->user()->id;
                $newmonth->year = $claimyear;
                $newmonth->month = $claimmonth;
                $newmonth->save();
                $claimtime = OvertimeMonth::where('user_id', $req->user()->id)->where('year', $claimyear)->where('month', $claimmonth)->first();
            }
            $punch = OvertimePunch::where('user_id', $req->user()->id)->where('date', $req->inputdate)->get();
            if(count($punch)!=0){
                $totalhour = 0;
                $totalminute = 0;
                $draftclaim = new Overtime;
                $draftclaim->refno = "OT".date("ymd", strtotime($claimdate))."-".sprintf("%08d", $req->user()->id)."-".rand(10000,99999);
                $draftclaim->user_id = $req->user()->id;
                $draftclaim->month_id = $claimtime->id;
                $draftclaim->date = $req->inputdate;
                $draftclaim->date_created = date("Y-m-d");
                $draftclaim->date_expiry = date('Y-m-d', strtotime("+90 days"));
                $draftclaim->approver_id = $req->user()->reptto;
                $draftclaim->verifier_id =  $req->user()->id; //temp
                $draftclaim->save();
                $claim = Overtime::where('user_id', $req->user()->id)->where('date', $req->inputdate)->first();
                foreach($punch as $punches){
                    $newclaim = new OvertimeDetail;
                    $newclaim->ot_id = $claim->id;
                    $newclaim->clock_in = $punches->start_time;
                    $newclaim->clock_out= $punches->end_time;
                    $newclaim->start_time = $punches->start_time;
                    $newclaim->end_time = $punches->end_time;
                    $newclaim->hour = $punches->hour;
                    $newclaim->minute = $punches->minute;
                    $newclaim->checked = "Y";
                    $pay = UserHelper::CalOT($req->user()->salary, $punches->hour, $punches->minute); 
                    $newclaim->amount = $pay;
                    $newclaim->justification = "Punch In/Out";
                    $updatemonth = OvertimeMonth::find($claimtime->id);
                    $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)+(($punches->hour*60)+$punches->minute);
                    $updatemonth->hour = (int)($totaltime/60);
                    $updatemonth->minute = ($totaltime%60);
                    $updateclaim = Overtime::find($claim->id);
                    $totaltime = (($updateclaim->total_hour*60)+$updateclaim->total_minute)+(($punches->hour*60)+$punches->minute);
                    $updateclaim->total_hour = (int)($totaltime/60);
                    $updateclaim->total_minute = ($totaltime%60);
                    $updateclaim->amount = $updateclaim->amount + $pay;
                    $newclaim->save();
                    $updatemonth->save();
                    $updateclaim->save();
                }
                $execute = UserHelper::LogOT($claim->id, $req->user()->id, "Created draft for ".$claim->refno);
                $claim = Overtime::where('user_id', $req->user()->id)->where('date', $req->inputdate)->first();
                Session::put(['draft' => []]);
            }else{
                $verify = User::where('id', $req->user()->id)->first();
                $approve = User::where('id', $req->user()->reptto)->first();
                $draft = array("OT".date("ymd", strtotime($claimdate))."-".sprintf("%08d", $req->user()->id)."-".rand(10000,99999), date('Y-m-d', strtotime("+90 days")), $verify->name, $approve->name, date("Y-m-d H:i:s"), $claimtime, $req->inputdate, $req->user()->name);
                //[0] - refno, [1] - expiry, [2] - verifier name, [3] - approver name, [4] - datetime created, [5] - month, [6] - date, [7] - user name
                Session::put(['draft' => $draft]); 
            }
        }else{
            Session::put(['draft' => []]);
        }
        Session::put(['claim' => $claim]);
        return redirect(route('ot.form',[],false));
    }
    
    public function formsubmit(Request $req){
        $status = true;
        if($req->inputid==""){
            $draftclaim = new Overtime;
            $draftclaim->refno = ($req->session()->get('draft'))[0];
            $draftclaim->user_id = $req->user()->id;
            $draftclaim->month_id = ($req->session()->get('draft'))[5]->id;
            $draftclaim->date = ($req->session()->get('draft'))[6];
            $draftclaim->date_created = date("Y-m-d", strtotime(($req->session()->get('draft'))[4]));
            $draftclaim->date_expiry = ($req->session()->get('draft'))[1];
            $draftclaim->total_hour = 0;
            $draftclaim->total_minute = 0;
            $draftclaim->amount = 0;
            $draftclaim->approver_id = $req->user()->reptto;
            $draftclaim->verifier_id =  $req->user()->id; //temp
            $draftclaim->status = 'D1';
            $draftclaim->save();
            $claim = Overtime::where('user_id', $req->user()->id)->where('date', ($req->session()->get('draft'))[6])->first();
            $execute = UserHelper::LogOT($claim->id, $req->user()->id, "Created draft for ".$claim->refno);    
            Session::put(['draft' => []]);
        }else{
            $claim = Overtime::where('id', $req->inputid)->first();
        }
        if($req->formadd=="add"){
            $dif = (strtotime($req->inputendnew) - strtotime($req->inputstartnew))/60;
            $hour = (int) ($dif/60);
            $minute = $dif%60;
            $pay = UserHelper::CalOT($req->user()->salary, $hour, $minute); 
            $newdetail = new OvertimeDetail;
            $newdetail->ot_id = $claim->id;
            $newdetail->start_time = $claim->date." ".$req->inputstartnew.":00";
            $newdetail->end_time = $claim->date." ".$req->inputendnew.":00";
            $newdetail->hour = $hour;
            $newdetail->minute = $minute;
            $newdetail->checked = "Y";
            $newdetail->amount = $pay;
            $newdetail->justification = $req->inputremarknew;
            $updatemonth = OvertimeMonth::find($claim->month_id);
            $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)+(($hour*60)+$minute);
            $updatemonth->hour = (int)($totaltime/60);
            $updatemonth->minute = ($totaltime%60);
            $updateclaim = Overtime::find($claim->id);
            $totaltime = (($updateclaim->total_hour*60)+$updateclaim->total_minute)+(($hour*60)+$minute);
            $updateclaim->total_hour = (int)($totaltime/60);
            $updateclaim->total_minute = ($totaltime%60);
            $updateclaim->amount = $updateclaim->amount + $pay;
            $newdetail->save();
            $updatemonth->save();
            $updateclaim->save();
        }
        if(($req->formsave=="save")||($req->formsubmit=="yes")){
            $claim = Overtime::where('id', $claim->id)->first();
            $claimdetail = OvertimeDetail::where('ot_id', $claim->id)->get();
            
            for($i=0; $i<count($claimdetail); $i++){
                // dd($req->start_time[$i]);
                if(($req->inputstart[$i]!="")&&$req->inputend[$i]!=""){
                    
                    $operation = null;
                    if(($req->inputremark[$i]=="")||($req->inputstart[$i]=="")||($req->inputend[$i]=="")){
                        $status = false;
                    }
                    $dif = (strtotime($req->inputend[$i]) - strtotime($req->inputstart[$i]))/60;
                    $hour = (int) ($dif/60);
                    $minute = $dif%60;
                    $pay = UserHelper::CalOT($req->user()->salary, $hour, $minute); 
                    $updatedetail = $claimdetail[$i];
                    $updatedetail->start_time = $claim->date." ".$req->inputstart[$i].":00";
                    $updatedetail->end_time = $claim->date." ".$req->inputend[$i].":00";
                    if($updatedetail->checked != $req->inputcheck[$i]){
                        $updatedetail->checked = $req->inputcheck[$i];
                        $operation = $req->inputcheck[$i];
                    }
                    $updatedetail->justification = $req->inputremark[$i];
                    $updatemonth = OvertimeMonth::find($claim->month_id);
                    $updateclaim = Overtime::find($claim->id);
                    if($operation=="Y"){
                        $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)+(($hour*60)+$minute);
                        $updatemonth->hour = (int)($totaltime/60);
                        $updatemonth->minute = ($totaltime%60);
                        $totaltime = (($updateclaim->total_hour*60)+$updateclaim->total_minute)+(($hour*60)+$minute);
                        $updateclaim->total_hour = (int)($totaltime/60);
                        $updateclaim->total_minute = ($totaltime%60);
                        $updateclaim->amount = $updateclaim->amount + $pay;
                    }elseif($operation=="N"){
                        $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)-(($hour*60)+$minute);
                        $updatemonth->hour = (int)($totaltime/60);
                        $updatemonth->minute = ($totaltime%60);
                        $totaltime = (($updateclaim->total_hour*60)+$updateclaim->total_minute)-(($hour*60)+$minute);
                        $updateclaim->total_hour = (int)($totaltime/60);
                        $updateclaim->total_minute = ($totaltime%60);
                        $updateclaim->amount = $updateclaim->amount - $pay;
                    }else{
                        $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)-(($updatedetail->hour*60)+$updatedetail->minute)+(($hour*60)+$minute);
                        $updatemonth->hour = (int)($totaltime/60);
                        $updatemonth->minute = ($totaltime%60);
                        $totaltime = (($updateclaim->total_hour*60)+$updateclaim->total_minute)-(($updatedetail->hour*60)+$updatedetail->minute)+(($hour*60)+$minute);
                        $updateclaim->total_hour = (int)($totaltime/60);
                        $updateclaim->total_minute = ($totaltime%60);
                        $updateclaim->amount = $updateclaim->amount - $updatedetail->amount + $pay;
                    }
                    $updatedetail->checked = $req->inputcheck[$i];
                    $updatedetail->amount = $pay;
                    $updatedetail->hour = $hour;
                    $updatedetail->minute = $minute;
                    $updatedetail->save();
                    $updatemonth->save();
                    $updateclaim->save();
                }
            }
        }
        
        if(($req->chargetype=="")||($req->inputjustification=="")){
            $status = false;
        }
        
        // dd($status);
        $updateclaim = Overtime::find($claim->id);
        if($status){
            if($updateclaim->status=="D1"){
                $updateclaim->status = 'D2';
            }elseif($updateclaim->status=="Q1"){
                $updateclaim->status = 'Q2';
            }
        }else{
            if($updateclaim->status=="D2"){
                $updateclaim->status = 'D1';
            }elseif($updateclaim->status=="Q2"){
                $updateclaim->status = 'Q1';
            }
        }
        $updateclaim->charge_type = $req->chargetype;
        $updateclaim->justification = $req->inputjustification;
        // if($req->formsubmit=="yes"){
        //     if($updateclaim->verifier_id==null){
        //         $updateclaim->status = 'PA';
        //     }else{
        //         $updateclaim->status = 'PV';
        //     }
        // }

        $updateclaim->save();
        // dd($claimdetail[0]);

        $claim = Overtime::where('id', $claim->id)->first();
        Session::put(['claim' => $claim]);
        if($req->formadd=="add"){ //if add only
            return redirect(route('ot.form',[],false))->with([
                'feedback' => true,
                'feedback_text' => "Successfully added a new time!",
                'feedback_type' => "success"
            ]);
        }
        if($req->formsave=="save"){ //if save only
            return redirect(route('ot.form',[],false))->with([
                'feedback' => true,
                'feedback_text' => "Successfully saved claim!",
                'feedback_type' => "success"
            ]);
        }
        if($req->formsubmit=="yes"){ //if submit
            $month = OvertimeMonth::where('id', $claim->month_id)->first();
            $totalsubmit = (($claim->total_hour*60)+$claim->total_minute)+(($month->total_hour*60)+$month->total_minute);
            if($totalsubmit>(104*60)){
                return redirect(route('ot.form',[],false))->with(['error' => true]);
            }
            else{
                $updatemonth = OvertimeMonth::find($month->id);
                $updatemonth->total_hour = (int)($totalsubmit/60);
                $updatemonth->total_minute = $totalsubmit%60;
                $updatemonth->save();
                $updateclaim = Overtime::find($claim->id);
                $execute = UserHelper::LogOT($claim->id, $req->user()->id, "Submitted ".$updateclaim->refno);   
                if($updateclaim->verifier_id==null){
                    $updateclaim->status = 'PA';
                }else{
                    $updateclaim->status = 'PV';
                }
                $updateclaim->save();
                return redirect(route('ot.list',[],false))->with([
                    'feedback' => true,
                    'feedback_text' => "Successfully submitted claim!",
                    'feedback_type' => "success"
                ]);
            }
        }
    }

    public function formdelete(Request $req){
        $claimdetail = OvertimeDetail::where('id', $req->delid)->first();
        $claim =  Overtime::where('id', $claimdetail->ot_id)->first();
        $start = $claim->start_time;
        $end = $claim->end_time;
        $updatemonth = OvertimeMonth::find($claim->month_id);
        $updateclaim = Overtime::find($claim->id);
        $totaltime = (($updatemonth->hour*60)+$updatemonth->minute)-((($claimdetail->hour)*60)+$claimdetail->minute);
        $updatemonth->hour = (int)($totaltime/60);
        $updatemonth->minute = ($totaltime%60);
        $totaltime = (($updateclaim->total_hour*60)+$claimdetail->total_minute)-((($claimdetail->hour)*60)+$claim->minute);
        $updateclaim->total_hour = (int)($totaltime/60);
        $updateclaim->total_minute = ($totaltime%60);
        $updateclaim->amount = $updateclaim->amount - $claimdetail->amount;
        OvertimeDetail::find($req->delid)->delete();
        $claimdetail = OvertimeDetail::where('ot_id', $claim->id)->get();
        if(count($claimdetail)==0){
            $updateclaim->status = 'D1';
        }
        $updatemonth->save();
        $updateclaim->save();
        $claim = Overtime::where('id', $claim->id)->first();
        Session::put(['claim' => $claim]);
        return redirect(route('ot.form',[],false))->with([
            'feedback' => true,
            'feedback_text' => "Successfully deleted time ".$start."-".$end.".",
            'feedback_type' => "warning"
        ]);
    }

    public function approval(Request $req){
        $otlist = Overtime::where('verifier_id', $req->user()->id)->where('status', 'PV')->orWhere('approver_id', $req->user()->id)->where('status', 'PA')->orderBy('date_expiry')->orderBy('date')->get();
        return view('staff.otquery', ['otlist' => $otlist]);
    }

    public function query (Request $req){
        $otlist = Overtime::where('verifier_id', $req->user()->id)->where('status', 'PV')->orWhere('approver_id', $req->user()->id)->where('status', 'PA')->orderBy('date_expiry')->orderBy('date')->get();
        for($i=0; $i<count($otlist); $i++){
            if($req->inputaction[$i]!=""){
                $updateclaim = Overtime::find($req->inputid[$i]);
                $updateclaim->status=$req->inputaction[$i];
                if($req->inputaction[$i]=="PA"){
                    $updateclaim->date_expiry = date('Y-m-d', strtotime("+90 days"));
                    $execute = UserHelper::LogOT($req->inputid[$i], $req->user()->id, 'Verified ("'.$req->inputremark[$i].'")');  
                }else if($req->inputaction[$i]=="A"){
                    $execute = UserHelper::LogOT($req->inputid[$i], $req->user()->id, 'Approved ("'.$req->inputremark[$i].'")');  
                }else if($req->inputaction[$i]=="Q2"){
                    $updatemonth = OvertimeMonth::find($updateclaim->month_id);
                    $totaltime = (($updatemonth->total_hour*60)+$updatemonth->total_minute) - (($updateclaim->total_hour*60)+$updateclaim->total_minute);
                    $updatemonth->total_hour = (int)($totaltime/60);
                    $updatemonth->total_minute = ($totaltime%60);
                    $updatemonth->save();

                    // dd($updatemonth->total_hour);
                    $execute = UserHelper::LogOT($req->inputid[$i], $req->user()->id, 'Queried with message: "'.$req->inputremark[$i].'"');
                    $updateclaim->date_expiry = date('Y-m-d', strtotime("+90 days"));  
                }
                $updateclaim->save();
            }
        }
        return redirect(route('ot.approval',[],false));
    }
}
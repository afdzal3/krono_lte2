@extends('adminlte::page')

@section('title', 'My Work Schedule')

@section('content')
<h1>Team Work Schedule</h1>
<div class="row-eq-height">
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
    <a href="{{route('staff.worksched')}}">
    <div class="box box-solid box-primary">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/calendar.jpg" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>My Work Schedule<Br>(Normal Employee)</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'myc'])}}">
    <div class="box box-solid box-primary">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/calendar.jpg" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>View My Monthly Work Schedule<Br>(Shift Employee)</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'teamc'])}}">
    <div class="box box-solid box-primary">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/wsr-team-sched.png" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>View Team Work Schedule<Br>(Shift Employee)</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  {{-- 2-{{$usrWorkSche}} --}}
  {{-- @if(isset($usrWorkSche) && $usrWorkSche == 1)
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'reqs'])}}">
    <div class="box box-solid box-primary">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/wsr-cr-status.png" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>View Status of Change Request</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  @endif --}}
</div>

<div class="panel panel-primary">
<div class="panel-heading">Team Work Schedule for Month of <span class="text-yellow">{{ $mon }} {{ $yr }}</span>
     <div class="pull-right">
      <form method="GET" action="{{ route('staff.worksched',[],false) }}">
        @csrf
        <input type="hidden" name="page" value="teamc" />
      <input type="hidden" name="mon" value="{{ $monNext }}" />
      {{-- <button type="submit" class="btn btn-xs btn-default">Next</button> --}}
      <button type="submit" class="btn btn-up" style="margin-top:3px;">Next</button>
    </form>
    {{-- {{route('staff.worksched', ['page' => 'teamc','mon' => $monNext])}} --}}
    </div>
    <div class="pull-right">
      <form method="GET" action="{{ route('staff.worksched',[],false) }}">
        @csrf
        <input type="hidden" name="page" value="teamc" />
      <select name="mon"  class="btn btn-up"  style="margin-top:3px;" onchange="this.form.submit()">
        @for($monStart=1; $monStart <= 12; ++$monStart)
          <option value="{{ date('Y-m-d', mktime(0, 0, 0, $monStart, 1,$yr)) }}" 
          @if(date('n',strtotime($mon)) == $monStart)
          selected
          @endif
          >{{ date('F', mktime(0, 0, 0, $monStart, 1,$yr)) }}</option>
        @endfor
        </select> 
      </form>
      </div>
     <div class="pull-right">
      <form method="GET" action="{{ route('staff.worksched',[],false) }}">
        @csrf
        <input type="hidden" name="page" value="teamc" />
        <input type="hidden" name="mon" value="{{ $monPrev }}" />
        {{-- <button type="submit" class="btn btn-xs btn-default">Prev</button> --}}
        <button type="submit" class="btn btn-up" style="margin-top:3px;">Prev</button>
      </form>
    </div>
  </div>
  <div class="panel-body p-3">
    <div class="table-responsive">
      <table id="tbltwsc" class="table table-bordered table-condensed table-striped table-hover cell-border" style="white-space: nowrap;">
        <thead>
          <tr>
            @foreach($header as $h)
            <th style="border:1pt solid black !important;">{{ $h }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach($staffs as $s)
          <tr>
            <td>{{ $s['staffno'] }}</td>
            <td style="text-align: left !important;">{{ $s['name'] }}</td>
            @foreach($s['data'] as $h)
            <td><b>@if($h['dtype']=="N") Normal Day<br /> @elseif($h['dtype']=="O") Off Day<br /> @elseif($h['dtype']=="R") Rest Day<br /> @endif</b>
              {{ $h['time'] }}</td>
            @endforeach
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@stop

@section('js')
<script type="text/javascript">

$(document).ready(function() {
  $('#tbltwsc').DataTable();
} );


</script>
@stop

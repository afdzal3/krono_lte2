@extends('adminlte::page')

@section('title', 'My Work Schedule')

@section('content')
<h1>My Work Schedule</h1>

<div class="row-eq-height">
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'myc'])}}">
    <div class="box box-solid">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/calendar.jpg" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>View My Monthly Work Schedule</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'teamc'])}}">
    <div class="box box-solid">
    <div class="box-body">
    <div class="media">
      <div class="media-left">
        <img src="vendor/ot-assets/wsr-team-sched.png" class="media-object" style="width:50px;height:50px">
      </div>
      <div class="media-body">
        <p>View Team Work Schedule</p>
      </div>
    </div>
    </div><!-- /.box-body -->
    </div>
  </a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12 noPaddingLeft">
  <a href="{{route('staff.worksched', ['page' => 'reqs'])}}">
    <div class="box box-solid">
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
</div>

<div class="panel panel-primary">
  <div class="panel-heading">My Monthly Work Schedule for Month of <span class="text-yellow">{{ $mon }}</span></div>
  <div class="panel-body p-3">
    <div class="table-responsive">
      <table class="table table-bordered table-condensed" style="white-space: nowrap;">
        <thead>
          <tr>
            @foreach($header as $h)
            <th>{{ $h }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach($data as $h)
            <td><b>{{ $h['type'] }}</b><br />{{ $h['time'] }}</td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@stop

@section('js')
<script type="text/javascript">

$(document).ready(function() {

} );


</script>
@stop

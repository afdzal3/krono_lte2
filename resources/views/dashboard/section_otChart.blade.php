<div class="row row-eq-height">
    <div class="col-md-6 col-sm-6 col-xs-12 ">
    
      <div class="box box-solid">
        <div class="box-header bg-blue-active color-palette">
        <h3 class="box-title text-left">OT year {{ date('Y', strtotime(now())) }}</h3>
        </div>
        <div class="box-body">
          <div class="media">
            <div class="media-body">
              {!! $otYearChart->render() !!}
            </div>
          </div>
          </div>
          </div>
    
    
    </div>
    </div> 
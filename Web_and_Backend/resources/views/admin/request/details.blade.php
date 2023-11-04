@extends('admin.template')
@section('main')
 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content-header">
        <h1>
       Request Details
        <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Request Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Request Details</h3>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body">            
              <div class="col-md-8">
                    <dl class="row">
                        <input type="hidden" id='pickup_latitude' value="{{@$request_details->pickup_latitude}}">
                        <input type="hidden" id='pickup_longitude' value="{{@$request_details->pickup_longitude}}">
                        <input type="hidden" id='drop_latitude' value="{{@$request_details->formatted_drop_latitude}}">
                        <input type="hidden" id='drop_longitude' value="{{@$request_details->formatted_drop_longitude}}">
                        <input type="hidden" id='trip_path' value="{{$trip_path}}">
                        
                      
                    </dl>
                </div>
                <div class="col-md-4">
                    <div id="map" class="hide"></div>
                    @if(isset($is_tripped))
                        <img src="{{ $trip_data->map_image }}" data-original_src="{{ $trip_data->getOriginal('map_image') }}" class="img trip_image" id="trip_image">
                    @endif
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@push('scripts')
<style type="text/css">
    .trip_image {
        width: 100%;
        margin-top: 2rem;
    }
    #map {
        height: 500px;
        width: 100%;
    }
    dl.row {
        font-size: 15px;
    }
    dl dt, dl dd{
        padding: 5px;
    }  
</style>
@endpush

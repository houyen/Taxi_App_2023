


@extends('admin.template')

@section('main')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Bảng điều khiển</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  @if(LOGIN_USER_TYPE=='company' || auth('admin')->user()->can('manage_trips'))
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box">
          <div class="inner">
            <p>Total Earnings</p>
            <h3> {{ html_string($currency_code) }} {{ round($total_revenue) }}</h3>
          </div>
          <div class="icon">
            <i class="fa fa-dollar"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>

      @if(LOGIN_USER_TYPE == 'company')
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/statements/overall') }}" class="small-box">
          <div class="inner">
            <p> Received Amount </p>
            <h3>{{ html_string($currency_code) }} {{ round($admin_paid_amount) }}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-dollar"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/statements/overall') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      @endif

      @if(LOGIN_USER_TYPE!='company')
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url('admin/rider') }}" class="small-box">
          <div class="inner">
            <p>Total Riders</p>
            <h3>{{ $total_rider }}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <!-- <a href="{{ url('admin/rider') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      @endif

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/driver') }}" class="small-box">
          <div class="inner">
            <p>Total Tài xế</p>
            <h3>{{$total_driver}}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-user-plus"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/driver') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box">
          <div class="inner">
            <p>Total Trips</p>
            <h3>{{$total_trips}}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-cab"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      <!-- ./col -->
    </div>
    <!-- ./col -->
    <!-- /.row -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box">
          <div class="inner">
            <p>Today Earnings</p>
            <h3> {{ html_string($currency_code) }} {{ round($today_revenue) }}</h3>
          </div>
          <div class="icon">
            <i class="fa fa-dollar"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      <!-- ./col -->
      <!-- ./col -->
      @if(LOGIN_USER_TYPE!='company')
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url('admin/rider') }}" class="small-box">
          <div class="inner">
            <p>Today Riders</p>
            <h3>{{ $today_rider_count }}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <!-- <a href="{{ url('admin/rider') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      @endif
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/driver') }}" class="small-box">
          <div class="inner">
            <p>Today Tài xế</p>
            <h3>{{$today_driver_count}}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-user-plus"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/driver') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box">
          <div class="inner">
            <p>Today Trips</p>
            <h3>{{$today_trips}}</h3>

          </div>
          <div class="icon">
            <i class="fa fa-cab"></i>
          </div>
          <!-- <a href="{{ url(LOGIN_USER_TYPE.'/trips') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </a>
      </div>

    </div>
    <!-- /.row -->
    <!-- Main row -->

    <!-- /.row (main row) -->
  </section>
  <!-- /.content -->


 @else
 <div style="height: 80vh;text-align: center;padding-top: 150px;font-size: 15px;">
  Welcome to Dispatcher panel
</div>
@endif
<input type="hidden" class="form-control" placeholder="">
</div>
<!-- /.content-wrapper -->
@stop
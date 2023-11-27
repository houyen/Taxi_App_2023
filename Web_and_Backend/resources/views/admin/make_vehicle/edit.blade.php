@extends('admin.template')
@section('main')
<div class="content-wrapper" ng-controller="driver_management">
  <section class="content-header">
    <h1> Sửa hãng xe  </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ url(LOGIN_USER_TYPE.'/vehicle_make') }}">Hãng xe</a></li>
        <li class="active">Edit</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Sửa hãng xe</h3>
          </div>
          {!! Form::open(['url' => LOGIN_USER_TYPE.'/edit-vehicle-make/'.$result->id, 'class' => 'form-horizontal','files' => true]) !!}
          <div class="box-body">
            <span class="text-danger">(*)Trường bắt buộc</span>
            <div class="form-group">
              <label for="input_first_name" class="col-sm-3 control-label">Hãng xe<em class="text-danger">*</em></label>
              <div class="col-md-7 col-sm-offset-1">
                {!! Form::text('make_vehicle_name', $result->make_vehicle_name, ['class' => 'form-control', 'id' => 'input_make_name', 'placeholder' => 'Make Name']) !!}
                <span class="text-danger">{{ $errors->first('make_vehicle_name') }}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="input_status" class="col-sm-3 control-label">Trạng thái<em class="text-danger">*</em></label>
              <div class="col-md-7 col-sm-offset-1">
                {!! Form::select('status', array('Active' => 'Hoạt động', 'Inactive'  => 'Ẩn'), $result->status, ['class' => 'form-control', 'id' => 'input_status', 'placeholder'  => 'Chọn']) !!}
                <span class="text-danger">{{ $errors->first('status') }}</span>
              </div>
            </div>
          </div>
          <div class="box-footer text-center">
            <button type="submit" class="btn btn-info" name="submit" value="submit">Xác nhận </button>
             <a href="{{ url(LOGIN_USER_TYPE.'/vehicle_make')  }}" class="btn btn-default">Huỷ bỏ</a>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

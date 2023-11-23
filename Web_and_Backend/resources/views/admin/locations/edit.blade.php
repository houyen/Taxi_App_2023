@extends('admin.template')
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Sửa toạ độ
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li><a href="{{ url('admin/locations') }}">Toạ độ</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content" ng-controller='manage_locations'>
    <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Sửa toạ độ</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          {!! Form::open(['url' => 'admin/edit_location/'.$result->id, 'class' => 'form-horizontal form']) !!}
          <div class="box-body" ng-init="formatted_coords={{ json_encode(old('formatted_coords',$result->co_ordinates)) }};coordinates=[]">
            <span class="text-danger">(*)Trường bắt buộc</span>
            <div class="form-group">
              <label for="input_name" class="col-sm-3 control-label">
                Tên <em class="text-danger">*</em>
              </label>
              <div class="col-md-7 col-sm-offset-1">
                {!! Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'input_name', 'placeholder' => 'Tên']) !!}
                <span class="text-danger">{{ $errors->first('name') }}</span>
              </div>
            </div>
            <div class="form-group">
              <label for="input_status" class="col-sm-3 control-label">
                Trạng thái <em class="text-danger">*</em>
              </label>
              <div class="col-md-7 col-sm-offset-1">
                {!! Form::select('status', array('Active' => 'Hoạt động', 'Inactive' => 'Ẩn'), $result->status, ['class' => 'form-control', 'id' => 'input_status', 'placeholder' => 'Chọn']) !!}
                <span class="text-danger">{{ $errors->first('status') }}</span>
              </div>
            </div>
          {{ Form::hidden('coordinates', '', ['class' => 'coordinates','ng-model' => 'coordinates','ng-value' => 'coordinates']) }}
          </div>
          <div class="box-body">
            <span class="text-danger">{{ old('location_set') }}</span>
            <span class="text-danger">{{ $errors->first('coordinates') }}</span>
            <input id="pac-input" class="controls hide" type="text" placeholder="Search here" style="padding: 5px;margin: 5px;">
            <div id="map" style="height: 500px;width: 100%;"></div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <button type="submit" class="btn btn-info" name="submit" value="submit">Xác nhận </button>
            <a href="{{ url('admin/locations') }}" class="btn btn-default" name="cancel" value="Huỷ bỏ">
              Huỷ bỏ
            </a>
          </div>
          <!-- /.box-footer -->
          {!! Form::close() !!}
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop
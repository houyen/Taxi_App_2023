@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Currency
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ url(LOGIN_USER_TYPE.'/currency') }}">Currency</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Currency Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              {!! Form::open(['url' => 'admin/edit_currency/'.$result->id, 'class' => 'form-horizontal']) !!}
              <div class="box-body">
              <span class="text-danger">(*)Trường bắt buộc</span>
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">Name<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'input_name', 'placeholder' => 'Name']) !!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_code" class="col-sm-3 control-label">Code<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('code', $result->code, ['class' => 'form-control', 'id' => 'input_code', 'placeholder' => 'Code']) !!}
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_symbol" class="col-sm-3 control-label">Symbol<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('symbol', $result->symbol, ['class' => 'form-control', 'id' => 'input_symbol', 'placeholder' => 'Symbol']) !!}
                    <span class="text-danger">{{ $errors->first('symbol') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_rate" class="col-sm-3 control-label">Rate<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('rate', $result->rate, ['class' => 'form-control', 'id' => 'input_rate', 'placeholder' => 'Rate']) !!}
                    <span class="text-danger">{{ $errors->first('rate') }}</span>
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
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" class="btn btn-info" name="submit" value="submit">Xác nhận </button>
                 <button type="submit" class="btn btn-default" name="cancel" value="cancel">Huỷ bỏ</button>
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
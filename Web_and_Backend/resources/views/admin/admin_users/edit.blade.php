@extends('admin.template')

@section('main')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Admin User
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="{{ url(LOGIN_USER_TYPE.'/admin_user') }}">Admin Users</a></li>
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
              <h3 class="box-title">Edit Admin User Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              {!! Form::open(['url' => 'admin/edit_admin_users/'.$result->id, 'class' => 'form-horizontal']) !!}
              <div class="box-body">
              <span class="text-danger">(*)Trường bắt buộc</span>
                <div class="form-group">
                  <label for="input_username" class="col-sm-3 control-label">Username<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('username', $result->username, ['class' => 'form-control', 'id' => 'input_username', 'placeholder' => 'Username']) !!}
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_email" class="col-sm-3 control-label">Email<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('email', $result->email, ['class' => 'form-control', 'id' => 'input_email', 'placeholder' => 'Email']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_password" class="col-sm-3 control-label">Mật khẩu</label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('password', '', ['class' => 'form-control', 'id' => 'input_password', 'placeholder' => 'Mật khẩu']) !!}
                    <em>Enter new password only. Leave blank to use existing password.</em>
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_country_code" class="col-sm-3 control-label">
                    Quốc tịch  <em class="text-danger">*</em>
                  </label>
                  <div class="col-md-7 col-sm-offset-1">
                    <select class='form-control' id = 'input_country_code' name='country_code' >
                      <option value="" disabled> Select </option>
                      @foreach($countries as $country_code)
                        <option value="{{@$country_code->id}}" {{ $country_code->id == $result->country_id ? 'Selected' : ''}} >{{$country_code->long_name}}</option>
                      @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('country_code') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_mobile_number" class="col-sm-3 control-label">Số điện thoại (For SOS Purpose) <em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::text('mobile_number', old('mobile_number',$result->mobile_number), ['class' => 'form-control', 'id' => 'input_mobile', 'placeholder' => 'Mobile']) !!}
                    <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="input_role" class="col-sm-3 control-label">Role<em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::select('role', $roles, @$result->roles->first()->id, ['class' => 'form-control', 'id' => 'input_role', 'placeholder'  => 'Chọn']) !!}
                    <span class="text-danger">{{ $errors->first('role') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_status" class="col-sm-3 control-label">Trạng thái<em class="text-danger">*</em></label>

                  <div class="col-md-7 col-sm-offset-1">
                    {!! Form::select('status', array('Active' => 'Hoạt động', 'Inactive'  => 'Ẩn'), $result->status, ['class' => 'form-control', 'id' => 'input_status']) !!}
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" class="btn btn-info " name="submit" value="submit">Xác nhận </button>
                <button type="submit" class="btn btn-default" name="cancel" value="cancel">Huỷ bỏ</button>
              </div>
              <!-- /.box-footer -->
            </form>
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

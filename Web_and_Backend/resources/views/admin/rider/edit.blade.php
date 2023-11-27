@extends('admin.template')
@section('main')

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #a1ca3f;
}

input:focus + .slider {
  box-shadow: 0 0 1px #a1ca3f;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="content-wrapper" ng-controller="destination_admin">
	<section class="content-header">
		<h1> Edit Rider </h1>
		<ol class="breadcrumb">
			<li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ </a></li>
			<li><a href="{{ url(LOGIN_USER_TYPE.'/rider') }}"> Khách hàng </a></li>
			<li class="active"> Edit </li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Sửa thông tin</h3>
					</div>
					{!! Form::open(['url' => 'admin/edit_rider/'.$result->id, 'class' => 'form-horizontal']) !!}
					<div class="box-body">
						<span class="text-danger">(*)Trường bắt buộc</span>
						<div class="form-group">
							<label for="input_first_name" class="col-sm-3 control-label">Tên<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('first_name', $result->first_name, ['class' => 'form-control', 'id' => 'input_first_name', 'placeholder' => 'Tên']) !!}
								<span class="text-danger">{{ $errors->first('first_name') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_last_name" class="col-sm-3 control-label">Họ<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('last_name', $result->last_name, ['class' => 'form-control', 'id' => 'input_last_name', 'placeholder' => 'Họ']) !!}
								<span class="text-danger">{{ $errors->first('last_name') }}</span>
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
							<label for="input_site_name" class="col-sm-3 control-label">VIP?</label>
							<div class="col-md-7 col-sm-offset-1" style="padding-top: 7px;margin-bottom: 0;">
								<label class="switch">
									{!! Form::checkbox('is_vip', 1, $result->is_vip) !!}
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="input_password" class="col-sm-3 control-label">Mật khẩu</label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('password', '', ['class' => 'form-control', 'id' => 'input_password', 'placeholder' => 'Mật khẩu']) !!}
								<span class="text-danger">{{ $errors->first('password') }}</span>
							</div>
						</div>
						{!! Form::hidden('user_type','Rider', ['class' => 'form-control', 'id' => 'user_type', 'placeholder'  => 'Chọn']) !!}
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Quốc tịch<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								<select class='form-control' id = 'input_country_code' name='country_code' >
									@foreach($country_code_option as $country_code)
									<option value="{{@$country_code->phone_code}}" {{ ($country_code->id == $result->country_id) ? 'Selected' : ''}} data-id="{{ $country_code->id }}">{{$country_code->long_name}}</option>
									@endforeach
									{!! Form::hidden('country_id', $result->country_id, array('id'=>'country_id')) !!}
								</select>
								<span class="text-danger">{{ $errors->first('country_code') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="gender" class="col-sm-3 control-label">Giới tính <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{{ Form::radio('gender', '1', $result->getOriginal('gender')=='1' ? true:false, ['class' => 'form-check-input gender', 'id'=>'g_male']) }}
								<label for="g_male" style="font-weight: normal !important;">Nam</label>
								{{ Form::radio('gender', '2', $result->getOriginal('gender')=='2' ? true:false, ['class' => 'form-check-input gender', 'id'=>'g_female']) }}
								<label for="g_female" style="font-weight: normal !important;">Nữ</label>
								<div class="text-danger">{{ $errors->first('gender') }}</div>
							</div>
						</div>
						<div class="form-group">
							<label for="mobile_number" class="col-sm-3 control-label">Số điện thoại <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('mobile_number', old('mobile_number',$result->mobile_number), ['class' => 'form-control', 'id' => 'mobile_number', 'placeholder' => 'Số điện thoại']) !!}
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_password" class="col-sm-3 control-label">Địa chỉ nhà</label>
							<div class="col-md-7 col-sm-offset-1">
								<div class="autocomplete-input-container">
									<div class="autocomplete-input">
										{!! Form::text('home_location', @$location->home, ['class' => 'form-control', 'id' => 'input_home_location', 'placeholder' => 'Địa chỉ nhà','autocomplete' => 'off']) !!}
									</div>
									<ul class="autocomplete-results home-autocomplete-results">
									</ul>
								</div>
								<span class="text-danger">{{ $errors->first('home_location') }}</span>
							</div>
						</div>
						{!! Form::hidden('home_latitude',@$location->home_latitude, ['class' => 'form-control', 'id' => 'home_latitude', 'placeholder'  => 'Chọn']) !!}
						{!! Form::hidden('home_longitude',@$location->home_longitude, ['class' => 'form-control', 'id' => 'home_longitude', 'placeholder'  => 'Chọn']) !!}
						<div class="form-group">
							<label for="input_password" class="col-sm-3 control-label">Địa chỉ cơ quan</label>
							<div class="col-md-7 col-sm-offset-1">
								<div class="autocomplete-input-container">
									<div class="autocomplete-input">
										{!! Form::text('work_location', @$location->work, ['class' => 'form-control', 'id' => 'input_work_location', 'placeholder' => 'Địa chỉ cơ quan','autocomplete' => 'off']) !!}
									</div>
									<ul class="autocomplete-results work-autocomplete-results">
									</ul>
								</div>
								<span class="text-danger">{{ $errors->first('work_location') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Trạng thái<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::select('status', array('Active' => 'Hoạt động', 'Inactive'  => 'Ẩn'), $result->status, ['class' => 'form-control', 'id' => 'input_status', 'placeholder'  => 'Chọn']) !!}
								<span class="text-danger">{{ $errors->first('status') }}</span>
							</div>
						</div>
						{!! Form::hidden('work_latitude',@$location->work_latitude, ['class' => 'form-control', 'id' => 'work_latitude', 'placeholder'  => 'Chọn']) !!}
						{!! Form::hidden('work_longitude',@$location->work_longitude, ['class' => 'form-control', 'id' => 'work_longitude', 'placeholder'  => 'Chọn']) !!}
					</div>
					<div class="box-footer text-center">
						<button type="submit" class="btn btn-info" name="submit" value="submit">Xác nhận </button>
						<button type="submit" class="btn btn-default" name="cancel" value="cancel">Huỷ bỏ</button>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

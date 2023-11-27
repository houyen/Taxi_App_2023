@extends('admin.template')
@section('main')
<div class="content-wrapper" ng-controller="driver_management" ng-init="login_user_type = '{{ LOGIN_USER_TYPE }}'; driver_doc = {{ $driver_doc }}; errors = {{ json_encode($errors->getMessages()) }};">
	<section class="content-header">
		<h1> Thêm tài xế </h1>
		<ol class="breadcrumb">
			<li>
				<a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"> <i class="fa fa-dashboard"></i> Trang chủ </a>
			</li>
			<li>
				<a href="{{ url(LOGIN_USER_TYPE.'/driver') }}"> Tài xế </a>
			</li>
			<li class="active"> Add </li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Thêm tài xế</h3>
					</div>
					{!! Form::open(['url' => LOGIN_USER_TYPE.'/add_driver', 'class' => 'form-horizontal','files' => true]) !!}
					{{ Form::hidden('user_id', '', array('id'=>'user_id')) }}
					<div class="box-body">
						<span class="text-danger">(*)Trường bắt buộc</span>
						<div class="form-group">
							<label for="input_first_name" class="col-sm-3 control-label">Tên<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('first_name',  old('first_name'), ['class' => 'form-control', 'id' => 'input_first_name', 'placeholder' => 'Tên']) !!}
								<span class="text-danger">{{ $errors->first('first_name') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_last_name" class="col-sm-3 control-label">Họ<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'id' => 'input_last_name', 'placeholder' => 'Họ']) !!}
								<span class="text-danger">{{ $errors->first('last_name') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_email" class="col-sm-3 control-label">Email<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('email', old('email'), ['class' => 'form-control', 'id' => 'input_email', 'placeholder' => 'Email']) !!}
								<span class="text-danger">{{ $errors->first('email') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_password" class="col-sm-3 control-label">Mật khẩu<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('password', '', ['class' => 'form-control', 'id' => 'input_password', 'placeholder' => 'Mật khẩu']) !!}
								<span class="text-danger">{{ $errors->first('password') }}</span>
							</div>
						</div>
						{!! Form::hidden('user_type','Driver', ['class' => 'form-control', 'id' => 'user_type', 'placeholder'  => 'Chọn']) !!}
						<div class="form-group">
							<label for="input_country_code" class="col-sm-3 control-label">Quốc tịch<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::select('country_id', $country_code_option, '', ['class' => 'form-control', 'id' => 'input_country_code', 'placeholder'  => 'Chọn']) !!}

								
								<span class="text-danger">{{ $errors->first('country_id') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="gender" class="col-sm-3 control-label">Giới tính <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{{ Form::radio('gender', '1', '', ['class' => 'form-check-input gender', 'id'=>'g_male']) }}
								<label for="g_male" style="font-weight: normal !important;">Nam</label>
								{{ Form::radio('gender', '2', '', ['class' => 'form-check-input gender', 'id'=>'g_female']) }}
								<label for="g_female" style="font-weight: normal !important;">Nữ</label>
								<div class="text-danger">{{ $errors->first('gender') }}</div>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Số điện thoại <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('mobile_number', old('mobile_number'), ['class' => 'form-control', 'id' => 'mobile_number', 'placeholder' => 'Số điện thoại']) !!}
								<span class="text-danger">{{ $errors->first('mobile_number') }}</span>
							</div>
						</div>
						@if (LOGIN_USER_TYPE!='company')
						<div class="form-group">
							<label for="input_company" class="col-sm-3 control-label">Tổ chức<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::select('company_name', $company, old('company_name'), ['class' => 'form-control', 'id' => 'input_company_name', 'placeholder'  => 'Chọn']) !!}
								<span class="text-danger">{{ $errors->first('company_name') }}</span>
							</div>
						</div>
						@endif
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Trạng thái<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('status', 'Car_details', ['class' => 'form-control', 'id' => 'input_status', 'readonly']) !!}
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Địa chỉ 1 </label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('address_line1', old('address_line1'), ['class' => 'form-control', 'id' => 'address_line1', 'placeholder' => 'Địa chỉ 1']) !!}
								<span class="text-danger">{{ $errors->first('address_line1') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Địa chỉ 2 </label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('address_line2', old('address_line2'), ['class' => 'form-control', 'id' => 'address_line2', 'placeholder' => 'Địa chỉ 2']) !!}
								<span class="text-danger">{{ $errors->first('address_line2') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Thành phố </label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('city', old('city'), ['class' => 'form-control', 'id' => 'city', 'placeholder' => 'Thành phố']) !!}
								<span class="text-danger">{{ $errors->first('city') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Tỉnh</label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('state', old('state'), ['class' => 'form-control', 'id' => 'state', 'placeholder' => 'Tỉnh']) !!}
								<span class="text-danger">{{ $errors->first('state') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Mã bưu điện </label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('postal_code', old('postal_code'), ['class' => 'form-control', 'id' => 'postal_code', 'placeholder' => 'Mã bưu điện']) !!}
								<span class="text-danger">{{ $errors->first('postal_code') }}</span>
							</div>
						</div>

						<div class="col-sm-12">
							<label class="col-sm-3"></label>
							<div class="loading d-none" id="document_loading"></div>
						</div>
						<div class="form-group" ng-repeat="doc in driver_doc" ng-cloak ng-if="driver_doc">
							<label class="col-sm-3 control-label">@{{doc.document_name}} <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								<input type="file" name="file_@{{doc.id}}" class="form-control">
								<span class="text-danger">@{{ errors['file_'+doc.id][0] }}</span>
							</div>
							<br>
							<br>
							<div class="col-sm-12 p-0">
							<label class="col-sm-3 control-label" ng-if="doc.expiry_required=='1'">Ngày hết hạn <em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1" ng-if="doc.expiry_required=='1'">
								<input type="text" min="{{ date('Y-m-d') }}" name="expired_date_@{{doc.id}}" class="form-control document_expired" placeholder="Ngày hết hạn" autocomplete="off">
								<span class="text-danger">@{{ errors['expired_date_'+doc.id][0] }}</span>
							</div>
						</div>
						<div class="col-sm-12 p-0">
							<label class="col-sm-3 control-label"> @{{doc.document_name}} Trạng thái<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								<select class ='form-control' name='@{{doc.doc_name}}_status'>
									<option value="0" ng-selected="doc.status==0">Đợi duyệt</option>
									<option value="1" ng-selected="doc.status==1">Được duyệt</option>
									<option value="2" ng-selected="doc.status==2">Từ chối</option>
								</select>
							</div>
						</div>
						</div>
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

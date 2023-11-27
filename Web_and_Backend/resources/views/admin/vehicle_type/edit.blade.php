@extends('admin.template')
@section('main')
<div class="content-wrapper">
	<section class="content-header">
		<h1>
		 Sửa thông tin
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
			<li><a href="{{ url(LOGIN_USER_TYPE.'/vehicle_type') }}">Loại xe </a></li>
			<li class="active"> Sửa </li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Sửa thông tin</h3>
					</div>
					{!! Form::open(['url' => 'admin/edit_vehicle_type/'.$result->id, 'class' => 'form-horizontal','files' => true]) !!}
					<div class="box-body">
						<span class="text-danger">(*)Trường bắt buộc</span>
						<div class="form-group">
							<label for="input_name" class="col-sm-3 control-label">Tên<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::text('vehicle_name',$result->car_name, ['class' => 'form-control', 'id' => 'input_name', 'placeholder' => 'Tên']) !!}
								<span class="text-danger">{{ $errors->first('vehicle_name') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_description" class="col-sm-3 control-label">Mô tả</label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::textarea('description',$result->description, ['class' => 'form-control', 'id' => 'input_description', 'placeholder' => 'Mô tả', 'rows' => 3]) !!}
								<span class="text-danger">{{ $errors->first('description') }}</span>
							</div>
						</div>
						<div class="form-group">
							<label for="input_license_back" class="col-sm-3 control-label">Hình ảnh<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::file('vehicle_image',  ['class' => 'form-control', 'id' => 'rc', 'accept' => 'image/*']) !!}
								<span class="text-danger">{{ $errors->first('vehicle_image') }}</span>
								<img src="{{ $result->vehicle_image }}" style="width: auto;height: 100px;padding-top: 10px;">
							</div>
						</div>
						<div class="form-group">
							<label for="input_license_back" class="col-sm-3 control-label">Hình ảnh thực tế<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::file('active_image',  ['class' => 'form-control', 'id' => 'rc', 'accept' => 'image/*']) !!}
								<span class="text-danger">{{ $errors->first('active_image') }}</span>
								<img src="{{ $result->active_image }}" style="width: auto;height: 100px;padding-top: 10px;" >
							</div>
						</div>
						
						<div class="form-group">
							<label for="input_status" class="col-sm-3 control-label">Trạng thái<em class="text-danger">*</em></label>
							<div class="col-md-7 col-sm-offset-1">
								{!! Form::select('status', array('Active' => 'Hoạt động', 'Inactive'  => 'Ẩn'),$result->status, ['class' => 'form-control', 'id' => 'input_status', 'placeholder'  => 'Chọn']) !!}
								<span class="text-danger">{{ $errors->first('status') }}</span>
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

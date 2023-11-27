<aside class="main-sidebar">
	<section class="sidebar">
		<a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}" class="logo">
	      <span class="logo-mini"><b>{{ $site_name }}</b></span>
	      <span class="logo-lg"><b>{{ $site_name }}</b></span>
	    </a>
		
		<ul class="sidebar-menu">
			<!-- <li class="header">MAIN NAVIGATION</li> -->
			<li class="{{ (Route::current()->uri() == 'admin/dashboard') ? 'active' : ''  }}"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>


			<li class="{{ (Route::current()->uri() == 'admin/driver') ? 'active' : ''  }}"><a href="{{ url('admin/driver') }}"><i class="fa fa-cog"></i><span>Quản lý tài xế</span></a></li>

			<li class="{{ (Route::current()->uri() == 'admin/rider') ? 'active' : ''  }}"><a href="{{ url('admin/rider') }}"><i class="fa fa-users"></i><span>Quản lý khách hàng</span></a></li>

			<li class="treeview {{ (Route::current()->uri() == 'admin/manual_booking/{id?}' || Route::current()->uri() == 'admin/later_booking') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-taxi"></i>
					<span> Đặt xe thủ công </span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">

					<li class="{{ (Route::current()->uri() == 'admin/manual_booking/{id?}') ? 'active' : ''  }}"><a href="{{ url('admin/manual_booking') }}"><i class="fa fa-address-book" aria-hidden="true"></i><span>Đặt xe thủ công</span></a></li>

					<li class="{{ (Route::current()->uri() == 'admin/later_booking') ? 'active' : ''  }}"><a href="{{ url('admin/later_booking') }}"><i class="fa fa-list-alt"></i><span>Thống kê đặt xe</span></a></li>

				</ul>
			</li>



			<li class="treeview {{ (Route::current()->uri() == 'admin/vehicle_type' || Route::current()->uri() == 'admin/vehicle') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-taxi"></i>
					<span> Quản lý phương tiện  </span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">

					<li class="{{ (Route::current()->uri() == 'admin/vehicle') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle') }}"><i class="fa fa-circle-o"></i><span>Tất cả phương tiện</span></a></li>

					<li class="{{ (Route::current()->uri() == 'admin/vehicle_type') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_type') }}"><i class="fa fa-circle-o"></i><span>Quản lý loại phương tiện</span></a></li>

				<li class="{{ (Route::current()->uri() == 'admin/vehicle_make' || Route::current()->uri() == 'admin/add-vehicle-make' || Route::current()->uri() == 'admin/edit-vehicle-make/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_make') }}"><i class="fa fa-circle-o"></i><span>Quản lý hãng phương tiện</span></a></li>



				<li class="{{ (Route::current()->uri() == 'admin/vehicle_model' || Route::current()->uri() == 'admin/add-vehicle_model' || Route::current()->uri() == 'admin/edit-vehicle_model/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_model') }}"><i class="fa fa-circle-o"></i><span>Quản lý mẫu phương tiện</span></a></li>

				</ul>
			</li>



			<li class="{{ (Route::current()->uri() == 'admin/locations') ? 'active' : ''  }}"><a href="{{ url('admin/locations') }}"><i class="fa fa-map-o"></i><span>Quản lý vị trí</span></a></li>



			<li class="{{ (Route::current()->uri() == 'admin/manage_fare') ? 'active' : ''  }}"><a href="{{ url('admin/manage_fare') }}"><i class="fa fa fa-dollar"></i><span>Quản lý phí dịch vụ</span></a></li>



			<li class="treeview {{ (Route::current()->uri() == '/request' || Route::current()->uri() == '/trips' || Route::current()->uri() == '/cancel_trips' || Route::current()->uri() == '/payments' || Route::current()->uri() == '/rating') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-taxi"></i>
					<span> Quản lý chuyến đi </span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">

					<li class="{{ (Route::current()->uri() == 'admin/request') ? 'active' : ''  }}"><a href="{{ url('admin/request') }}"><i class="fa fa-paper-plane-o"></i><span>Quản lý yêu cầu đặt xe</span></a></li>



					<li class="{{ (Route::current()->uri() == 'admin/trips') ? 'active' : ''  }}"><a href="{{ url('admin/trips') }}"><i class="fa fa-taxi"></i><span> Quản lý chuyến đi</span></a></li>

					

					<li class="{{ (Route::current()->uri() == 'admin/rating') ? 'active' : ''  }}"><a href="{{ url('admin/rating') }}"><i class="fa fa-star"></i><span>Quản lý đánh giá</span></a></li>

				</ul>
			</li>




			<li class="treeview {{ (Route::current()->uri() == '/map' || Route::current()->uri() == '/heat-map') ? 'active' : ''  }}">
				
				<a href="#">
					<i class="fa fa-map-marker" aria-hidden="true"></i> <span>Quản lý vị trí</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">

						<li class="{{ (Route::current()->uri() == 'admin/map') ? 'active' : ''  }}"><a href="{{ url('admin/map') }}"><i class="fa fa-circle-o"></i><span>Bản đồ</span></a></li>

				</ul>
			</li>



			<li class="{{ (Route::current()->uri() == 'admin/api_credentials') ? 'active' : ''  }}"><a href="{{ url('admin/api_credentials') }}"><i class="fa fa-gear"></i><span>Xác thực Api</span></a></li>


			<li class="{{ (Route::current()->uri() == 'admin/site_setting') ? 'active' : ''  }}"><a href="{{ url('admin/site_setting') }}"><i class="fa fa-cogs"></i><span>Cấu hình hệ thống</span></a></li>

		</ul>
	</section>
</aside>

<aside class="main-sidebar">
	<section class="sidebar">
		<a href="{{ url(LOGIN_USER_TYPE.'/dashboard') }}" class="logo">
	      <span class="logo-mini"><b>{{ $site_name }}</b></span>
	      <span class="logo-lg"><b>{{ $site_name }}</b></span>
	    </a>
		<!-- <div class="user-panel">
			<div class="pull-left image">
				@php
					if(LOGIN_USER_TYPE=='company'){
						$user = Auth::guard('company')->user();
						$company_user = true;
						$first_segment = 'company';
					}
					else{
						$user = Auth::guard('admin')->user();
						$company_user = false;
						$first_segment = 'admin';
					}
				@endphp
				@if(!$company_user || $user->profile ==null)
					<img src="{{ url('admin_assets/dist/img/avatar04.png') }}"  class="img-circle" alt="User Image">
				@else
					<img src="{{ $user->profile }}"  class="img-circle" alt="User Image">
				@endif
			</div>
			<div class="pull-left info">
				<p>{{ (!$company_user)?$user->username:$user->name }}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div> -->
		<ul class="sidebar-menu">
			<!-- <li class="header">MAIN NAVIGATION</li> -->
			<li class="{{ (Route::current()->uri() == $first_segment.'/dashboard') ? 'active' : ''  }}"><a href="{{ url($first_segment.'/dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>

			@if(@$user->can('manage_admin'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/admin_user' || Route::current()->uri() == 'admin/roles') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-users"></i> <span>Admins Management</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="{{ (Route::current()->uri() == 'admin/admin_user') ? 'active' : ''  }}"><a href="{{ url('admin/admin_user') }}"><i class="fa fa-circle-o"></i><span>Admin Users</span></a></li>
					<li class="{{ (Route::current()->uri() == 'admin/roles') ? 'active' : ''  }}"><a href="{{ url('admin/roles') }}"><i class="fa fa-circle-o"></i><span>Roles & Permissions</span></a></li>
				</ul>
			</li>
			
			@if(@$user->can('view_rider'))
			<li class="{{ (Route::current()->uri() == 'admin/rider') ? 'active' : ''  }}"><a href="{{ url('admin/rider') }}"><i class="fa fa-users"></i><span>Manage Riders</span></a></li>
			@endif

			@if(@$user->can('view_documents'))
			<li class="{{ (Route::current()->uri() == 'admin/documents') ? 'active' : ''  }}"><a href="{{ url('admin/documents') }}"><i class="fa fa-folder"></i><span>Manage Documents</span></a></li>
			@endif
			
			
			@if(@$user->can('manage_email_settings') || @$user->can('manage_send_email'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/email_settings' || Route::current()->uri() == 'admin/send_email') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-envelope-o"></i>
					<span>Manage Emails</span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					@if(@$user->can('manage_send_email'))
					<li class="{{ (Route::current()->uri() == 'admin/send_email') ? 'active' : ''  }}">
						<a href="{{ url('admin/send_email') }}"><i class="fa fa-circle-o"></i>
							<span>Send Email</span>
						</a>
					</li>
					@endif
					@if(@$user->can('manage_email_settings'))
					<li class="{{ (Route::current()->uri() == 'admin/email_settings') ? 'active' : ''  }}">
						<a href="{{ url('admin/email_settings') }}"><i class="fa fa-circle-o"></i>
							<span>Email Settings</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if((($company_user && @$user->status == 'Active') || @$user->can('manage_manual_booking')) || ($company_user || @$user->can('manage_manual_booking')))
			<li class="treeview {{ (Route::current()->uri() == $first_segment.'/manual_booking/{id?}' || Route::current()->uri() == $first_segment.'/later_booking') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-taxi"></i>
					<span> Manage Manual Booking </span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					@if(($company_user && @$user->status == 'Active') || @$user->can('manage_manual_booking'))
					<li class="{{ (Route::current()->uri() == $first_segment.'/manual_booking/{id?}') ? 'active' : ''  }}"><a href="{{ url($first_segment.'/manual_booking') }}"><i class="fa fa-address-book" aria-hidden="true"></i><span>Manual Booking</span></a></li>
					@endif
					@if($company_user || @$user->can('manage_manual_booking'))
					<li class="{{ (Route::current()->uri() == $first_segment.'/later_booking') ? 'active' : ''  }}"><a href="{{ url($first_segment.'/later_booking') }}"><i class="fa fa-list-alt"></i><span>View Manual/Schedule Booking</span></a></li>
					@endif
				</ul>
			</li>
			@endif
		

			@if(($company_user || @$user->can('manage_vehicle')) || $user->can('manage_vehicle_type'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/vehicle_type' || Route::current()->uri() == $first_segment.'/vehicle') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-taxi"></i>
					<span> Vehicles Management  </span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					@if($company_user || @$user->can('manage_vehicle'))
					<li class="{{ (Route::current()->uri() == $first_segment.'/vehicle') ? 'active' : ''  }}"><a href="{{ url($first_segment.'/vehicle') }}"><i class="fa fa-circle-o"></i><span>All Vehicles</span></a></li>
					@endif
					@if(@$user->can('manage_vehicle_type'))
					<li class="{{ (Route::current()->uri() == 'admin/vehicle_type') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_type') }}"><i class="fa fa-circle-o"></i><span>Manage Vehicle Types</span></a></li>
					@endif
						@if(@$user->can('view_vehicle_make'))
				<li class="{{ (Route::current()->uri() == 'admin/vehicle_make' || Route::current()->uri() == 'admin/add-vehicle-make' || Route::current()->uri() == 'admin/edit-vehicle-make/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_make') }}"><i class="fa fa-circle-o"></i><span>Manage Vehicle Make</span></a></li>
			@endif

			@if(@$user->can('view_vehicle_model'))
				<li class="{{ (Route::current()->uri() == 'admin/vehicle_model' || Route::current()->uri() == 'admin/add-vehicle_model' || Route::current()->uri() == 'admin/edit-vehicle_model/{id}') ? 'active' : ''  }}"><a href="{{ url('admin/vehicle_model') }}"><i class="fa fa-circle-o"></i><span>Manage Vehicle Model</span></a></li>
			@endif
				</ul>
			</li>
			@endif

			@if(@$user->can('view_additional_reason'))
			<li class="{{ (Route::current()->uri() == 'admin/additional-reasons') ? 'active' : ''  }}"><a href="{{ url('admin/additional-reasons') }}"><i class="fa fa fa-comment"></i><span> Additional Reasons</span></a></li>
			@endif

			@if(@$user->can('view_manage_reason'))
			<li class="{{ (Route::current()->uri() == 'admin/cancel-reason') ? 'active' : ''  }}"><a href="{{ url('admin/cancel-reason') }}"><i class="fa fa fa-ban"></i><span>Cancellation Reasons</span></a></li>
			@endif

			@if(@$user->can('manage_locations'))
			<li class="{{ (Route::current()->uri() == 'admin/locations') ? 'active' : ''  }}"><a href="{{ url('admin/locations') }}"><i class="fa fa-map-o"></i><span>Manage Locations</span></a></li>
			@endif

			@if(@$user->can('manage_peak_based_fare'))
			<li class="{{ (Route::current()->uri() == 'admin/manage_fare') ? 'active' : ''  }}"><a href="{{ url('admin/manage_fare') }}"><i class="fa fa fa-dollar"></i><span>Fare Management</span></a></li>
			@endif


			@if(@$user->can('manage_rider_referrals') || @$user->can('manage_driver_referrals'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/referrals/rider' || Route::current()->uri() == 'admin/referrals/driver') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-users"></i>
					<span>Referrals</span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					@if(@$user->can('manage_rider_referrals'))
					<li class="{{ (Route::current()->uri() == 'admin/referrals/rider') ? 'active' : ''  }}">
						<a href="{{ url('admin/referrals/rider') }}"><i class="fa fa-circle-o"></i>
							<span> Riders </span>
						</a>
					</li>
					@endif
					@if(@$user->can('manage_driver_referrals'))
					<li class="{{ (Route::current()->uri() == 'admin/referrals/driver') ? 'active' : ''  }}">
						<a href="{{ url('admin/referrals/driver') }}"><i class="fa fa-circle-o"></i>
							<span> Drivers </span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			
			@if(@$user->can('manage_mobile_app_version'))
			<li class="{{ (Route::current()->uri() == 'admin/mobile_app_version') ? 'active' : ''  }}"><a href="{{ url('admin/mobile_app_version') }}"><i class="fa fa-level-up"></i><span>Manage Mobile App Version</span></a></li>
			@endif

			@if(@$user->can('manage_api_credentials'))
			<li class="{{ (Route::current()->uri() == 'admin/api_credentials') ? 'active' : ''  }}"><a href="{{ url('admin/api_credentials') }}"><i class="fa fa-gear"></i><span>Api Credentials</span></a></li>
			@endif
			@if(@$user->can('manage_metas'))
			<li class="{{ (Route::current()->uri() == 'admin/metas') ? 'active' : ''  }}"><a href="{{ url('admin/metas') }}"><i class="fa fa-bar-chart"></i><span>MetasManagement</span></a></li>
			@endif
			@if(@$user->can('manage_country'))
			<li class="{{ (Route::current()->uri() == 'admin/country') ? 'active' : ''  }}"><a href="{{ url('admin/country') }}"><i class="fa fa-globe"></i><span>Manage Country</span></a></li>
			@endif
			@if(@$user->can('manage_language'))
			<li class="{{ (Route::current()->uri() == 'admin/language') ? 'active' : ''  }}"><a href="{{ url('admin/language') }}"><i class="fa fa-language"></i><span>Manage Language</span></a></li>
			@endif
			@if(@$user->can('manage_static_pages'))
			<li class="{{ (Route::current()->uri() == 'admin/pages') ? 'active' : ''  }}"><a href="{{ url('admin/pages') }}"><i class="fa fa-newspaper-o"></i><span>Manage Static Pages</span></a></li>
			@endif
			
			@if(@$user->can('manage_help'))
			<li class="treeview {{ (Route::current()->uri() == 'admin/help' || Route::current()->uri() == 'admin/help_category' || Route::current()->uri() == 'admin/help_subcategory') ? 'active' : ''  }}">
				<a href="#">
					<i class="fa fa-support"></i> <span>Manage Help</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="{{ (Route::current()->uri() == 'admin/help') ? 'active' : ''  }}"><a href="{{ url('admin/help') }}"><i class="fa fa-circle-o"></i><span>Help</span></a></li>
					<li class="{{ (Route::current()->uri() == 'admin/help_category') ? 'active' : ''  }}"><a href="{{ url('admin/help_category') }}"><i class="fa fa-circle-o"></i><span>Category</span></a></li>
					<li class="{{ (Route::current()->uri() == 'admin/help_subcategory') ? 'active' : ''  }}"><a href="{{ url('admin/help_subcategory') }}"><i class="fa fa-circle-o"></i><span>Subcategory</span></a></li>
				</ul>
			</li>
			@endif
			@if(@$user->can('manage_join_us'))
			<li class="{{ (Route::current()->uri() == 'admin/join_us') ? 'active' : ''  }}"><a href="{{ url('admin/join_us') }}"><i class="fa fa-share-alt"></i><span>Social & App Links</span></a></li>
			@endif
			@if(@$user->can('manage_support'))
			<li class="{{ (Route::current()->uri() == 'admin/support') ? 'active' : ''  }}"><a href="{{ url('admin/support') }}"><i class="fa fa-globe"></i><span>Manage Support</span></a></li>
			@endif

			@if(@$user->can('manage_banner'))
			<li class="{{ (Route::current()->uri() == 'admin/banner') ? 'active' : ''  }}"><a href="{{ url('admin/banner') }}"><i class="fa fa-cog"></i><span>Manage Banners</span></a></li>
			@endif
			@if(@$user->can('manage_site_settings'))
			<li class="{{ (Route::current()->uri() == 'admin/site_setting') ? 'active' : ''  }}"><a href="{{ url('admin/site_setting') }}"><i class="fa fa-cogs"></i><span>System Configuration</span></a></li>
			@endif
		</ul>
	</section>
</aside>

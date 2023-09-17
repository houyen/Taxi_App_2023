<title>Delete Profile</title>
@extends('template_dashboard')
@section('main')
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;" ng-controller="facebook_account_kit">
	<div class="separated--bottom  text--left" style="padding:0px 15px;">
		<h1 class="cls_profiletitle">{{trans('messages.header.profile')}}</h1>
	</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
            
                <strong>Delete {{ @Auth::user()->first_name}} {{ @Auth::user()->last_name}}'s account?</strong></div>
                <div class="card-body">
                <form action="delete" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Account Email:</label>
                    <input type="text" name ="email" value="{{ @Auth::user()->email}}" class="form-control" readonly>
                    <div class="form-group">
                    <div class="text-centre">
                    <p></p>
                    <button type="button" data_userid="{{ @Auth::user()->id}}" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        Delete
                    </button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Are you sure?</h5>
        <form action="{{ route('deleteacc', ['user' => @Auth::user()->id]) }}" method="POST">
        <!-- Form::open(['method' => 'DELETE', 'route' => ['deleteacc.destroy', @Auth::user()->id]]) }} -->

        
        {{method_field('delete')}}
        {{csrf_field()}}
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        Are you sure you want to permanetly delete your account?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">No, cancel</button>
        <button type="submit" class="btn btn-danger">Yes, delete my account</button>
      </div>
      </form>
    </div>
  </div>
</div>
</main>
@stop
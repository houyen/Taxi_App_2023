<title>Delete Profile</title>

<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;" ng-controller="facebook_account_kit">
	<div class="separated--bottom  text--left" style="padding:0px 15px;">
		<h1 class="cls_profiletitle"><?php echo e(trans('messages.header.profile')); ?></h1>
	</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
            
                <strong>Delete <?php echo e(@Auth::user()->first_name); ?> <?php echo e(@Auth::user()->last_name); ?>'s account?</strong></div>
                <div class="card-body">
                <form action="delete" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <label for="name">Account Email:</label>
                    <input type="text" name ="email" value="<?php echo e(@Auth::user()->email); ?>" class="form-control" readonly>
                    <div class="form-group">
                    <div class="text-centre">
                    <p></p>
                    <button type="button" data_userid="<?php echo e(@Auth::user()->id); ?>" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
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
        <form action="<?php echo e(route('deleteacc', ['user' => @Auth::user()->id])); ?>" method="POST">
        <!-- Form::open(['method' => 'DELETE', 'route' => ['deleteacc.destroy', @Auth::user()->id]]) }} -->

        
        <?php echo e(method_field('delete')); ?>

        <?php echo e(csrf_field()); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampps\htdocs\new\resources\views/dashboard/deleteacc.blade.php ENDPATH**/ ?>
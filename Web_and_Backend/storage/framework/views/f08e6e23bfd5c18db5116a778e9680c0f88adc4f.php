<?php $__env->startSection('main'); ?>

<style>
  .cls_signin .cls_signintext {
    background-color: #5498c4;
    padding: 3em;
    border-radius: 56px;
}
</style>
<div class="cls_signin">
  <div class="container">
    <div class="col-lg-12">
      <h2 class="title"><?php echo e(trans('messages.header.signin-delete')); ?></h2>
       <?php if(Auth::user()==null): ?>
       <div class="col-lg-6">
        <div class="cls_signintext">
          <h4 ><?php echo e(trans('messages.profile.rider')); ?></h4>
          <p ><?php echo e(trans('messages.profile.delete_rider')); ?></p>
          <a href="<?php echo e(url('rider_deletion')); ?>"><?php echo e(trans('messages.profile.driver_proceed')); ?> <img src="images/new/arrow-right.svg" alt="arrow">
          </a>
        </div>
      </div>  
      <div class="col-lg-6">
        <div class="cls_signintext">
          <h4 ><?php echo e(trans('messages.profile.driver')); ?></h4>
          <p ><?php echo e(trans('messages.profile.delete_driver')); ?></p>
          <a href="<?php echo e(url('driver_deletion')); ?>"><?php echo e(trans('messages.profile.driver_proceed')); ?> <img src="images/new/arrow-right.svg" alt="arrow">
          </a>
        </div>
      </div>
       <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templatesign', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampps\htdocs\newtaxi\resources\views/user/login.blade.php ENDPATH**/ ?>
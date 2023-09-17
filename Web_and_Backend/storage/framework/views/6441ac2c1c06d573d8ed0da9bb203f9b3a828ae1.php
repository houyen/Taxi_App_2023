<?php $__env->startSection('main'); ?>
<div class="cls_signin"  style=" background-image: url(images/cutegirl.jpg);background-size: 100% 100%;">
  <div class="container">
    <div class="col-lg-12">
      <h2 class="title"><?php echo e(trans('messages.home.siginup')); ?></h2>
       <?php if(Auth::user()==null): ?>
      <div class="col-lg-4">
        <div class="cls_signintext">
          <h4 ><?php echo e(trans('messages.profile.driver')); ?></h4>
          <p ><?php echo e(trans('messages.profile.track_every')); ?></p>
          <a href="<?php echo e(url('signup_driver')); ?>"><?php echo e(trans('messages.profile.driver_signup')); ?> <img src="images/new/arrow-right.svg" alt="arrow">
          </a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="cls_signintext">
          <h4 ><?php echo e(trans('messages.profile.rider')); ?></h4>
          <p ><?php echo e(trans('messages.profile.trip_history')); ?></p>
          <a href="<?php echo e(url('signup_rider')); ?>"><?php echo e(trans('messages.profile.rider_signup')); ?> <img src="images/new/arrow-right.svg" alt="arrow">
          </a>
        </div>
      </div>  
       <?php endif; ?>
        <?php if(Auth::guard('company')->user()==null): ?>
         <div class="col-lg-4">
            <div class="cls_signintext">
              <h4 ><?php echo e(trans('messages.home.company')); ?></h4>
              <p ><?php echo e(trans('messages.home.company_history')); ?></p>
              <a href="<?php echo e(url('signup_company')); ?>"><?php echo e(trans('messages.home.company_signup')); ?><img src="images/new/arrow-right.svg" alt="arrow">
              </a>
            </div>
          </div>  
       <?php endif; ?>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templatesign', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/user/signup.blade.php ENDPATH**/ ?>
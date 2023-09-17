<link rel="shortcut icon" href="<?php echo e($favicon); ?>">


<?php $__env->startSection('main'); ?>
<div class="ux-content text-center signin" ng-controller="user">
  <div class="stage-wrapper narrow portable-one-whole forward" id="app-body" data-reactid="10" style="margin-top: 0px;">
    <div class="soft-tiny" data-reactid="11">
      <div data-reactid="12">
        <form class="push--top-small forward" method="POST" data-reactid="13">
          <input type="hidden" name="user_type" value="Driver" id="users_type">
          <div data-reactid="15" class="email_phone-sec">
            <h4 data-reactid="14" style="text-align: center;"><?php echo e(trans('messages.header.authorize_deletion')); ?></h4>

            <div style="-moz-box-sizing:border-box;font-family:ff-clan-web-pro, &quot;Helvetica Neue&quot;, Helvetica, sans-serif;font-weight:500;font-size:12px;line-height:24px;text-align:none;color:#939393;box-sizing:border-box;margin-bottom:0;margin-top:0;" data-reactid="16"></div>
            <div style="width:100%;" data-reactid="17">
              <div style="font-family:ff-clan-web-pro, &quot;Helvetica Neue&quot;, Helvetica, sans-serif;font-weight:500;font-size:14px;line-height:24px;text-align:none;color:#3e3e3e;box-sizing:border-box;margin-bottom:24px;" data-reactid="19">
                <div class="_style_CZTQ8" data-reactid="20">
                  <select name="country_code" tabindex="-1" id="phone_country" class="text-select input-group-addon" data-reactid="21">
                   <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option value="<?php echo e($value->phone_code); ?>" data-value="+<?php echo e($value->phone_code); ?>" data-id="<?php echo e($value->id); ?>" <?php echo e((canDisplayCredentials() && $value->id==227) ?' selected':''); ?>><?php echo e($value->long_name); ?></option>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php echo Form::hidden('country_id', old('country_id'), array('id'=>'country_id')); ?>

                 </select> 
                  <input class="text-phone input-group-addon" id="email_phone" placeholder="<?php echo e(trans('messages.user.email_address')); ?>" autocorrect="off" autocapitalize="off" name="textInputValue" data-reactid="21" type="text" value="<?php echo e(canDisplayCredentials() ? '98765432101':''); ?>">
                </div>
                <div class="_style_CZTQ8 signin-email-error">
                  <span class="text-danger email-error" id="email-error"></span>
                </div>
              </div>
            </div>
          </div>
          <h3 class="email_or_phone password-sec hide text-center" style="margin-top: 0px;margin-bottom: 20px;"></h3>
          <div data-reactid="15" class="password-sec hide">
            <div style="-moz-box-sizing:border-box;font-family:ff-clan-web-pro, &quot;Helvetica Neue&quot;, Helvetica, sans-serif;font-weight:500;font-size:12px;line-height:24px;text-align:none;color:#939393;box-sizing:border-box;margin-bottom:0;margin-top:0;" data-reactid="16"></div>
            <div style="width:100%;" data-reactid="17">
              <div style="font-family:ff-clan-web-pro, &quot;Helvetica Neue&quot;, Helvetica, sans-serif;font-weight:500;font-size:14px;line-height:24px;text-align:none;color:#3e3e3e;box-sizing:border-box;margin-bottom:24px;" data-reactid="19">
                <div class="_style_CZTQ8" data-reactid="20">
                  <input class="text-input input-group-addon password_btn" id="password" placeholder="<?php echo e(trans('messages.user.paswrd')); ?>" autocorrect="off" autocapitalize="off" name="password" data-reactid="21" type="password" value="<?php echo e(canDisplayCredentials() ? '123456':''); ?>">
                </div>
                <div class="_style_CZTQ8 signin-email-error">
                  <span class="text-danger email-error"></span>
                </div>
              </div>
            </div>
          </div>
          <button class="btn btn--arrow btn--full blue-signin-btn singin_rider email_phone-sec-1" data-reactid="22" data-type='email'><span class="push-small--right" data-reactid="23"><?php echo e(trans('messages.user.next')); ?></span></button>

        </form>
      </div>
      
    </div>
  </div>
</div>
</main>
<style>
  .funnel
  {
    height: 0px !important;
  }

</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templatesign', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampps\htdocs\newtaxi\resources\views/user/driver_deletion.blade.php ENDPATH**/ ?>
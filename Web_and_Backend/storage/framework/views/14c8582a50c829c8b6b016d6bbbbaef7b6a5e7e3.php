 
<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;" ng-controller="facebook_account_kit">
  <!-- <div class="page-lead separated--bottom  text--center text--uppercase">
    <h1 class="flush-h1 flush"><?php echo e(trans('messages.header.profil')); ?></h1>
  </div> -->
  <div class="" style="padding:0px 15px;">
    <?php echo e(Form::open(array('url' => 'driver_update_profile/'.$result->id,'id'=>'form','class' => 'layout layout--flush','files' => 'true','enctype'=>'multipart/form-data','name'=>'driver_profile'))); ?>

  </div>
  <?php echo $__env->make('dashboard.mobile_number_change', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <input type="hidden" name="user_type" value="<?php echo e($result->user_type); ?>">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="code" id="code" />
  <input type="hidden" id="user_id" name="user_id" value="<?php echo e($result->id); ?>">
  <input type="hidden" name="id" value="<?php echo e(@$result->id); ?>">
  <div class="page-lead separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_update-loader displayflex" style="border-bottom:0px !important;padding: 0">

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
      <h1 class="cls_profiletitle"><?php echo e(trans('messages.header.profil')); ?></h1>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text--right">
      <button type="button" class="btn btn--primary btn-blue doc-button" ng-click="selectFile()">
        <span style="padding: 0px 30px !important;font-size: 14px !important;" id="span-cls"><?php echo e(trans('messages.driver_dashboard.add_photo')); ?>

        </span>
      </button>
      <input type="file" ng-model="profile_image" style="display:none" accept="image/*"
      id="file" name='profile_image' onchange="angular.element(this).scope().fileNameChanged(this)" />
    </div>
</div>
<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="    padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;">
      <?php echo e(trans('messages.profile.email')); ?> <em class="text-danger">*</em>
    </label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
      <input class="_style_3vhmZK" name="email" value="<?php echo e(@$result->email); ?>" placeholder="<?php echo e(trans('messages.profile.email')); ?>">
      <span class="text-danger"> <?php echo e($errors->first('email')); ?> </span>
    </div>
  </div>
</div>
<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:6px 0px;"><?php echo e(trans('messages.profile.phone')); ?><em class="text-danger">*</em></label>
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2" style="padding:6px 0px;">
      <input class="_style_3vhmZK" type="text" name="phone_code" value="+<?php echo e(@$result->country_code); ?>" readonly="">
      <input type="hidden" id="mobile_country" name="mobile_country" value="<?php echo e(@$result->country_code); ?>">
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9" style="padding:6px 0px;">
      <input class="_style_3vhmZK" id="mobile" name="mobile_number" value="<?php echo e(@$result->mobile_number); ?>" placeholder="<?php echo e(trans('messages.profile.mobile')); ?>" readonly="" style=" margin-left: 2px;">
      <span class="text-danger"><?php echo e($errors->first('mobile_number')); ?></span>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:6px 0px;">
      <input type="button" class="_style_3vhmZK" name="change_number" value="<?php echo e(trans('messages.profile.change')); ?>" id="submit-btn" ng-click="changeNumberPopup('show_popup')" style=" margin-left: 4px;">
    </div>
  </div>
</div>

<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding:6px 0px;"><?php echo e(trans('messages.profile.gender')); ?><em class="text-danger">*</em></label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-9" style="padding:6px 0px;">
      <?php echo Form::text('gender', $result->gender_text, ['class'=>'_style_3vhmZK phone-no', 'disabled'=>'true']); ?>

    </div>
  </div>
</div>


<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"><?php echo e(trans('messages.profile.addr')); ?></label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">


      <div class="">
        <div class="autocomplete-input">
         <?php echo Form::text('address_line1', @$result->driver_address->address_line1.@$result->driver_address->address_line2, ['class' => '_style_3vhmZK','placeholder' => trans('messages.profile.addr'),'id' => 'home_address','autocomplete' => 'false']); ?>  
       </div>
       <ul class="autocomplete-results home_address">
       </ul>
     </div>

   </div>
   <span class="text-danger"><?php echo e($errors->first('address_line1')); ?></span>
 </div>
</div>
<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="    padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"> 
      <?php echo e(trans('messages.profile.profile_city')); ?>

    </label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
      <?php echo Form::text('city', @$result->driver_address->city, ['class' => '_style_3vhmZK','placeholder' => trans('messages.profile.profile_city'),'id' => 'city']); ?>

      
      <input type="hidden" name="country" id="country" value="">
      <input type="hidden" name="address_line1" id="address_line1" value="<?php echo e(@$result->driver_address->address_line1); ?>">
      <input type="hidden" name="address_line2" id="address_line2" value="<?php echo e(@$result->driver_address->address_line2); ?>">
      <input type="hidden" name="postal_code" id="postal_code" value="<?php echo e(@$result->driver_address->postal_code); ?>">
      <input type="hidden" name="latitude" id="latitude" value="">
      <input type="hidden" name="longitude" id="longitude" value="">
      <span class="text-danger"><?php echo e($errors->first('city')); ?></span>
    </div>
  </div>
</div>
<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"> 
      <?php echo e(trans('messages.profile.state')); ?>

    </label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
      <?php echo Form::text('state', @$result->driver_address->state, ['class' => '_style_3vhmZK','placeholder' => trans('messages.profile.state'),'id' => 'state']); ?>

    </div>
    <span class="text-danger"><?php echo e($errors->first('state')); ?></span>
  </div>
</div>
<div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 5px 0px;">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex">
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"> <?php echo e(trans('messages.profile.country')); ?> </label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
      <select class=" _style_3vhmZK " name="country_code" tabindex="-1" title="" disabled="">
        <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($value->phone_code); ?>" <?php echo e($value->id == @$result->country_id ? 'selected' : ''); ?> data-value="+<?php echo e($value->phone_code); ?>"> <?php echo e($value->long_name); ?> </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
  </div>
  <span class="text-danger"><?php echo e($errors->first('country_code')); ?></span>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex" >
    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"> <?php echo e(trans('messages.profile.profile_postal_code')); ?></label>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
      <input class="_style_3vhmZK" name="postal_code" value="<?php echo e(@$result->driver_address->postal_code); ?>" placeholder="<?php echo e(trans('messages.profile.profile_postal_code')); ?>">
    </div>
    <span class="text-danger"><?php echo e($errors->first('postal_code')); ?></span>

  </div>
</div>
<div class="separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-bottom:0px !important; margin-top: 20px; text-align: center;">
  <button style="padding: 0px 60px !important;font-size: 19px !important;" type="submit" class="btn btn--primary btn-blue" id="update_btn"><?php echo e(trans('messages.user.update')); ?></button>
</div>
<?php echo e(Form::close()); ?>

</div>
</div>
</div>
</div>
</div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template_driver_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/driver_dashboard/driver_profile.blade.php ENDPATH**/ ?>
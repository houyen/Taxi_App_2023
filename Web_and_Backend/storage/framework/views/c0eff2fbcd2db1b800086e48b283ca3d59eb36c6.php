<?php $otp_verification = site_settings('otp_verification'); ?>
<div class="modal otp-popup text-left poppayout fade" id="otp_popup" aria-hidden="false" style="" tabindex="-1">
	<div id="modal-add-otp-set-address" class="modal-content">
		<div class="panel-header">
			<button type="button" class="close" data-dismiss="modal"></button>
			<h3>
				<?php if($otp_verification): ?>
				<?php echo e(trans('messages.signup.otp')); ?> {{resend_otp}}
				<?php else: ?>
				<?php echo e(trans('messages.profile.change')); ?>

				<?php endif; ?>
			</h3>
		</div>
		<div class="flash-container otp-flash-message alert-success success_msg" id="otp_resended_flash" style="display: none;">
			<?php echo e(trans('messages.signup.otp_resended')); ?>

		</div>
		<div class="panel-body">
			<div class="otp-number row">
				<div class="col-xs-4">
					<div class="layout__item country-input" id="country">
						<div id="select-title-stage" class="country-code">
							<!-- <?php echo e(old('country_code')!=null? '+'.old('country_code') : '+1'); ?> -->
							+<?php echo e($result->country_code); ?>

						</div>
						<div class="select">
							<select name="country_code" tabindex="-1" id="mobile_country" class="square borderless--right">
								<?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($value->phone_code); ?>" <?php echo e($value->id == $result->country_id ? 'selected' : ''); ?> data-value="+<?php echo e($value->phone_code); ?>"  data-name="<?php echo e($value->short_name); ?>"><?php echo e($value->long_name); ?>

								</option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select> 
							<span class="text-danger country_code_error"><?php echo e($errors->first('country_code')); ?></span>               
						</div>
					</div>
				</div>
				<div class="col-xs-8">
					
					<?php echo Form::number('mobile', '', ['id' => 'mobile_input','class'=>'mobile-input form-control','placeholder' => trans('messages.profile.mobile')]); ?>


					<span class="text-danger mobile_number_error"></span>
				</div>
			</div>
			<?php if($otp_verification): ?>
			<div class="otp-field">
				<div class="otp-input">
					<?php echo Form::number('otp', '', ['id' => 'otp_input','class'=>'form-control','placeholder' => trans('messages.signup.otp')]); ?>

					<span class="text-danger otp_error"></span>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="panel-footer otp_footer">
			<?php if($otp_verification): ?>
			<input type="button" value="<?php echo e(trans('messages.signup.send_otp')); ?>" class="btn blue-signin-btn" ng-click="changeNumberPopup('send_otp');">
			<?php endif; ?>
			<input type="button" value="<?php echo e(trans('messages.user.submit')); ?>" class="btn blue-signin-btn" ng-click="changeNumberPopup('check_otp');">
		</div>
	</div>
</div>
<?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/dashboard/mobile_number_change.blade.php ENDPATH**/ ?>
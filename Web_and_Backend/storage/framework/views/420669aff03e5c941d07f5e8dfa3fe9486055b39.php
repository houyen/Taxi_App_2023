<?php $__env->startSection('emails.main'); ?>
<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;margin-top:1em">
	<?php if($type == 'update'): ?>
	<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;margin-top:1em">
		<?php echo e(trans('messages.email.payout_update',['site_name'=>$site_name], null, $locale)); ?> <?php echo e($updated_time); ?>.
	</div>
	<?php endif; ?>
	<?php if($type == 'delete'): ?>
	<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;margin-top:1em">
		<?php echo e(trans('messages.email.payment_information_del',['site_name'=>$site_name], null, $locale)); ?>.
	</div>
	<?php endif; ?>
	<?php if($type == 'default_update'): ?>
	<div style="margin:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;padding:0;margin-top:1em">
		<?php echo e(trans('messages.email.hope_messgae_friends',['site_name'=>$site_name,'updated_date'=>$updated_date], null, $locale)); ?>.
	</div>
	<div style="margin:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;padding:0;margin-top:1em">
		<?php echo e(trans('messages.email.change_your_account',[], null, $locale)); ?>

	</div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.template_two', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampps\htdocs\newtaxi\resources\views/emails/payout_preferences.blade.php ENDPATH**/ ?>
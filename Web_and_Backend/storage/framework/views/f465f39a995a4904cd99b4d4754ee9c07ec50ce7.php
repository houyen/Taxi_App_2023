<?php $__env->startSection('emails.main'); ?>
<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif">
<?php if(isset($first_name)): ?>
<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif">
<p>Hi <?php echo e($first_name); ?>,</p>
</div>
<?php endif; ?>
</div>
<div style="margin:0;padding:0;font-family:&quot;Helvetica Neue&quot;,&quot;Helvetica&quot;,Helvetica,Arial,sans-serif;margin-top:1em">
	<?php echo $content; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/galm7dz522zx/public_html/resources/views/emails/custom_email.blade.php ENDPATH**/ ?>
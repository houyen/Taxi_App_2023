<?php $__env->startSection('main'); ?>
<div class="" ng-controller="user">
	<div class="container" >
		<div class="pad-44">
			<h1 class="slide-head"><?php echo e(trans('messages.home.title')); ?></h1>
			<p class="slide-content"><?php echo e(trans('messages.home.desc')); ?></p>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
	/**
	 * Determine the mobile operating system.
	 * This function returns one of 'iOS', 'Android', 'Windows Phone', or 'unknown'.
	 *
	 * @returns  {String}
	 */
	function getMobileOperatingSystem()
	{
	  	var userAgent = navigator.userAgent || navigator.vendor || window.opera;
	    // Windows Phone must come first because its UA also contains "Android"
	    if (/windows phone/i.test(userAgent)) {
	        return "Windows Phone";
	    }

	    if (/android/i.test(userAgent)) {
	        return "Android";
	    }

	    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
	        return "iOS";
	    }

	    return "unknown";
	}
	os_type = getMobileOperatingSystem();
	if(os_type == 'Android') {
		window.location.href = '<?php echo $play_store_link; ?>';
	}
	else if(os_type == 'iOS') {
		window.location.href = '<?php echo $app_store_link; ?>';
	}
	else {
		window.location.href = '<?php echo url("/"); ?>';
	}
</script>

<style type="text/css">
	.page-footer-back{
		background: #f8f8f9;
	}
	.btn-input:hover, .btn:hover, .file-input:hover, .tooltip:hover , .btn, .btn-input, .file-input, .tooltip{
		background:transparent !important;
		border: none !important
	}
	.btn.btn--primary:hover{
		background:transparent !important;
		color: #fff !important;
	}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('templatesign', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/home/apps.blade.php ENDPATH**/ ?>
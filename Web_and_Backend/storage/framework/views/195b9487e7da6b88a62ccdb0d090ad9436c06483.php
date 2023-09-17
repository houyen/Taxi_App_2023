<title>Your trip</title>

<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;" >
	<div class="separated--bottom text--left" style="padding: 0px 15px !important;">
		<div class="pull-left">
		<h1 class="cls_profiletitle"> <?php echo app('translator')->get('messages.profile.your_trip'); ?> </h1>
		<div class="color--neutral" style="margin-bottom: 0px !important; margin-top: 0px;">
			<?php echo e($trip->pickup_time); ?> on <?php echo e(date('F d, Y',strtotime($trip->created_at))); ?>

		</div>
	</div>
	<div class="pull-right">
		<a target="_self" href="<?php echo e(url('trip_invoice/'.$trip->id)); ?>" style="padding: 0px 15px 0px 0px !important;
			font-size: 14px !important;" type="submit" class="btn btn--primary btn-blue"><span style="padding: 7px;" class="icon icon_download"></span><?php echo e(trans('messages.profile.dwnld_invoice')); ?></a>
	</div>
	</div>
		<div class="trip-details__breakdown">
			<div class="">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 palm-one-whole soft--bottom">
					<div class="separated">
						<div class="fixed-ratio fixed-ratio--1-1">
							<div class="fixed-ratio__content ab_cont">
								<img src="<?php echo e($trip->trip_image); ?>" class="img--full img--flush">
							</div>
						</div>
					</div>
					<div class="separated section--light">
						<div class="soft separated--bottom" style="padding:20px 10px;">
							<div class="trip-address grid grid--full soft-double--bottom">
								<div class="grid__item one-tenth pull-left" style="margin-top:6px;">
									<div class="icon icon_route-dot color--positive">
									</div>
								</div>
								<div class="grid__item nine-tenths">
									<p class="flush"><?php echo e($trip->pickup_time); ?></p>
									<h6 class="color--neutral flush"><?php echo e($trip->pickup_location); ?></h6>
								</div>
							</div>
							<div class="trip-address grid grid--full">
								<div class="grid__item one-tenth pull-left" style="margin-top:6px;">
									<div class="icon icon_route-dot color--negative"></div>
								</div>
								<div class="grid__item nine-tenths">
									<p class="flush"><?php echo e($trip->drop_time); ?></p>
									<h6 class="color--neutral flush"><?php echo e($trip->drop_location); ?></h6>
								</div>
							</div>
						</div>
						<div class="soft--top">
							<div class="flexbox color--neutral" style="    padding-top: 20px;
								margin-bottom: 10px;">
								<div class="flexbox__item text--center col-lg-3 col-md-3 col-sm-3 col-xs-3">
									<div class="micro text--uppercase"><?php echo e(trans('messages.profile.car')); ?></div>
									<h5><?php echo e($trip->vehicle_name); ?></h5>
								</div>
								<div class="flexbox__item text--center col-lg-3 col-md-3 col-sm-3 col-xs-3">
									<div class="micro text--uppercase"><?php echo e(trans('messages.profile.kilometer')); ?></div>
									<h5><?php echo e($trip->total_km); ?></h5>
								</div>
								<div class="flexbox__item text--center col-lg-3 col-md-3 col-sm-3 col-xs-3">
									<div class="micro text--uppercase"><?php echo e(trans('messages.profile.trip_time')); ?></div>
									<h5><?php echo e($trip->trip_time); ?></h5>
								</div>
								<?php if($trip->pool_id): ?>
								<div class="flexbox__item text--center col-lg-3 col-md-3 col-sm-3 col-xs-3">
									<div class="micro text--uppercase">Seats </div>
									<h5><?php echo e($trip->seats); ?></h5>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 palm-one-whole soft--bottom" ng-cloak>
					<h2 class="text--center text--uppercase" style="font-size: 17px; font-weight: 600;"> <?php echo app('translator')->get('messages.profile.fare_break'); ?> </h2>
					<table class="table table--condensed fare-breakdown separated--top">
						<tbody>
							<?php $__currentLoopData = $invoice_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="gamma fare-breakdown__primary-charge text-<?php echo e($invoice['colour']); ?>">
								<td colspan="2" class="text--left"> <?php echo e($invoice['key']); ?> </td>
								<td class="text--right"> <?php echo e($invoice['value']); ?> </td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="trip-details__review col-lg-12 col-md-12 col-sm-12 col-xs-12 section--light separated--top hard--ends" style="padding:15px;">
			<div class=" soft--top">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 palm-one-whole">
					<table class="table">
						<tbody>
							<tr class="hard"><td>
								<div class="img--circle img--bordered img--shadow driver-avatar">
									<img src="<?php echo e($trip->driver_thumb_image); ?>">
								</div>
							</td>
							<td class="text--center beta"  id="pad-30" style="font-size: 18px !important;"><?php echo e(trans('messages.profile.rode_with')); ?> <?php echo e($trip->driver_name); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div></div>
	</div>
</div>
</div>
</div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/dashboard/trip_detail.blade.php ENDPATH**/ ?>
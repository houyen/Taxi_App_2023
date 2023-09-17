<div class="container mar-zero" style="padding:0px;">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 height--full dash-panel">
		<div class="height--full separated--sides pull-left full-width">
			<div style="padding:0px;" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 flexbox__item one-fifth page-sidebar hidden--portable hide-sm-760">
				<ul class="site-nav">
					<li class="soft--ends">
						<div class="center-block three-quarters push-half--bottom">
							<div class="img--circle img--bordered img--shadow fixed-ratio fixed-ratio--1-1">
								<?php if(@Auth::user()->profile_picture->src == ''): ?>
								<img src="<?php echo e(url('images/user.jpeg')); ?>" class="img--full fixed-ratio__content">
								<?php else: ?>
								<img src="<?php echo e(@Auth::user()->profile_picture->src); ?>" class="img--full fixed-ratio__content profile_picture">
								<?php endif; ?>
							</div>
						</div>
						<div class="text--center">
							<div style="font-size: 15px;color: #063870;font-weight: bold;line-height: 58px;
                            ">
								<?php echo e(@Auth::user()->first_name); ?> <?php echo e(@Auth::user()->last_name); ?>

							</div>
							<div class="soft-half--top"></div>
						</div>
					</li>
					<li>
						<a href="<?php echo e(url('trip')); ?>" aria-selected="<?php echo e((Route::current()->uri() == 'trip') ? 'true' : 'false'); ?>" class="side-nav-a"><?php echo e(trans('messages.header.mytrips')); ?></a>
					</li>
					<li>
						<a href="<?php echo e(url('profile')); ?>" aria-selected="<?php echo e((Route::current()->uri() == 'profile') ? 'true' : 'false'); ?>" class="side-nav-a"><?php echo e(trans('messages.header.profil')); ?></a>
					</li>
					<li>
						<a href="<?php echo e(route('referral')); ?>" aria-selected="<?php echo e((Route::current()->uri() == 'referral') ? 'true' : 'false'); ?>" class="side-nav-a">
							<?php echo e(trans('messages.referrals.referral')); ?>

						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="side-nav-a social-dropdown-btn">Support<i class="fa fa-caret-down"></i></a>
						<ul class="dropdown-container site_nav">
							<?php $__currentLoopData = $support_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $support_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($support_link->id==1): ?>
                                <?php $support_link->link = 'https://web.whatsapp.com/send?phone=+'.$support_link->link ?>
                            <?php elseif($support_link->id==2): ?>
                                <?php $support_link->link = 'https://join.skype.com/invite/'.$support_link->link ?>
                            <?php endif; ?>
							<li style="display: flex;align-items: center;">
                                <img src="<?php echo e($support_link->image_src); ?>" style="width: 20px;height: 20px;margin-right: 10px;">
                                <?php if(is_numeric($support_link->link) || str_starts_with($support_link->link,'+') ): ?>
                                	<a target="_blank" data-toggle="modal" data-target="#support_links" name='mobile_number_tab' data-index='<?php echo e($support_link->link); ?>' class="side-nav-a" href="<?php echo e($support_link->link); ?>"><?php echo e($support_link->name); ?></a>
                                <?php else: ?>
                                	<a target="_blank" class="side-nav-a" href="<?php echo e($support_link->link); ?>"><?php echo e($support_link->name); ?></a>
                               <?php endif; ?>
                            </li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
					<li class="logout"><a href="<?php echo e(url('sign_out')); ?>"><?php echo e(trans('messages.header.logout')); ?></a></li>
				</ul>
			</div>
			<div class="modal poppayout fade" id="support_links" aria-hidden="false" tabindex="-1">
				<div id="modal-add-payout-set-address" class="modal-content">	
					<div class="panel-header">
						<button type="button" class="close" data-dismiss="modal"></button>
							Contact Number
					</div>
					<div class="payout_popup_view">
						<div class="payout_input_field">
							<label for="payout_info_payout_country"> 
								<em  id=pop_up_mobile_number>
								</em> 
							</label>
						</div>
					</div>
				</div>
			</div>

			
<?php $__env->startPush('scripts'); ?>
	<script type="text/javascript">
		$("a[name=mobile_number_tab]").on("click", function () { 
	    var mobile_number = $(this).attr("data-index");
	    console.log(mobile_number);
	    $("#pop_up_mobile_number").text(mobile_number);
		});
	</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/common/dashboard_side_menu.blade.php ENDPATH**/ ?>
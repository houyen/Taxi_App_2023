<div class="dash-head" id="dashhead">
    <div class="container-fluid">
  <div class="col-lg-12 col-md-12 col-sm-11 col-xs-12 dash-panel">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 headlog">
      <button type="button" class="navbar-toggle nav-click hide-md-760" data-toggle="collapse" data-target="#menu-collapse">
      <a href="#" data-slide-menu="#slide-menu" data-slide-menu-content="#slide-menu-content" class="text--uppercase menu-a">
       <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> <?php echo app('translator')->get('messages.header.menu'); ?> </a>
        </button>
         
        <div class="nav-div" style="padding:0px !important;">
          <div class="icon-remove remove-bold " style="padding: 15px 15px !important;float: right !important;"> </div>
          <div class="flexbox__item flexbox__item--expand">
            <ul class="site-nav site-nav--flush site-nav--dark block-list push-half--bottom">
              <li>
                <div class="flexbox" style="margin-top:25px;">
                  <div class="flexbox__item one-eighth pull-left">
                    <div class="img--circle img--bordered img--shadow fixed-ratio fixed-ratio--1-1 head_profile">
                      <?php if(@Auth::user()->profile_picture->src == ''): ?>
                      <img src="https://d1w2poirtb3as9.cloudfront.net/default.jpeg" class="img--full fixed-ratio__content">
                      <?php else: ?>
                      <img src="<?php echo e(@Auth::user()->profile_picture->src); ?>" class="img--full fixed-ratio__content profile_picture">
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="flexbox__item four-eighths soft-half--left pull-left" style="margin: 5px 30px 0px;
                    font-size: 13px;">
                    <div class="text--normal"><?php echo e(@Auth::user()->first_name); ?> <?php echo e(@Auth::user()->last_name); ?></div>
                  </div>
                  <div class="flexbox__item three-eighths text--right">
                  </div>
                </div>
                <div id="slide-menu-account-progress" class="pro_bar" style="margin-top:20px;">
                  <div class="soft--top milli text--left">
                    <div class="grid">
                      <div class="grid__item three-quarters">
                        <strong> <?php echo app('translator')->get('messages.header.profile'); ?> </strong>
                      </div>
                      <div class="grid__item one-quarter text--right">
                        <strong class="color--negative">33%</strong>
                      </div>
                    </div>
                    <div class="progress push-half--top push--bottom">
                      <div style="width: 33%" class="progress__bar progress__bar--negative">
                      </div>
                    </div>
                    <div>
                      <span class="micro icon icon1--circle icon_check push-half--right icon1--inactive">
                      </span>
                      <a href="#" data-toggle="modal" data-target="#verify-email-modal" class="link--immutable"> <?php echo app('translator')->get('messages.header.verify_email'); ?> </a>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <a href="<?php echo e(url('trip')); ?>" class="active"> <?php echo app('translator')->get('messages.header.mytrips'); ?> </a>
              </li>
              <li>
                <a href="<?php echo e(url('profile')); ?>"> <?php echo app('translator')->get('messages.header.profile'); ?> </a>
              </li>
              <li>
                  <a href="<?php echo e(route('referral')); ?>"> <?php echo app('translator')->get('messages.referrals.referral'); ?> </a>
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
                                 
                                  <a target="_blank" data-toggle="modal" data-target="#mobile_number_tab" name='mobile_number_tab' data-index='<?php echo e($support_link->link); ?>' class="side-nav-a" href="<?php echo e($support_link->link); ?>"><?php echo e($support_link->name); ?></a>
                                  <?php else: ?>
                                 
                                   <a href="javascript:void(0)"  class="nav-link"><img src="<?php echo e($support_link->support_image); ?>" style="width: 45px;height:45px;margin:0px 10px 0px 0;object-fit: cover;display: inline-block;border-radius: 50%;"> 
                                      <span><?php echo e($support_link->name); ?></span></a>
                                  <?php endif; ?>    
                              </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </li>
           <li class="logout">
            
                  <a href="<?php echo e(url('sign_out')); ?>"> <?php echo app('translator')->get('messages.header.logout'); ?> </a>
                </li>
            </ul>
            <div class="soft-half hide-sm-760">
              <ul class="block-list text--uppercase">
                <li class="logout">
                  <a href="<?php echo e(url('sign_out')); ?>"> <?php echo app('translator')->get('messages.header.logout'); ?> </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <a href="<?php echo e(url('/')); ?>">
          <img class="dash-head-logo" src="<?php echo e($logo_url); ?>">
        </a>
        <ul class="nav--block float--right flush hidden--portable hide-sm-760">
          <li class="user-flyout flyout flyout--right">
            <a href="#" class="flyout__origin">
               <?php if(@Auth::user()->profile_picture->src == ''): ?>
              <span class="icon icon_profile alpha push-half--right">
              </span>
              <?php else: ?>               
               <img src="<?php echo e(@Auth::user()->profile_picture->src); ?>" class="img--bordered img--full head_profile profile_picture">
              <?php endif; ?>
              <span class="push-half--right"><?php echo e(@Auth::user()->first_name); ?> <?php echo e(@Auth::user()->last_name); ?></span>
              <span class="icon icon_down-arrow milli">
              </span>
            </a>
            <div class="flyout__content" style="margin:-1px 0px 0px 0px !important;padding:0px;border-radius: 30px !important">
              <ul class="site-nav site-nav--flush" style="margin-right: 0">
                <li>
                  <div class="grid displayflex">
                    <div class="grid__item one-quarter">
                      <?php if(@Auth::user()->profile_picture->src == ''): ?>
                      <img src="https://d1w2poirtb3as9.cloudfront.net/default.jpeg" class="img--bordered head_profile img--full">
                      <?php else: ?>
                      <img src="<?php echo e(@Auth::user()->profile_picture->src); ?>" class="img--bordered img--full head_profile profile_picture">
                      <?php endif; ?>
                    </div>
                    <div class="grid__item three-quarters">
                      <h3 class="push-half--bottom"><?php echo e(@Auth::user()->first_name); ?> <?php echo e(@Auth::user()->last_name); ?></h3>
                    </div>
                  </div>
                </li>
                <li>
                  <a href="<?php echo e(url('trip')); ?>" class="active"> <?php echo app('translator')->get('messages.header.mytrips'); ?> </a>
                </li>
                <li>
                  <a href="<?php echo e(url('profile')); ?>"> <?php echo app('translator')->get('messages.header.profile'); ?> </a>
                </li>
                <li class="logout">
                  <a href="<?php echo e(url('sign_out')); ?>"> <?php echo app('translator')->get('messages.header.logout'); ?> </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
  <div class="flash-container">
    <?php if(Session::has('message')): ?>
    <div class="alert text-center participant-alert" style="background: #dff0d8 !important;color: #3c763d !important;" role="alert">
      <a href="#" class="alert-close text-white" data-dismiss="alert"></a>
      <?php echo Session::get('message'); ?>

    </div>
    <?php endif; ?>
  </div>
<?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/common/dashboard_header.blade.php ENDPATH**/ ?>
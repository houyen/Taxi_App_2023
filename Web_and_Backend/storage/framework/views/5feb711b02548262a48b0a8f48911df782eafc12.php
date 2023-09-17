<?php $__env->startSection('main'); ?>
<div class="topbanner" style="padding-bottom: 5em">
  <div class="container">
    <div class="col-lg-12 displayflex">
      <div class="col-lg-5 col-md-5">
        <div class="topbannertxt">
          <h1><?php echo e(trans('messages.drive.start_drive_with')); ?> <?php echo e($site_name); ?></h1>

          <p><?php echo e(trans('messages.home.drivedesc',['site_name'=>$site_name])); ?></p>

          <ul>
            <li>
              <?php if($app_links[1]->value !="" ): ?>
              <a href="<?php echo e($app_links[1]->value); ?>" target="_blank"><img src="images/new/app.png" alt="app"></a>
              <?php endif; ?>
            </li>
            <li>
              <?php if($app_links[3]->value !="" ): ?>
              <a href="<?php echo e($app_links[3]->value); ?>" target="_blank">
                <img src="<?php echo e(url('images/new/google.png')); ?>" alt="Get it on Googleplay" class="CToWUd bot_footimg">
              </a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-7 col-md-7">
        <div class="topbannerimg">
          <img src="images/new/drivebanner.png" alt="banner">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="alllogin">
  <div class="container">
    <?php if(Auth::user()==null): ?>
    <div class="col-lg-12 alllogintop">
      <div class="col-lg-4">
        <div class="allloginone">
          <h3><?php echo e(trans('messages.home.siginup_drive')); ?></h3>

          <a href="<?php echo e(url('signup_driver')); ?>"><?php echo e(trans('messages.home.siginup')); ?> <img src="images/new/arrow-right.svg" alt="arrow"></a>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php if(Auth::user()!==null): ?>
    <div class="col-lg-12 alllogintop" style="padding-bottom: 15px;">

      <div class="allloginonetxt">
        <h3><?php echo e(trans('messages.drive.works_first')); ?></h3>
        <p><?php echo e(trans('messages.drive.drive_you_need')); ?></p>
      </div>
    </div>
    <?php endif; ?>
    <div class="col-lg-12 allloginbottom">
      <div class="col-lg-4">
        <div class="alllogintwo">
          <img src="images/new/easyway.svg" alt="icon">
          <h4><?php echo e(trans('messages.drive.own_schedule')); ?></h4>
          <p><?php echo e(trans('messages.drive.drive_with')); ?> <?php echo e($site_name); ?> <?php echo e(trans('messages.drive.anytime')); ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="alllogintwo">
          <img src="images/new/anywhare.svg" alt="icon">
          <h4><?php echo e(trans('messages.drive.every_turn')); ?></h4>
          <p><?php echo e(trans('messages.drive.fare_start')); ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="alllogintwo">
          <img src="images/new/lowcost.svg" alt="icon">
          <h4><?php echo e(trans('messages.drive.app_lead')); ?></h4>
          <p><?php echo e(trans('messages.drive.tap_go')); ?></p>
        </div>
      </div>
    </div>

   <!--  <div class="col-lg-12 allloginbottom1">
      <a href="<?php echo e(url('ride')); ?>"><?php echo e(trans('messages.home.reason')); ?> <img src="images/new/arrow-right.svg" alt="arrow"></a>
    </div> -->
  </div>
</div>

<div class="cls_driverone">
  <div class="container">
    <div class="col-lg-12">
      <div class="cls_driveronetxt">
        <h3><?php echo e(trans('messages.drive.hit_road')); ?></h3>
        <p><?php echo e(trans('messages.drive.easy_started')); ?></p>
      </div>
      <div class="cls_dottedline">
        <div class="col-lg-4">
          <div class="circle">
            1
          </div>
        </div>
        <div class="col-lg-4">
          <div class="circle">
            2
          </div>
        </div>
        <div class="col-lg-4">
          <div class="circle">
            3
          </div>
        </div>
        <div class="line"></div>
      </div>

    </div>
    <div class=" cls_driveronebottom">
      <div class="col-lg-4">
        <div class="cls_driveronetwo">
          <h4><?php echo e(trans('messages.drive.sign_online')); ?></h4>
          <p><?php echo e(trans('messages.drive.about_yourself')); ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="cls_driveronetwo">
          <h4><?php echo e(trans('messages.drive.share_doc')); ?></h4>
          <p><?php echo e(trans('messages.drive.upload_license')); ?></p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="cls_driveronetwo">
          <h4><?php echo e(trans('messages.drive.get_app')); ?></h4>
          <p><?php echo e(trans('messages.drive.approve_drive')); ?> <?php echo e($site_name); ?> <?php echo e(trans('messages.drive.provide_you_need')); ?></p>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<div class="cls_sectionone" style="padding: 0px">
  <div class="container">
    <div class="row  displayflex">
      <div class="col-lg-6">
        <div class="cls_sectiononetxt">
          <h4 class="text-twotruncate"><?php echo e(trans('messages.drive.about_app')); ?></h4>
          <p class=""><?php echo e(trans('messages.drive.make_money')); ?></p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="cls_sectiononeimg">
          <img src="images/new/image3.jpg" alt="banner">
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="cls_arriving">
  <div class="container">
    <div class="title">
      <h5><?php echo e(trans('messages.home.now_arrive')); ?></h5>
      <h6><?php echo e(trans('messages.home.safe')); ?></h6>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="cls_arrivingin">
          <img src="images/new/arrive2.svg" alt="banner">
          <h5><?php echo e(trans('messages.drive.making_money')); ?></h5>
          <p><?php echo e(trans('messages.drive.ready_money')); ?></p>
          <a href="<?php echo e(url('signup_driver')); ?>" class="cls_arrivinginatag"><?php echo e(trans('messages.home.siginup_drive')); ?><img src="images/new/arrow-right.svg" alt="arrow"></a>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="cls_arrivingin">
          <img src="images/new/arrive1.svg" alt="banner">

          <h5><?php echo e(trans('messages.drive.support')); ?></h5>
          <p><?php echo e(trans('messages.drive.we_want')); ?> <?php echo e($site_name); ?> <?php echo e(trans('messages.drive.hassle_free')); ?></p>
        </div>
      </div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templatesign', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/drive/drive.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html>
<head>
  <title>Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
</head>

<?php echo Html::style('css/webpayment.css'); ?>


  <?php echo Html::style('css/bootstrap.css'); ?>

  <?php echo Html::style('css/font-awesome.min.css'); ?>

  <?php echo Html::style('css/main.css?v='.$version); ?>

  <?php echo Html::style('css/common.css?v='.$version); ?>

  <?php echo Html::style('css/common1.css?v='.$version); ?>

  <?php echo Html::style('css/styles.css?v='.$version); ?>

  <?php echo Html::style('css/home.css?v='.$version); ?>

  
  <?php echo Html::style('css/popup.css?v='.$version); ?>


  <?php echo Html::style('css/jquery.bxslider.css'); ?>

  <?php echo Html::style('css/jquery.sliderTabs.min.css'); ?>

  <?php if(Route::current()->uri() != 'driver_payment'): ?>
  <?php echo Html::style('css/jquery-ui.min.css'); ?> 
  <?php endif; ?>
<body ng-app="App" class="">

  <main>
    <div class="payment-form" id="theme">
      <div class="main-header">
        <img src="<?php echo e(url('images/new/flutterwave.png')); ?>" alt="Pay with Flutterwave" class="CToWUd bot_footimg">
      </div>
      <form id="checkout_payment" method="post" action="<?php echo e(route('payment.flutterwave')); ?>">
        <input type="hidden" name="pay_key" id="nonce"> 
      
      <!-- Phone Number -->
      <div class="form-outline mb-4">
        <label class="form-label" for="phoneNumber">Phone Number</label>
        <input type="tel" id="phoneNumber" class="form-control" required/>
       
      </div>
        <input type="hidden" name="amount" value="<?php echo e($amount); ?>"> 
        <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>"> 
        <input type="hidden" name="pay_for" value="<?php echo e($pay_for); ?>">
        <input type="hidden" name="currency_code" value="<?php echo e($currency_code); ?>"> 
      <!-- Email Address -->
      <div class="form-outline mb-4">
        <label class="form-label" for="Email">Email Address</label>
        <input type="email" id="Email" name="email"class="form-control" required />
      </div>
      <br>
      <!-- Submit button -->
       <button type="submit">Pay <?php echo e($currency_code); ?> <?php echo e($amount); ?></button>

       </div>
       
     </form>
   </div>
 </main>
</body>




<?php echo Html::script('js/jquery-1.11.3.js'); ?>

<?php echo Html::script('js/jquery-ui.js'); ?>

<?php echo Html::script('js/angular.js'); ?>

<?php echo Html::script('js/angular-sanitize.js'); ?>


<script>
  var app = angular.module('App', ['ngSanitize']);
  var APP_URL = <?php echo json_encode(url('/')); ?>;

    // Get URL to Create Dark theme
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('mode');
    var element = document.getElementById("theme");
    element.classList.add(myParam);

  </script>
  
  <?php echo $__env->yieldPushContent('scripts'); ?>
  </html><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/payment/flutterwave.blade.php ENDPATH**/ ?>
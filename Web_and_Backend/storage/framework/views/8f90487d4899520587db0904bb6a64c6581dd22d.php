<!DOCTYPE html>
<html>
<head>
  <title>Mpesa Payment</title>
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
    <div class="payment-form" id="theme" style="margin-top:100px">
      <div class="main-header">
     <img src="<?php echo e(url('images/new/mpesa.png')); ?>" alt="Pay with Mpesa" width="180" class="CToWUd bot_footimg">
      </div>
      <form id="checkout_payment" method="post" action="<?php echo e(route('payment.mpesa')); ?>">
        <input type="hidden" name="pay_key" id="nonce"> 
      
      <!-- Phone Number -->
      <div class="form-outline mb-9" style="margin-bottom:10px">
        <label class="form-label" for="PhoneNumber">Please Enter Phone Number</label>
        <input type="tel" id="PhoneNumber" name="phone_number" class="form-control" required minlength="10" maxlength="10" />
       <span id="phoneError" style="color: red; display: none;">Please enter a valid phone number with 10 digits.</span>
        <input type="hidden" name="amount" value="<?php echo e($amount); ?>"> 
        <input type="hidden" name="user_id" value="<?php echo e($user_id); ?>"> 
        <input type="hidden" name="pay_for" value="<?php echo e($pay_for); ?>">
        <input type="hidden" name="currency_code" value="<?php echo e($currency_code); ?>"> 
       
      </div>
    

      <!-- Submit button -->
      <button type="submit">Pay <?php echo e($currency_code); ?> <?php echo e($amount); ?></button>

       </div>
       
     </form>
   </div>
 </main>
</body>





<script>
    var phoneNumberInput = document.getElementById('PhoneNumber');
    var phoneError = document.getElementById('phoneError');

    phoneNumberInput.addEventListener('input', function() {
        var phoneNumber = phoneNumberInput.value;
        if (phoneNumber.length < 10 || phoneNumber.length > 10) {
            phoneError.style.display = 'block';
        } else {
            phoneError.style.display = 'none';
        }
    });
</script>
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
  </html><?php /**PATH /home/seentec3/new.newtaxi.co/resources/views/payment/mpesa.blade.php ENDPATH**/ ?>
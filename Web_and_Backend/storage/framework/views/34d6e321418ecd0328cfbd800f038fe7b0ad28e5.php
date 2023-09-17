<div class="row">
  <div class="col-md-12" >
    <div class="group" >
      <?php $__currentLoopData = $data['data']['save_card']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <label>
        <span><input type="radio" name="save_card_id" value="<?php echo e($card->id); ?>"></span>
        <div id="saved-card">**** **** **** <?php echo e($card->last4); ?>  <?php echo e($card->brand); ?></div>
      </label>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div id="pouet">
        <span><input type="radio" name="save_card_id" value="" id="new-card-radio"></span>
        <div id="card-element" class="field"></div>      
      </div>
      <div id="pouet">
        <span><input type="checkbox" name="save_card" ><?php echo e(trans('messages.api.saved_cards')); ?></span>
      </div>
    </div>
    <div class="outcome">
      <div class="error"></div>
      <div class="success-saved-card">
        Success! Your are using saved card <span class="saved-card"></span>
      </div>
      <div class="success-new-card">
        Success! The Stripe token for your new card is <span class="token"></span>
      </div>
    </div>
    <button type="submit"><?php echo e(trans('messages.api.pay')); ?> <?php echo e($data['currency_code']); ?><?php echo e($data['amount']); ?></button>
  </div>
</div>
<input type="hidden" name="paymentMethod_id" id="paymentMethod_id" value="">
<?php $__env->startPush('scripts'); ?>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
  var stripe = Stripe('<?php echo e($data["data"]["public_key"]); ?>');
  var elements = stripe.elements();
  let type = '<?php echo e(request()->mode); ?>';
  if(type == ''){
    var color = '#222222'
  }
  else 
  {
    var color = type == 'light' ? '#222222' : '#fff';
  }
    var card = elements.create('card', { 
    hidePostalCode:true,
    style: {
      base: {
        iconColor: '#666EE8',
        color: color,
        lineHeight: '40px',
        fontWeight: 300,
        fontSize: '15px',
        '::placeholder': {
          color: '#CFD7E0',
        },
      },
    }
  });
  card.mount('#card-element');

  function setOutcome(result) {
    var successNewCardElement = document.querySelector('.success-new-card');
    var successSavedCardElement = document.querySelector('.success-saved-card');
    var errorElement = document.querySelector('.error');
    successNewCardElement.classList.remove('visible');
    successSavedCardElement.classList.remove('visible');
    errorElement.classList.remove('visible');
    if (result.paymentMethod) {
      $('#paymentMethod_id').val(result.paymentMethod.id);
      $('#payment_type').val('Stripe');
      $('.payment-form').addClass('loader');
      $('#checkout_payment').submit();
    }  else if (result.error) {
      errorElement.textContent = result.error.message;
      errorElement.classList.add('visible');
    }
  }

  card.on('focus', function(event) {
    document.querySelector('#new-card-radio').checked = true;
  });

  card.on('change', function(event) {
    setOutcome(event);
  });

  document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    var radioButton = document.querySelector('input[name="save_card_id"]:checked');
    if (!radioButton.value) {
      stripe.createPaymentMethod({
        type: 'card',
        card: card,
      }).then(setOutcome);
    } else {
      $('#paymentMethod_id').val('');
      $('#payment_type').val('Stripe');
      $('.payment-form').addClass('loader');
      $('#checkout_payment').submit();
    }
  });


</script>

<script type="text/javascript">
  var payment_intent_client_secret  = "<?php echo e($errors->has('two_step_id') ? $errors->first('two_step_id') :''); ?>";

    // Stripe 3D Secure Payment Starts
    $(document).ready(function() {
      if(payment_intent_client_secret != '') {
        handleServerResponse(payment_intent_client_secret);
      }
    });

    function handleServerResponse(payment_intent_client_secret) {
      stripe.handleCardAction(payment_intent_client_secret)
      .then(function(result) {
        if (result.error) {
            // Show error in payment form
          }
          else {
            // The card action has been handled & The PaymentIntent can be confirmed again on the server
            $('#nonce').val(result.paymentIntent.id);
            $('#payment_type').val('Stripe');
            $('.payment-form').addClass('loader');
            $('#checkout_payment').submit();
            // Disable Payment Button and confirm Booking
          }
        });
    };
    // Stripe 3D Secure Payment Ends

  </script>

  <?php $__env->stopPush(); ?><?php /**PATH C:\xampps\htdocs\eycab\resources\views/payment/stripe.blade.php ENDPATH**/ ?>

<div class="cls_paypal" ng-controller="checkout"  ng-init="currency_code='<?php echo e($data['currency_code']); ?>'; tokenization_key='<?php echo e($data['data']['tokenization_key']); ?>'; merchant_account_id='<?php echo e($data['data']['merchant_account_id']); ?>';amount=<?php echo e($data['amount']); ?>" >
        <div class="content">   
            <div id="paypal-buttons"> </div>
        </div>
</div>



 <?php $__env->startPush('scripts'); ?>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo e($data['data']['client_id']); ?>&currency=<?php echo e($data['currency_code']); ?>&vault=true&disable-funding=credit,card"></script>


     <script>

        app.controller('checkout', ['$scope', '$http','$timeout', function($scope, $http, $timeout) {

       paypal.Buttons({
         style: {
            color : 'blue',
            label : 'pay',
            height : 45
          },
        createOrder: function(data, actions) {
          // This function sets up the details of the transaction, including the amount and line item details.
          return actions.order.create({
            intent:"CAPTURE",
            purchase_units: [{
              amount: {
                value: $scope.amount
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          // This function captures the funds from the transaction.
          return actions.order.capture().then(function(details) {
              $('#nonce').val(details.id);
              $('#payment_type').val('Paypal');
              $('#checkout_payment').submit();

            // This function shows a transaction success message to your buyer.
          });
        },
        onError: function (err) {
            window.location.href = APP_URL+'/api/payment/cancel?type=error';
        },
        onCancel: function (data) {
          // window.location.href = APP_URL+'/api/payment/cancel?type=cancel';
        }
}).render('#paypal-buttons');

}]);
    </script>


<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampps\htdocs\eycab\resources\views/payment/paypal.blade.php ENDPATH**/ ?>
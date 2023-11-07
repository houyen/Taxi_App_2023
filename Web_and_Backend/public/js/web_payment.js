app.controller('checkout', ['$scope', '$http','$timeout', function($scope, $http, $timeout) {
  
setTimeout(function(){


// Create a client.
  braintree.client.create({
    authorization: $scope.tokenization_key
  }, function(clientErr, clientInstance) {
    // Stop if there was a problem creating the client.
    // This could happen if there is a network error or 
    // if the authorization is invalid.
    if(clientErr) {
      console.error('Error creating client:', clientErr);
      return;
    }

    options = {};
    options.client = clientInstance;
    if($scope.merchant_account_id)
      options.merchantAccountId = $scope.merchant_account_id;
  });
})

}]);
<?php

/**
 * Payment Interface
@package     Newtaxi
 * @subpackage  Contracts
 * @category    Payment Interface
*/

namespace App\Contracts;

interface PaymentInterface
{
	function makePayment($payment_data,$nonce);
}
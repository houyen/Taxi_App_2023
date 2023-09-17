<?php

/**
 * Payment Interface
 *
 * @package     Newtaxi
 * @subpackage  Contracts
 * @category    Payment Interface
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
*/

namespace App\Contracts;

interface PaymentInterface
{
	function makePayment($payment_data,$nonce);
}
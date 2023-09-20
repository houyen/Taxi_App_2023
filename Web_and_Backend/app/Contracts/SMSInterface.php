<?php

/**
 * SMS Interface
 *
 * @package     NewTaxi
 * @subpackage  Contracts
 * @category    SMS Interface
*/

namespace App\Contracts;

interface SMSInterface
{
	function initialize();
	function send($to,$text);
}
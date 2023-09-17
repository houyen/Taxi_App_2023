<?php

/**
 * SMS Interface
 *
 * @package     NewTaxi
 * @subpackage  Contracts
 * @category    SMS Interface
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
*/

namespace App\Contracts;

interface SMSInterface
{
	function initialize();
	function send($to,$text);
}
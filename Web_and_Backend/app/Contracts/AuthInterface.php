<?php

/**
 * Auth Interface
 *
 * @package     Newtaxi
 * @subpackage  Contracts
 * @category    Auth Interface
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
*/

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthInterface
{
	public function create(Request $request);
	public function login($credentials);
}
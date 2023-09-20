<?php

/**
 * Auth Interface
 *
 * @package     Newtaxi
 * @subpackage  Contracts
 * @category    Auth Interface
*/

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthInterface
{
	public function create(Request $request);
	public function login($credentials);
}
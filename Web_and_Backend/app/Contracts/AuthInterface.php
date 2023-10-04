<?php

/**
 * Auth Interface
 * @category    Auth Interface
*/

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthInterface
{
	public function create(Request $request);
	public function login($credentials);
}
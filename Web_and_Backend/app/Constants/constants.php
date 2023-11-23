<?php

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$cash_image = secure_asset("images/icon/cash.png");
} else {
	$cash_image = asset("images/icon/cash.png");
}


$payment_methods = array(
	["key" => "cash", "value" => 'Cash', 'icon' => $cash_image],
);

if(!defined('PAYMENT_METHODS')) {
	define('PAYMENT_METHODS', $payment_methods);	
}

$payout_methods = array(
	["key" => "bank_transfer", "value" => 'Bank Transfer'],
);

if(!defined('PAYOUT_METHODS')) {
	define('PAYOUT_METHODS', $payout_methods);	
}

if(!defined('CACHE_HOURS')) {
	define('CACHE_HOURS', 24);	
}

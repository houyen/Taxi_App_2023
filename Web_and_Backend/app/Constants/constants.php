<?php

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$cash_image = secure_asset("images/icon/cash.png");
} else {
	$cash_image = asset("images/icon/cash.png");
}

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$paypal_image = secure_asset("images/icon/paypal.png");
} else {
	$paypal_image = asset("images/icon/paypal.png");
}

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$paytm_image = secure_asset("images/icon/paytm.png");
} else {
	$paytm_image = asset("images/icon/paytm.png");
}

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$flutterwave_image = secure_asset("images/icon/flutterwave.png");
} else {
	$flutterwave_image = asset("images/icon/flutterwave.png");
}

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$card_image = secure_asset("images/icon/card.png");
} else {
	$card_image = asset("images/icon/card.png");
}

if(!App::runningInConsole() && request()->getScheme()=='https') {
	$mpesa_image = secure_asset("images/icon/mpesa.png");
} else {
	$mpesa_image = asset("images/icon/mpesa.png");
}



if(!defined('CACHE_HOURS')) {
	define('CACHE_HOURS', 24);	
}

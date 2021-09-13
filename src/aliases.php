<?php

if (class_exists('RD_Api_Auth', false)) {
	return;
}

$classMap = [
	'RusaDrako\\api\\auth'             => 'RD_Api_Auth',
	'RusaDrako\\api\\result'           => 'RD_Api_Result',
	'RusaDrako\\api\\token'            => 'RD_Api_Token',
	'RusaDrako\\api\\_int_token'       => 'RD_Api_Int_Token',
	'RusaDrako\\api\\auth_exception'   => 'RD_Api_Exception',
];

foreach ($classMap as $class => $alias) {
	class_alias($class, $alias);
}

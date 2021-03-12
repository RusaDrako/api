<?php

if (class_exists('RD_Api_Auth', false)) {
    return;
}

$classMap = [
    'RusaDrako\\api\\auth' => 'RD_Api_Auth',
	'RusaDrako\\api\\result' => 'RD_Api_Result',
	'RusaDrako\\api\\token' => 'RD_Api_Token',
];

foreach ($classMap as $class => $alias) {
    class_alias($class, $alias);
}

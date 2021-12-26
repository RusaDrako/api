<pre><?php
require_once('../src/autoload.php');


$key = '0123456789ABCDEF';
$time = time();
$str_time = date('Y-m-d H:i:s', $time);
$add_data = 'test';



$api = RD_Api_Auth::call($key);



##### Корректные данные #####
$token_data = [$str_time, $add_data];
$obj_token = $api->get_token();
echo $token = $obj_token->generate(...$token_data);



echo '<hr>';
echo 'Корректные данные';
echo '<br>';
try {
	$result = $api->auth($token, ...$token_data);
} catch (\RD_Api_Exception $e) {
	echo "Генерируется ошибка RD_Api_Exception: <b>{$e->getCode()} {$e->getMessage()}</b>";
	echo '<br>';
//	var_dump($e);
} finally {
	echo 'Ошибка не должна была сгенерироваться';
}





##### Ошибочные данные #####
$token_data = [$str_time, $add_data.'1'];
echo '<hr>';
echo 'Ошибочные данные';
echo '<br>';
try {
	$result = $api->auth($token, ...$token_data);
} catch (\RD_Api_Exception $e) {
	echo "Генерируется ошибка RD_Api_Exception: <b>{$e->getCode()} {$e->getMessage()}</b>";
	echo '<br>';
//	var_dump($e);
} finally {
	echo 'Ошибка должна была сгенерироваться';
}



echo '<hr>';
echo 'Конец кода';

<pre><?php
require_once('../src/autoload.php');

use  RusaDrako\api\Auth;
use  RusaDrako\api\ExceptionAuth;

$key = '0123456789ABCDEF';
$time = time();
$str_time = date('Y-m-d H:i:s', $time);
$add_data = 'test';

$api = new Auth($key);

##### Корректные данные #####
$token_data = [$str_time, $add_data];
$obj_token = $api->get_token();
echo $token = $obj_token->generate(...$token_data);

echo '<hr>';
echo '<hr>';
echo 'Корректные данные';
echo '<br>';
try {
	$result = $api->auth($token, ...$token_data);
} catch (ExceptionAuth $e) {
	echo "Генерируется ошибка " . get_class($e) . ": <b>{$e->getCode()} {$e->getMessage()}</b>";
	echo '<br>';
//	var_dump($e);
} finally {
	echo '<span style="background:#bfb;"> Ошибка не должна была сгенерироваться </span>';
	echo '<br>';
}

##### Ошибочные данные #####
$token_data = [$str_time, $add_data.'1'];
echo '<hr>';
echo '<hr>';
echo 'Ошибочные данные';
echo '<br>';
try {
	$result = $api->auth($token, ...$token_data);
} catch (ExceptionAuth $e) {
	echo "Генерируется ошибка " . get_class($e) . ": <b>{$e->getCode()} {$e->getMessage()}</b>";
	echo '<br>';
//	var_dump($e);
} finally {
	echo '<span style="background:#fbb;"> Ошибка должна была сгенерироваться </span>';
	echo '<br>';
}

echo '<hr>';
echo '<hr>';

$api->get_result()->result('Ок');

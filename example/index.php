<pre><?php
require_once('../src/autoload.php');


$key = '0123456789ABCDEF';
$time = time();
$str_time = date('Y-m-d H:i:s', $time);
$add_data = 'test';



$api = RD_Api_Auth::call($key);



$token_data = [$str_time, $add_data];
$obj_token = $api->get_token();
echo $token = $obj_token->generate(...$token_data);



echo '<hr>';
echo 'Полное совпадение';
echo '<br>';
$result = $api->auth($token, ...$token_data);
var_dump($result);



$token_data = [$str_time, $add_data.'1'];
echo '<hr>';
echo 'Ошибка';
echo '<br>';
$result = $api->auth($token, ...$token_data);
var_dump($result);



echo '<hr>';
echo 'А этот текст мы не выводим';

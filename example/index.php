<pre><?php
require_once('../src/autoload.php');


$key = '0123456789ABCDEF';
$time = time();
$str_time = date('Y-m-d H:i:s', $time);
$add_data = 1;
$delta = 300;



$api = RD_Api_Auth::call($key, $delta);
var_dump($token = $api->get_token($str_time, $add_data));



echo '<hr>';
echo 'Полное совпадение';
echo '<br>';
$result = $api->auth($token, $str_time, $add_data);
var_dump($result);



echo '<hr>';
echo 'до + $delta';
$_time = date('Y-m-d H:i:s', $time + ($delta - 10));
$_token = $api->get_token($_time, $add_data);
$result = $api->auth($_token, $_time, $add_data);
echo '<br>';
var_dump($result);



echo '<hr>';
echo 'до - $delta';
$_time = date('Y-m-d H:i:s', $time - ($delta - 10));
$_token = $api->get_token($_time, $add_data);
$result = $api->auth($_token, $_time, $add_data);
echo '<br>';
var_dump($result);



echo '<hr>';
echo '$add_data != => 101';
echo '<br>';
$result = $api->auth($_token, $str_time, $add_data + 1);
echo '<br>';
var_dump($result);



echo '<hr>';
echo '$add_data = null => 203';
echo '<br>';
$result = $api->auth($_token, $str_time, null);
echo '<br>';
var_dump($result);



echo '<hr>';
echo 'более + $delta => 102';
echo '<br>';
$_time = date('Y-m-d H:i:s', $time + ($delta + 10));
$_token = $api->get_token($_time, $add_data);
$result = $api->auth($_token, $_time, $add_data);
echo '<br>';
var_dump($result);



echo '<hr>';
echo 'более - $delta => 102';
echo '<br>';
$_time = date('Y-m-d H:i:s', $time - ($delta + 10));
$_token = $api->get_token($_time, $add_data);
$result = $api->auth($_token, $_time, $add_data);
echo '<br>';
var_dump($result);



echo '<hr>';
echo '$token = null => 101';
echo '<br>';
$result = $api->auth(null, $str_time, $add_data);
echo '<br>';
var_dump($result);



echo '<hr>';
echo '$str_time = null => 102';
echo '<br>';
$result = $api->auth($token, null, $add_data);
echo '<br>';
var_dump($result);



$api = new RD_Api_Auth($key, 0);



echo '<hr>';
echo '$str_time = null => 202';
echo '<br>';
$result = $api->auth($token, null, $add_data);
echo '<br>';
var_dump($result);




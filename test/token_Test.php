<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');





/** Класс-тестировщик для token
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class token_Test extends TestCase {
	/** */
	private $token_key      = '0123456789ABCDEF';
	private $time           = null;
	private $str_time       = null;
	private $add_data       = 1;
	private $delta          = 600;
	/** Тестируемый объект */
	private $_test_object   = null;





	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->time           = time();
		$this->str_time       = date('Y-m-d H:i:s', $this->time);
		$this->_test_object   = new RD_Api_Token($this->token_key);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Вызывается после каждого запуска тестового метода */
	protected function get_token($time, $add_data) {
		$str_time = \date('Y-m-d H:i', $time);
		$token = \md5($this->token_key . $add_data . $str_time);
		return $token;
	}



	/** Тестирование ОК */
	public function test_ok() {
		$token = $this->get_token($this->time, $this->add_data);
		$this->assertEquals($this->_test_object->generate($this->str_time, $this->add_data), $token, 'Контроль токена не прошёл');
	}



	/** Ошибка передачи пустого ключа */
	public function test_not_key_201() {
		$e = false;
		try {
			$this->_test_object->generate(null, $this->add_data);
		} catch (\Exception $e) {}

		$this->assertTrue(is_object($e), 'Объект ошибки не найден: Ошибка передачи пустого времени');
		$this->assertTrue(is_a($e, 'RusaDrako\\api\\auth_exception'), 'Объект ошибки неправильный');

		$str_err = "AUTH: Временная точка не найдена";
		$this->assertEquals(substr($e->getMessage(), 0, strlen($str_err)), $str_err, 'Неверное сообщение об ишибке');
		$this->assertEquals($e->getCode(), 201, 'Неверный код ошибки');
	}



	/** Ошибка передачи пустого времени */
	public function test_not_data_203() {
		$token = $this->get_token($this->time, $this->add_data);

		$e = false;
		try {
			$this->_test_object->generate($this->str_time, null);
		} catch (\Exception $e) {}

		$this->assertTrue(is_object($e), 'Объект ошибки не найден: Ошибка передачи пустого дополнительных данных');
		$this->assertTrue(is_a($e, 'RusaDrako\\api\\auth_exception'), 'Объект ошибки неправильный');

		$str_err = "AUTH: Контрольное значение не перед";
		$this->assertEquals(substr($e->getMessage(), 0, strlen($str_err)), $str_err, 'Неверное сообщение об ишибке');
		$this->assertEquals($e->getCode(), 203, 'Неверный код ошибки');
	}



	/** Контроль времени - ОК = + (delta - 10) */
	public function test_time_plus_delta() {
		$time = $this->time + ($this->delta - 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);
		$this->assertEquals(
			$this->_test_object->generate($str_time, $this->add_data), $token, 'Контроль времени - ОК = + (delta - 10)');
	}



	/** Контроль времени - ОК = - (delta - 10) */
	public function test_time_minus_delta() {
		$time = $this->time - ($this->delta - 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);
		$this->assertEquals($this->_test_object->generate($str_time, $this->add_data), $token, 'Контроль времени - ОК = - (delta - 10)');
	}



	/** Контроль времени - Error = - (delta + 10) */
	public function test_time_plus_delta_202() {
		$time = $this->time - ($this->delta + 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);

		$e = false;
		try {
			$this->_test_object->generate($str_time, $this->add_data);
		} catch (\Exception $e) {}

		$this->assertTrue(is_object($e), 'Объект ошибки не найден: Контроль времени - Error = - (delta + 10)');
		$this->assertTrue(is_a($e, 'RusaDrako\\api\\auth_exception'), 'Объект ошибки неправильный');

		$str_err = "AUTH: Ограничение токена по времени";
		$this->assertEquals(substr($e->getMessage(), 0, strlen($str_err)), $str_err, 'Неверное сообщение об ишибке');
		$this->assertEquals($e->getCode(), 202, 'Неверный код ошибки');
	}



	/** Контроль времени - Error = + (delta + 10) */
	public function test_time_minus_delta_202() {
		$time = $this->time + ($this->delta + 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);

		$e = false;
		try {
			$this->_test_object->generate($str_time, $this->add_data);
		} catch (\Exception $e) {}

		$this->assertTrue(is_object($e), 'Объект ошибки не найден: Контроль времени - Error = + (delta + 10)');
		$this->assertTrue(is_a($e, 'RusaDrako\\api\\auth_exception'), 'Объект ошибки неправильный');

		$str_err = "AUTH: Ограничение токена по времени";
		$this->assertEquals(substr($e->getMessage(), 0, strlen($str_err)), $str_err, 'Неверное сообщение об ишибке');
		$this->assertEquals($e->getCode(), 202, 'Неверный код ошибки');
	}



/**/
}

<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');





/** Класс-тестировщик для auth
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class auth_Test extends TestCase {
	/** */
	private $token_key = '0123456789ABCDEF';
	private $time = null;
	private $str_time = null;
	private $add_data = 1;
	private $delta = 300;
	private $token = null;
	/** Тестируемый объект */
	private $_test_object = null;
	private $_object_token = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->time = time();
		$this->str_time = date('Y-m-d H:i:s', $this->time);
		$this->_test_object = new RD_Api_Auth($this->token_key, $this->delta);
		$this->_test_object->test(true);
		$this->_object_token = new RD_Api_Token();
		$this->_object_token->test(true);
		$this->token = $this->_object_token->calculate($this->token_key, $this->str_time, $this->add_data);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Контроль токена прошёл */
	public function test_ok() {
		$this->assertTrue(
			$this->_test_object->auth($this->token, $this->str_time, $this->add_data), 'Контроль токена прошёл');
	}



	/** Контроль токена не прошёл */
	public function test_token_not_equals_101() {
		$this->assertEquals(
			$this->_test_object->auth($this->token . 1, $this->str_time, $this->add_data), '101', 'Контроль токена не прошёл');
	}



	/** Контроль времени - ОК = + (delta - 10) */
	public function test_time_plus_delta() {
		# Контрольная дата
		$str_time = date('Y-m-d H:i:s', $this->time + ($this->delta - 10));
		# Новый токен
		$this->token = $this->_object_token->calculate($this->token_key, $str_time, $this->add_data);
		$this->assertTrue(
			$this->_test_object->auth($this->token, $str_time, $this->add_data), 'Контроль времени - ОК = + (delta - 10)');
	}



	/** Контроль времени прошёл - ОК = - (delta - 10) */
	public function test_time_minus_delta() {
		# Контрольная дата
		$str_time = date('Y-m-d H:i:s', $this->time - ($this->delta - 10));
		# Новый токен
		$this->token = $this->_object_token->calculate($this->token_key, $str_time, $this->add_data);
		$this->assertTrue(
			$this->_test_object->auth($this->token, $str_time, $this->add_data), 'Контроль времени прошёл - ОК = - (delta - 10)');
	}



	/** Контроль времени не прошёл - Error = - (delta + 10) */
	public function test_time_plus_delta_102() {
		# Контрольная дата
		$str_time = date('Y-m-d H:i:s', $this->time + ($this->delta + 100));
		# Новый токен
		$this->token = $this->_object_token->calculate($this->token_key, $str_time, $this->add_data);
		$this->assertEquals(
			$this->_test_object->auth($this->token, $str_time, $this->add_data), '102', 'Контроль времени не прошёл - Error = - (delta + 10)');
	}



	/** Контроль времени не прошёл - Error = - (delta - 10) */
	public function test_time_minus_delta_102() {
		# Контрольная дата
		$str_time = date('Y-m-d H:i:s', $this->time - ($this->delta + 100));
		# Новый токен
		$this->token = $this->_object_token->calculate($this->token_key, $str_time, $this->add_data);
		$this->assertEquals(
			$this->_test_object->auth($this->token, $str_time, $this->add_data), '102', 'Контроль времени не прошёл - Error = - (delta - 10)');
	}



/**/
}

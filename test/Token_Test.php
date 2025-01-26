<?php

use PHPUnit\Framework\TestCase;
use RusaDrako\api\Token;
use RusaDrako\api\TokenException;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class Token_Test extends TestCase {
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
		$this->_test_object   = new Token($this->token_key);
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
	public function test__ok() {
		$token = $this->get_token($this->time, $this->add_data);
		$this->assertEquals($this->_test_object->generate($this->str_time, $this->add_data), $token, 'Контроль токена не прошёл');
	}

	/** Ошибка передачи пустого ключа */
	public function test__not_key_201() {
		$e = false;

		$this->expectException(TokenException::class);
		$this->expectExceptionCode(TokenException::ERR_201_CODE);
		$this->expectExceptionMessage(TokenException::ERR_201_TEXT);
		$this->_test_object->generate(null, $this->add_data);
	}

	/** Ошибка передачи пустого времени */
	public function test__not_data_203() {
		$token = $this->get_token($this->time, $this->add_data);

		$this->expectException(TokenException::class);
		$this->expectExceptionCode(TokenException::ERR_203_CODE);
		$this->expectExceptionMessage(TokenException::ERR_203_TEXT);
		$this->_test_object->generate($this->str_time, null);
	}

	/** Контроль времени - ОК = + (delta - 10) */
	public function test__time_plus_delta() {
		$time = $this->time + ($this->delta - 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);
		$this->assertEquals(
			$this->_test_object->generate($str_time, $this->add_data), $token, 'Контроль времени - ОК = + (delta - 10)');
	}

	/** Контроль времени - ОК = - (delta - 10) */
	public function test__time_minus_delta() {
		$time = $this->time - ($this->delta - 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);
		$this->assertEquals($this->_test_object->generate($str_time, $this->add_data), $token, 'Контроль времени - ОК = - (delta - 10)');
	}

	/** Контроль времени - Error = - (delta + 10) */
	public function test__time_plus_delta_202() {
		$time = $this->time - ($this->delta + 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);

		$this->expectException(TokenException::class);
		$this->expectExceptionCode(TokenException::ERR_202_CODE);
		$this->expectExceptionMessage(TokenException::ERR_202_TEXT);
		$this->_test_object->generate($str_time, $this->add_data);
	}

	/** Контроль времени - Error = + (delta + 10) */
	public function test__time_minus_delta_202() {
		$time = $this->time + ($this->delta + 10);
		$str_time = date('Y-m-d H:i:s', $time);
		$token = $this->get_token($time, $this->add_data);

		$this->expectException(TokenException::class);
		$this->expectExceptionCode(TokenException::ERR_202_CODE);
		$this->expectExceptionMessage(TokenException::ERR_202_TEXT);
		$this->_test_object->generate($str_time, $this->add_data);
	}

/**/
}

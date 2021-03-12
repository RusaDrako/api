<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');





/** Класс-тестировщик для token
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class token_Test extends TestCase {
	/** */
	private $token_key = '0123456789ABCDEF';
	private $time = 1615546416;
	private $str_time = 0;
	private $add_data = 1;
	/** Тестируемый объект */
	private $_test_object = null;





	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->str_time = date('Y-m-d H:i:s', $this->time);
		$this->_test_object = new RD_Api_Token();
		$this->_test_object->test(true);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Тестирование ОК */
	public function test_ok() {
		$this->assertEquals(
			$this->_test_object->calculate($this->token_key, $this->str_time, $this->add_data), '090435c72f460bfe1f3a74fa5bf7c75a', 'Контроль токена не прошёл');
	}



	/** Ошибка передачи пустого ключа */
	public function test_not_key_201() {
		$this->assertEquals(
			$this->_test_object->calculate(null, $this->str_time, $this->add_data), '201', 'Ошибка передачи пустого ключа');
	}



	/** Ошибка передачи пустого времени */
	public function test_not_time_202() {
		$this->assertEquals(
			$this->_test_object->calculate($this->token_key, null, $this->add_data), '202', 'Ошибка передачи пустого времени');
	}



	/** Ошибка передачи пустого дополнительных данных */
	public function test_not_data_203() {
		$this->assertEquals(
			$this->_test_object->calculate($this->token_key, $this->str_time, null), '203', 'Ошибка передачи пустых дополнительных данных');
	}



/**/
}

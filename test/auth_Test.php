<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');





/** Класс-тестировщик для auth
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class auth_Test extends TestCase {
	/** */
	private $token_key      = 'key0123456789ABCDEF';
	private $token          = '0123456789ABCDEF';
	/** Тестируемый объект */
	private $_test_object   = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->_test_object = new RD_Api_Auth($this->token_key);
		$token_obj = $this->stub_token();
		$this->_test_object->set_token($this->stub_token());
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Генератор заглушки токена */
	public function stub_token() {
		# Создать заглушку для класса SomeClass.
		$stub = $this->createMock(RD_Api_Token::class);
		# Настроить заглушку.
		$stub->method('generate')
			->willReturn('0123456789ABCDEF');
		return $stub;
	}



	/** Генератор реального токена */
	public function real_token($obj_parent) {
		$obj = new RD_Api_Token($this->token_key);
		$obj_parent->set_token($obj);
	}



	/** Генератор токена */
	public function test_get_token() {
		$this->real_token($this->_test_object);
		$result = $this->_test_object->get_token();
		$this->assertIsObject($result);
		$this->assertEquals(\get_class($result), 'RusaDrako\api\token', 'Проверить функции set_token и get_token');
	}



	/** Контроль токена прошёл */
	public function test_ok() {
		$this->assertTrue($this->_test_object->auth($this->token), 'Контроль токена прошёл');
	}



	/** Контроль токена не прошёл */
	public function test_token_not_equals_101() {
		$this->expectException('RusaDrako\api\auth_exception');
		$this->expectExceptionCode(101);
		$this->expectExceptionMessage('AUTH: Ошибка токена');
		$this->_test_object->auth($this->token . 1);
	}



	/** Генератор токена */
	public function test_generate_token() {
		$this->assertEquals($this->_test_object->generate_token(), $this->token, 'Возвращает неправильный токен');
	}



	/** Возврат объекта результата */
	public function test_get_result() {
		$result = $this->_test_object->get_result();
		$this->assertIsObject($result);
		$this->assertEquals(\get_class($result), 'RusaDrako\api\result');
	}



/**/
}

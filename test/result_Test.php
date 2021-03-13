<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');





/** Класс-тестировщик для result
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class result_Test extends TestCase {
	/** Тестируемый объект */
	private $_test_object = null;





	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->_test_object = new RD_Api_Result();
		$this->_test_object->test(true);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Тестирование result */
	public function test_data() {
		$arr = ['test_1' => 'test_desc_1', 'test_2' => 'test_desc_2'];
		$result = $this->_test_object->result($arr);
		$this->assertIsArray($result);
		$this->assertArrayHasKey('ok', $result, 'Не содержит ключа ok');
		$this->assertTrue($result['ok'], 'Значение ok отлично от контрольного');
		$this->assertArrayHasKey('result', $result, 'Не содержит ключа result');
		$this->assertEquals($result['result'], $arr, 'Значение result отлично от контрольного');
		$this->assertArrayNotHasKey('error', $result, 'Не содержит ключа error');
		$this->assertArrayNotHasKey('error_desc', $result, 'Не содержит ключа error_desc');
	}



	/** Тестирование error */
	public function test_error() {
		$result = $this->_test_object->error('1', 'Тест');
		$this->assertIsArray($result);
		$this->assertArrayHasKey('ok', $result, 'Не содержит ключа ok');
		$this->assertFalse($result['ok'], 'Значение ok отлично от контрольного');
		$this->assertArrayHasKey('result', $result, 'Не содержит ключа result');
		$this->assertNull($result['result'], 'Значение result отлично от контрольного');
		$this->assertArrayHasKey('error', $result, 'Не содержит ключа error');
		$this->assertEquals($result['error'], '1', 'Значение error отлично от контрольного');
		$this->assertArrayHasKey('error_desc', $result, 'Не содержит ключа error_desc');
		$this->assertEquals($result['error_desc'], 'Тест', 'Значение error_desc отлично от контрольного');
	}



/**/
}

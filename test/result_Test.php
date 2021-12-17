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
		$this->assertEquals($result, '{"ok":true,"result":{"test_1":"test_desc_1","test_2":"test_desc_2"}}');
	}



	/** Тестирование error */
	public function test_error() {
		$result = $this->_test_object->error(1, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"error":"1","error_desc":"\u0422\u0435\u0441\u0442"}');
	}



	/** Тестирование error */
	public function test_error_0() {
		$result = $this->_test_object->error(0, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"error":"-999999","error_desc":"\u0422\u0435\u0441\u0442"}');
	}



	/** Тестирование формирование json из рекурсивного объекта */
	public function test_recursion_obj() {
		$o = new StdClass;
		$o->test = 123;
		$o->arr = [];
		$o->arr['obj_rec'] = $o;
		$o->arr['data'] = 456;
		$result = $this->_test_object->result($o);
		$this->assertEquals($result, '{"ok":true,"result":{"test":123,"arr":{"obj_rec":null,"data":456}}}');
	}



/**/
}

<?php

use PHPUnit\Framework\TestCase;
use RusaDrako\api\Result;

require_once(__DIR__ . '/../src/autoload.php');

/**
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class Result_Test extends TestCase {
	/** Тестируемый объект */
	private $_test_object = null;

	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->_test_object = new Result();
//		$this->_test_object->test(true);
	}

	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}

	/** Тестирование result */
	public function test__result() {
		$arr = ['test_1' => 'test_desc_1', 'test_2' => 'test_desc_2'];
		$result = $this->_test_object->result($arr);
		$this->assertEquals($result, '{"ok":true,"result":{"test_1":"test_desc_1","test_2":"test_desc_2"}}');
	}

	/** Тестирование result (формирование json из рекурсивного объекта) */
	public function test__result__recursion_obj() {
		$o = new StdClass;
		$o->test = 123;
		$o->arr = [];
		$o->arr['obj_rec'] = $o;
		$o->arr['data'] = 456;
		$result = $this->_test_object->result($o);
		$this->assertEquals($result, '{"ok":true,"result":{"test":123,"arr":{"obj_rec":null,"data":456}}}');
	}

	/** Тестирование error */
	public function test__error() {
		$result = $this->_test_object->error(1, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"1","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__0() {
		$result = $this->_test_object->error(0, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"-999999","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__null() {
		$result = $this->_test_object->error(null, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"-999999","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__empty_str() {
		$result = $this->_test_object->error('', 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"-999999","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__false() {
		$result = $this->_test_object->error(false, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"-999999","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__true() {
		$result = $this->_test_object->error(true, 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"1","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

	/** Тестирование error */
	public function test__error__str() {
		$result = $this->_test_object->error('Ups!', 'Тест');
		$this->assertEquals($result, '{"ok":false,"result":null,"errCode":"Ups!","errMessage":"\u0422\u0435\u0441\u0442"}');
	}

/**/
}

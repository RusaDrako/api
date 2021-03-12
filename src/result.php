<?php

namespace RusaDrako\api;





/**
 * Вывод данных для API
 * @version 1.0.0
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class result {

	use _trait__error;



	#
	private $ok = true;
	#
	private $result = null;
	#
	private $error_num = null;
	#
	private $error_descript = null;
	# Объект класса
	private static $_object = null;










	/** */
	public function __construct() {}





	/** */
    public function __destruct() {}





	/** Вызов объекта
	* @return object Объект класса
	*/
	public static function call(...$args) {
		if (null === self::$_object) {
			self::$_object = new static(...$args);
		}
		return self::$_object;
	}





	/** Ошибка времени */
	public function error($num, $descript = null) {
		$this->error_num = $num;
		$this->error_description = $descript;
		return $this->_result();
	}





	/** */
	public function data($result) {
		$this->result = $result;
		return $this->_result();
	}





	/** Выводит результат запроса */
	private function _result() {
		if ($this->error_num) {
			$result = [
				'ok' => false,
				'result' => null,
				'error' => $this->error_num,
				'error_desc' => $this->error_description,
			];
		} else {
			$result = [
				'ok' => true,
				'result' => $this->result,
			];
		}
		if ($this->test) {
			return $result;
		} else {
			echo \json_encode($result);
			exit;
		}
	}





	/**/
	private function set_error($num, $description) {}





/**/
}

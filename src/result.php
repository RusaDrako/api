<?php

namespace RusaDrako\api;

/**
 * Вывод данных для API
 * @version 1.0.0
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class result {

	use _trait__test;



	# Статус запроса
	private $ok = true;
	# Результат запроса
	private $result = null;
	# Номер ошибки
	private $error_num = null;
	# Описание ошибки
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





	/** Формирует результат ошибки
	 * @param integer $num Номер ошибки
	 * @param string $description Описание ошибки
 	*/
	public function error($num, $description) {
		$this->error_num = $num;
		$this->error_description = $description;
		return $this->_generate();
	}





	/** Формирует результат ответа */
	public function result($result) {
		$this->result = $result;
		return $this->_generate();
	}





	/** Выводит результат запроса */
	private function _generate() {
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
}

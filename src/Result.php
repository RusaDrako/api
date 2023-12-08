<?php

namespace RusaDrako\api;

/**
 * Вывод данных для API
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class Result {

	use _trait__test;

	/** @var bool Статус запроса */
	private $ok = true;
	/** @var null Результат запроса */
	private $result = null;
	/** @var null Номер ошибки */
	private $error_num = null;
	/** @var null Описание ошибки */
	private $error_descript = null;
	/** @var null Объект класса */
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
		# Если код не передан, то ставим код по умолчанию
		$num = (string) ($num ? $num : -999999);
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
			$_result = [
				'ok' => false,
				'result' => null,
				'error' => $this->error_num,
				'error_desc' => $this->error_description,
			];
		} else {
			$_result = [
				'ok' => true,
				'result' => $this->result,
			];
		}
		# JSON_PARTIAL_OUTPUT_ON_ERROR - Обработка рекурсивных объектов
		$result = \json_encode($_result, JSON_PARTIAL_OUTPUT_ON_ERROR);
		if ($this->test) {
			return $result;
		} else {
			echo $result;
			exit;
		}
	}

/**/
}

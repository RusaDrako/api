<?php

namespace RusaDrako\api;

/**
 *
 */
trait _trait__error {

	use _trait__test;

	/** Формируем результат ошибки
	 * @param integer $num Номер ошибки
	 * @param string $description Описание ошибки
	 */
	private function set_error($num, $description) {
		if ($this->test) {
			return "error {$num}";
		} else {
			(new result())->error($num, $description);
			exit;
		}
	}



/**/
}

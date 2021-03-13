<?php

namespace RusaDrako\api;

/**
 *
 */
trait _trait__test {

	# Маркер тестового режима
	private $test            = false;



	/** Устанавливает маркер тестового режима
	 * @param bool $bool Статус тестового режима
	 */
	public function test($bool) {
		$this->test = (bool) $bool;
	}



/**/
}

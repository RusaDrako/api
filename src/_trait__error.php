<?php

namespace RusaDrako\api;

/**
 *
 */
trait _trait__error {

	#
	private $test            = false;



	public function test($bool) {
		$this->test = (bool) $bool;
	}



	/**/
	private function set_error($num, $description) {
		if ($this->test) {
			return $num;
		} else {
			(new result())->error($num, $description);
			exit;
		}
	}



/**/
}

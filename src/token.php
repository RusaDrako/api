<?php

namespace RusaDrako\api;





/**
 * 
 * @version 1.0.0
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class token {

	use _trait__error;



	/** */
	public function __construct() {
		$this->result = new result();
	}





	/** */
    public function __destruct() {}





	/** Ошибка времени
	 * $token_in $token_time $id
	 */
	public function calculate(...$args) {
//print_r($args);
		# Если не передали токен
		if (!$args[0]) {
			# Ошибка переданных данных
			return $this->set_error('201', 'AUTH: Ключ токена не найден');
		}
		# Если не передали time
		if (!$args[1]) {
			return $this->set_error('202', 'AUTH: Временная точка не найдена');
		}
		# Если не передали ID
		if (!$args[2]) {
			# Ошибка переданных данных
			return $this->set_error('203', 'AUTH: Контрольное значение не передано');
		}
		# Время для токена
		$token_dt = \strtotime($args[1]);
		# Дата формата ГГГГ:ММ:ДД ЧЧ:М0
		$_token_time = \date('Y-m-d H:i', $token_dt);
		# Вычисляем токен
		$token_control = \md5($this->token_guid . $args[2] . $_token_time);
		# Ставим маркер подключения
		return $token_control;
	}





	/* * * /
	public function control($result) {
		$this->result = $result;
		$this->result();
	}





	/** Выводит результат запроса * /
	public function result() {
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
				'result' => $this->data,
			];
		}
		echo \json_encode($result);
//		exit;
	}





/**/
}

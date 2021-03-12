<?php

namespace RusaDrako\api;





/**
 * Аутентификация API
 * @version 1.0.0
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class auth {

	use _trait__error;



	private $error            = null;
	private $token_key        = null;
	private $delta            = 0;
	# Объект класса
	private static $_object   = null;










	/** */
	public function __construct($token_key, $delta = 600) {
		$this->token_key = $token_key;
		$this->delta = $delta;
		$this->result = new result();
		$this->obj_token = new token();
	}





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





	/** */
	public function set_token(token $token_obj) {
		$this->obj_token = $token_obj;
	}





	/** Ошибка времени */
	public function error() {
		# Сообщение об ошибке
		return $this->error;
	}





	/** Аутентификация
	 * @param string $token_in Токен подключения
	 * @param string $token_time Время формирования токена
	 * @param string $id ID элемента (используем при формировании токена)
	 */
	public function auth($token_in, $token_time, $id) {
		if ($this->delta) {
			# Запоминаем дату (в числовом виде)
			$_dt_time = time();
			# Вычисляем разницу во времени
			$delta_time = strtotime($token_time) - $_dt_time;
			# Модуль числа больше 600 - 10 минут
			if ($this->delta < abs($delta_time)) {
				return $this->set_error('102', 'AUTH: Ограничение токена по времени');
			}
		}
		$this->obj_token->test($this->test);
		$token_control = $this->obj_token->calculate($this->token_key, $token_time, $id);
		# Если токены не совпадают
		if ($token_control != $token_in) {
			# Ошибка совпадения токенов
			return $this->set_error('101', 'AUTH: Ошибка токена');
		}/**/
		# Ставим маркер подключения
		return true;
	}



	/** */
	public function get_token(...$args) {
		return $this->obj_token->calculate($this->token_key, ...$args);
	}




/**/
}

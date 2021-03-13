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



	private $obj_result       = null;
	private $obj_token        = null;
	# Объект класса
	private static $_object   = null;










	/** */
	public function __construct($token_key) {
		$this->obj_result = new result();
		$this->obj_token = new token($token_key);
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





	/** Аутентификация по токену
	 * @param string $token_in Токен подключения
	 * @param array ...$args Массив данных для формирования токена
	 */
	public function auth($token_in, ...$args) {
		$this->obj_token->test($this->test);
		# Генерируем токен
		$token_control = $this->generate_token(...$args);
		# Если токены не совпадают
		if ($token_control != $token_in) {
			# Ошибка совпадения токенов
			return $this->set_error('101', 'AUTH: Ошибка токена');
		}/**/
		# Ставим маркер подключения
		return true;
	}



	/** Генерирует токен
	 * @param array ...$args Массив данных для формирования токена
	 */
	public function generate_token(...$args) {
		return $this->obj_token->generate(...$args);
	}





	/** Прописывает объект токена
	 * @param object $token_obj Объект токена
	 */
	public function set_token(_int_token $token_obj) {
		$this->obj_token = $token_obj;
	}





	/** Возвращает объект токена */
	public function get_token() {
		return $this->obj_token;
	}





	/** Возвращает объект результата */
	public function get_result() {
		return $this->obj_result;
	}





/**/
}

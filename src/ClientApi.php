<?php

namespace RusaDrako\api;

/**
 * Клиент API
 * @created 2020-06-01
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class ClientApi {

	private $obj_result;
	private $obj_token;

	/** */
	public function __construct($token_key) {
		$this->obj_result = new result();
		$this->obj_token = new token($token_key);
	}

	/** */
	public function __destruct() {}

	/** Аутентификация по токену
	 * @param string $token_in Токен подключения
	 * @param array ...$args Массив данных для формирования токена
	 */
	public function auth($token_in, ...$args) {
		# Генерируем токен
		$token_control = $this->generate_token(...$args);
		# Если токены не совпадают
		if ($token_control != $token_in) {
			throw new ExceptionClientApi("ClientApi: Ошибка токена", 101);
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

/**
 * Класс ошибки
 */
class ExceptionClientApi extends \Exception {}

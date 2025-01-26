<?php

namespace RusaDrako\api;

/**
 * Ауиентификация API
 */
class Auth {

	private $obj_result;
	private $obj_token;

	/** */
	public function __construct($token_key, $result_class='\\RusaDrako\\api\\result') {
		$this->obj_result = new $result_class();
		$this->obj_token = new Token($token_key);
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
			throw new ClientApiException(ClientApiException::ERR_101_TEXT, ClientApiException::ERR_101_CODE);
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
	public function set_token(_inf_token $token_obj) {
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

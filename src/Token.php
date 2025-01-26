<?php

namespace RusaDrako\api;

/**
 * Формирование токена
 */
class Token implements _inf_token {

	/** Ключ токена */
	protected $key = null;
	/** +/- 10 минут на действие токена */
	protected $delta_time = 600;

	/** Генератор токена
	 * @param string $key Уникальный ключ токена
	 */
	public function __construct($key) {
		$this->key = $key;
		$this->result = new Result();
	}

	/** */
	public function __destruct() {}

	/** Генератор токена
	 * @param string $args[0] Время формирования токена
	 * @param string $args[1] Дополнительные строковые данные (используем при формировании токена)
	 */
	public function generate(...$args) {
		# Если не передали time
		if (!$args[0]) {
			throw new TokenException(TokenException::ERR_201_TEXT, TokenException::ERR_201_CODE);
		}
		# Вычисляем разницу во времени
		$delta_time = strtotime($args[0]) - time();
		# Проверка отклонения времени
		if ($this->delta_time < abs($delta_time)) {
			throw new TokenException(TokenException::ERR_202_TEXT, TokenException::ERR_202_CODE);
		}
		# Если не передали ID
		if (!$args[1]) {
			throw new TokenException(TokenException::ERR_203_TEXT, TokenException::ERR_203_CODE);
		}
		$token_control = $this->calculate(...$args);
		# Ставим маркер подключения
		return $token_control;
	}

	/** Расчёт токена */
	protected function calculate(...$args) {
		# Время для токена
		$token_dt = \strtotime($args[0]);
		# Дата формата ГГГГ:ММ:ДД ЧЧ:МM
		$_token_time = \date('Y-m-d H:i', $token_dt);
		# Генерируем токен
		$token_control = \md5($this->key . $args[1] . $_token_time);
		# Ставим маркер подключения
		return $token_control;
	}

/**/
}

<?php

namespace RusaDrako\api;

/**
 * Интерфейс объекта token
 */
interface _int_token {

	/** Конструктор класса
	 * @param string $key Уникальный ключ токена
	 */
	public function __construct($key);

	/** Генератор токена
	 * @param array ...$args Произвольный массив данных для формирования токена
	 */
	public function generate(...$args);

/**/
}

<?php

namespace RusaDrako\api;

/**
 * Интерфейс объекта token
 */
interface _inf_token {

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

/**
 * Класс ошибки
 */
class ExceptionToken extends \Exception {}

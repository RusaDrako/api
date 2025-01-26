<?php

namespace RusaDrako\api;

/**
* Класс ошибки
*/
class TokenException extends \Exception {
	const ERR_201_CODE = "201";
	const ERR_201_TEXT = "ClientApi: Временная точка не найдена";
	const ERR_202_CODE = "203";
	const ERR_202_TEXT = "ClientApi: Ограничение токена по времени";
	const ERR_203_CODE = "203";
	const ERR_203_TEXT = "ClientApi: Контрольное значение не передано";
}
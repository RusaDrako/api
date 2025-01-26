<?php

namespace RusaDrako\api;

/**
* Класс ошибки
*/
class ClientApiException extends \Exception {
	const ERR_101_CODE = "101";
	const ERR_101_TEXT = "ClientApi: Ошибка токена";
}
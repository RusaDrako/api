# RusaDrako\\api

Набор классов для организации API


## Подключение

Для подключения библиотеки к проекту подключите файл `src/autoload.php`

```php
	# Уникальный ключ соединения
	$key = '0123456789ABCDEF';
	# Входящий токен
	$token = $_POST['token'];
	# Массив данных для проверки токена используемый объектом `RD_Api_Token`
	$token_data = [
		$_POST['date'],
		$_POST['add_data'],
		...
	];

	# Активация объекта
	RD_Api_Auth::call($key);
	# Проверка аутентификации
	$result = RD_Api_Auth::call()->auth($token, ...$token_data);
```


## Первый вызов объекта

```php
	$api = new RD_Api_Auth($key);
```
или
```php
	RD_Api_Auth::call($key);
```

- **$key** - уникальный ключ соединения


## Проверка токена

```php
	$auth = $api->auth($token, ...$token_data);
```

или

```php
	$auth = RD_Api_Auth::call()->auth($token, ...$token_data);
```

- **$token** - входящий токен
- **...$token_data** - массив данных для проверки токена используемый объектом `RD_Api_Token`

Метод возвращает `true` или прерывает выполнение скрипта и выводит json-сообщение об ошибке.


## Генерация токена

```php
	$token = $api->generate_token(...$token_data);
```

или

```php
	$token = RD_Api_Auth::call()->generate_token(...$token_data);
```

- **...$token_data** - массив данных для проверки токена используемый объектом `RD_Api_Token` (`RusaDrako\api\token`)

Метод возвращает `Токен` или прерывает выполнение скрипта и выводит json-сообщение об ошибке.


## Задать новый объект генерации токена

```php
	$api->set_token($obj_token);
```

или

```php
	RD_Api_Auth::call()->set_token($obj_token);
```

- **$obj_token** - объект генерации токена. Объект должен использовать интерфейс `RD_Api_Int_Token` (`RusaDrako\api\_int_token`)

Задаёт новый объект генерации токена.


## Получить объект генерации токена

```php
	$obj_token = $api->get_token();
```

или

```php
	$obj_token = RD_Api_Auth::call()->get_token();
```

Возвращает объект генерации токена.


## Получить объект вывода результата

```php
	$result = $api->get_result();
```

или

```php
	$result = RD_Api_Auth::call()->get_result();
```

Возвращает объект вывода результата.


## Результат

Результат с данными

```json
	{"ok":true,"result":"<Любые данные результата>"}
```

Результат с ошибкой

```json
	{"ok":false,"result":null,"error":"<номер ошибки>","error_desc":"<Описание ошибки>"}
```

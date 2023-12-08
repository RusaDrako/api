# RusaDrako\\api

Набор классов для организации API


## Подключение

Для подключения библиотеки к проекту подключите файл `src/autoload.php`

```php
use RusaDrako\api\Auth;
use RusaDrako\api\ExceptionAuth;

require_once('src/autoload.php');

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
Auth::call($key);
# Проверка аутентификации
try {
    Auth::call()->auth($token, ...$token_data);
} catch (ExceptionAuth $e) {
    $result_obj = Auth::call()->get_result()
    $result_obj->error($e->getCode, $e->getMessage());
}
```


## Первый вызов объекта
```php
use RusaDrako\api\Auth;
$api = new Auth($key);
```
или
```php
use RusaDrako\api\Auth;
Auth::call($key);
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
Возвращает `Токен` или прерывает выполнение скрипта и выводит json-сообщение об ошибке.
```php
$token = $api->generate_token(...$token_data);
```
или
```php
$token = RD_Api_Auth::call()->generate_token(...$token_data);
```
- **...$token_data** - массив данных для проверки токена используемый объектом `RD_Api_Token` (`RusaDrako\api\token`)


## Задать новый объект генерации токена
Задаёт новый объект генерации токена.
```php
$api->set_token($obj_token);
```
или
```php
	RD_Api_Auth::call()->set_token($obj_token);
```
- **$obj_token** - объект генерации токена. Объект должен использовать интерфейс `RD_Api_Int_Token` (`RusaDrako\api\_int_token`)


## Получить объект генерации токена
Возвращает объект генерации токена.
```php
$obj_token = $api->get_token();
```
или
```php
$obj_token = RD_Api_Auth::call()->get_token();
```


## Получить объект вывода результата
Возвращает объект вывода результата.
```php
$result_obj = $api->get_result();
```
или
```php
$result_obj = RD_Api_Auth::call()->get_result();
```


## Результат
Пример результат с данными:
```php
$result_obj->result("<Любые данные результата>");
```
```json
{"ok":true,"result":"<Любые данные результата>"}
```

Пример результата с ошибкой:
```php
$result_obj->error("<Код ошибки>", "<Описание ошибки>");
```
```json
{"ok":false,"result":null,"error":"<Код ошибки>","error_desc":"<Описание ошибки>"}
```

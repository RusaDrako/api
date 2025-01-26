# RusaDrako\\api

[![Version](http://poser.pugx.org/rusadrako/api/version)](https://packagist.org/packages/rusadrako/api)
[![Total Downloads](http://poser.pugx.org/rusadrako/api/downloads)](https://packagist.org/packages/rusadrako/api/stats)
[![License](http://poser.pugx.org/rusadrako/api/license)](./LICENSE)

Набор классов для организации API


## Установка (composer)
```sh
composer require 'rusadrako/api'
```


## Установка (manual)
- Скачать и распоковать библиотеку.
- Добавить в код инструкцию:
```php
require_once('/api/src/autoload.php')
```


## Аутентификация внешнего подключения
```php
use RusaDrako\api\ClientApi;
use RusaDrako\api\ExceptionClientApi;
use RusaDrako\api\ExceptionToken;

# Уникальный ключ соединения
$key = '0123456789ABCDEF';
# Активация объекта
$apiClient = new ClientApi($key);

# Входящий токен
$token = $_POST['token'];
# Входящий массив данных для проверки токена
$token_data = [
    $_POST['date'],
    $_POST['add_data'],
    ...
];

try {
    # Проверка аутентификации
    $apiClient->auth($token, ...$token_data);
} catch (ExceptionClientApi $e) {
    # Возвращаем ошибку аутентификации
    $apiClient->get_result()->error($e->getCode, $e->getMessage());
} catch (ExceptionToken $e) {
    # Возвращаем ошибку генерации токена
    $apiClient->get_result()->error($e->getCode, $e->getMessage());
}
/* Обработка данных */
# Возвращаем результата
$apiClient->get_result()->result('Ок');
```


## Класс ClientApi
Базовый клас для организации API
```php
use RusaDrako\api\ClientApi;

# Уникальный ключ соединения
$key = '0123456789ABCDEF';

$apiClient = new ClientApi($key);
```


#### Метод auth()
Проверяет подлинность токена
```php
/** @var ClientApi $apiClient */
$auth = $apiClient->auth($token, ...$token_data);
```
- **$token** - входящий токен
- **...$token_data** - массив данных для проверки токена используемый объектом `RusaDrako\api\Token`

Метод возвращает `true` или прерывает выполнение кода и выводит json-сообщение об ошибке.


#### Метод generate_token()
Генерирует токен. Возвращает `Токен` или прерывает выполнение скрипта и выводит json-сообщение об ошибке.
```php
/** @var ClientApi $apiClient */
$token = $apiClient->generate_token(...$token_data);
```
- **...$token_data** - массив данных для проверки токена используемый объектом `RusaDrako\api\Token`


#### Метод set_token()
Задаёт новый объект генерации токена.
```php
/** @var ClientApi $apiClient */
$apiClient->set_token($obj_token);
```
- **$obj_token** - объект генерации токена реализующий интерфейс `RusaDrako\api\_inf_token`

#### Метод get_token();
Возвращает объект генерации токена.
```php
/** @var ClientApi $apiClient */
$obj_token = $apiClient->get_token();
```

#### Метод set_result()
Задаёт новый объект вывода результата.
```php
/** @var ClientApi $apiClient */
$apiClient->set_result($obj_result);
```
- **$obj_result** - объект вывода результата наследующий класс `RusaDrako\api\Result`

#### Метод get_result()
Возвращает объект вывода результата.
```php
/** @var ClientApi $apiClient */
$result_obj = $apiClient->get_result();
```


## Класс Token
Класс формирования токена API. Можно назначить свой токен
```php
use RusaDrako\api\Token;
$result_obj = new Token($key);
```
- **$key** - секретный ключ.


#### Метод generate()
Генерирует токен
```php
$datetime = '2023-01-01 15:00:00';
$requiredParameter = '<Любые_данные>';
$notRequiredParameter = '<Любые_данные>';
...
/** @var Token $token_obj */
$token = $token_obj->generate($datetime, $requiredParameter, $notRequiredParameter, ...);
```
- **$datetime** - контрольное время, относительно которого расчитывается токен. Время токена не должно отличаться от текущего время больше чем на +/-10 минут.
- **$requiredParameter** - обязательные параметр (отсутствие вызывает ошибку). Обязательный параметр не должен быть пустым.
- **$notRequiredParameter** - необязательные параметры (любое количество) (отсутствие не вызывает ошибку).


## Класс Result
Класс формирования ответа API
```php
use RusaDrako\api\Result;
$result_obj = new Result();
```

#### Метод result()
Формирует и выводит ответ для API
```php
/** @var Result $result_obj */
$result_obj->result($answerData);
```
- **$answerData** - данные для ответа

#### Метод error()
Формирует и выводит ответ для API с ошибкой
```php
/** @var Result $result_obj */
$result_obj->error($errCode, $errMessage);
```
- **$errCode** - код ошибки
- **$errMessage** - сообщение об ошибке


## Варианты формирования ответов

#### Ответ с данными
```php
/** @var ClientApi $apiClient */
$apiClient->get_result()->result("<Любые данные результата>");
```
```json
{"ok":true,"result":"<Любые данные результата>"}
```

#### Ответ с массивом данных
```php
/** @var ClientApi $apiClient */
$apiClient->get_result()->result(['key_1'=>'Текст 1','key_2'=>'Текст 2']);
```
```json
{"ok":true,"result":{"key_1":"Текст 1","key_2":"Текст 2"}}
```

#### Ответ с ошибкой
```php
/** @var ClientApi $apiClient */
$apiClient->get_result()->error("<Код ошибки>", "<Описание ошибки>");
```
```json
{"ok":false,"result":null,"errCode":"<Код ошибки>","errMessage":"<Описание ошибки>"}
```


## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.
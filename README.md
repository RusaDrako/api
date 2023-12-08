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
    $apiClient->ClientApi($token, ...$token_data);
} catch (ExceptionClientApi $e) {
    # Возвращаем ошибку аутентификации
    $apiClient->get_result()->error($e->getCode, $e->getMessage());
} catch (ExceptionToken $e) {
    # Возвращаем ошибку генерации токена
    $apiClient->get_result()->error($e->getCode, $e->getMessage());
}
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
$auth = $apiClient->auth($token, ...$token_data);
```
- **$token** - входящий токен
- **...$token_data** - массив данных для проверки токена используемый объектом `RusaDrako\api\Token`

Метод возвращает `true` или прерывает выполнение кода и выводит json-сообщение об ошибке.


## Метод generate_token()
Генерирует токен. Возвращает `Токен` или прерывает выполнение скрипта и выводит json-сообщение об ошибке.
```php
$token = $apiClient->generate_token(...$token_data);
```
- **...$token_data** - массив данных для проверки токена используемый объектом `RusaDrako\api\Token`


#### Метод set_token()
Задаёт новый объект генерации токена.
```php
$apiClient->set_token($obj_token);
```
- **$obj_token** - объект генерации токена. Объект должен использовать интерфейс `RusaDrako\api\Token`


#### Метод get_token();
Возвращает объект генерации токена.
```php
$obj_token = $apiClient->get_token();
```


#### Метод get_result()
Возвращает объект вывода результата.
```php
$result_obj = $apiClient->get_result();
```


## Варианты формирования ответов

#### Ответ с данными
```php
$apiClient->get_result()->result("<Любые данные результата>");
```
```json
{"ok":true,"result":"<Любые данные результата>"}
```

#### Ответ с массивом данных
```php
$apiClient->get_result()->result(['key_1'=>'Текст 1','key_2'=>'Текст 2']);
```
```json
{"ok":true,"result":{"key_1":"Текст 1","key_2":"Текст 2"}}
```

#### Ответ с ошибкой
```php
$apiClient->get_result()->error("<Код ошибки>", "<Описание ошибки>");
```
```json
{"ok":false,"result":null,"errCode":"<Код ошибки>","errMessage":"<Описание ошибки>"}
```

## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.
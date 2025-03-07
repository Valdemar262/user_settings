# laravel-starter.

## Introduction:

Laravel starter provides simple containerized infrastructure of `Laravel, Nginx, Mysql and Xdebug`.

## Getting started:

## local deployment:

### 1) Start containers through:
#### `docker compose --env-file app/.env up -d`.
### 2) Into app container run next command:
#### `composer install`.

## Как это работает:

### 1) Пользователь отправляет POST-запрос на `/settings/update` с key, value, method.
### SettingService сохраняет временное значение и вызывает верификацию.
### 2) GET `/verification/methods` возвращает доступные методы (зависит от данных пользователя).
### 3) POST `/verification/request` отправляет код через выбранный метод.
### 4) POST `/verification/verify` проверяет код и применяет изменение настройки.
### 5) SendVerificationCodeJob выполняется асинхронно для отправки кода.

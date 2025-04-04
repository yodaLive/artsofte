# API для витрины машин и расчета кредита

## Стек

![PHP] **(версия 8.4)**

![Symfony] **(версия 7.2)
**

![Postgres] **(версия 15.0)**

![Docker]

## 💻 Установка

1. Клонируй репозиторий

```sh
git clone https://github.com/github_username/repo_name.git
```

2. Для поднятия окружения введи

```sh
make start
```

3. Для установки компонентов введи

```sh
make composer-install
```

4. Для создания БД введи

```sh
make drop-and-create
```

5. Для запуска миграций введи

```sh
make migrate
```

## 📎 API

## Теперь можете пользоватся:)

### http://localhost/api/doc -после разворачивания приложения

6. Для установки тестовых данных введи

```sh
make fixture
```

## Тесты

Для создания тестовой БД введи

```sh
make test-drop-and-create
```

Для запуска миграций для тестовой БД введи

```sh
make test-migrate
```

Для установки тестовых данных для тестовой БД введи

```sh
make test-fixture
```

Для запуска тестов введи

```sh
make test
```
### Установка в Docker

1. Подготовить файл *.env*

    ```sh
    make env-prepare
    ```

2. Указать параметры подключения к БД в файле *.env*

    ```dotenv
    DB_CONNECTION=pgsql
    DB_HOST=database
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres
    DB_PASSWORD=secret
    ```

3. Собрать и запустить приложение

    ```sh
    make compose-setup # собрать проект
    make compose-start # запустить сервер http://127.0.0.1:8000/
    make compose-bash  # запустить сессию bash в docker-контейнере
    make test          # запустить тесты в docker-контейнере
    make db-prepare    # накатить миграции в docker-контейнере
    ```



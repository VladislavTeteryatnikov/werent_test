<?php
    //Установил верное время. Можно было и в docker, но решил тут
    date_default_timezone_set('Europe/Moscow');

    //Ключ для Redis
    $lockKey = 'lock';
    $lockTimeout = 10;

    //Максимально уникальный ID процесса
    $runId = uniqid('redis_', true);

    try {
        //Устанавливаем соединение с redis
        $redis = new Redis();
        $redis->connect('redis');

        //Устанавливаем ключ, если его не существует со временем жизни 10 сек
        $setKeyRedis = $redis->set($lockKey, $runId, ['nx', 'ex' => $lockTimeout]);
        //Выходим из скрипта, если такой ключ уже установлен
        if (!$setKeyRedis) {
            exit(0);
        }

        //Выполняем скрипт, если удалось установить ключ
        echo "[" . date('Y-m-d H:i:s') . "] [ID = $runId] НАЧАЛО: Скрипт запущен\n";
        sleep(1);
        echo "[" . date('Y-m-d H:i:s') . "] [ID = $runId] ЗАВЕРШЕНИЕ: Скрипт завершил работу\n";

        //Делаем проверку и удаляем ключ за одну операцию с помощью  Lua-скрипт
        $lua = "
            if redis.call('GET', KEYS[1]) == ARGV[1] then
                return redis.call('DEL', KEYS[1])
            else
                return 0
            end
        ";
        $deleted = $redis->eval($lua, [$lockKey, $runId], 1);

        //Проверка если что-то пошло не так. И по какой-то причине другой процесс перезаписал блокировку
        if (!$deleted) {
            echo "[ID = $runId] ПРЕДУПРЕЖДЕНИЕ: Блокировка уже была изменена или снята\n";
        }

        exit(0);
    } catch (Exception $e) {
        //Если возникла ошибка
        echo "[ID = $runId] ОШИБКА: " . $e->getMessage();
        exit(1);
    }






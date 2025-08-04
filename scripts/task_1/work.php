<?php
    date_default_timezone_set('Europe/Moscow');

    $lockKey = 'lock';
    $lockTimeout = 10;
    $runId = uniqid('redis_', true);

    try {
        //Устанавливаем соединение с redis
        $redis = new Redis();
        $redis->connect('redis');

        //Пробуем установить ключ в redis
        $setKeyRedis = $redis->set($lockKey, $runId, ['nx', 'ex' => $lockTimeout]);
        if (!$setKeyRedis) {
            exit(0);
        }

        //Выполняем скрипт
        echo "[" . date('Y-m-d H:i:s') . "] [ID = $runId] НАЧАЛО: Скрипт запущен\n";
        sleep(1);
        echo "[" . date('Y-m-d H:i:s') . "] [ID = $runId] ЗАВЕРШЕНИЕ: Скрипт завершил работу\n";

        //Делаем проверку и удаляем ключ за одну операцию
        $lua = "
            if redis.call('GET', KEYS[1]) == ARGV[1] then
                return redis.call('DEL', KEYS[1])
            else
                return 0
            end
        ";
        $deleted = $redis->eval($lua, [$lockKey, $runId], 1);
        //Проверка если что-то пошло не так
        if (!$deleted) {
            echo "[ID = $runId] ПРЕДУПРЕЖДЕНИЕ: Блокировка уже была изменена или снята\n";
        }

        exit(0);
    } catch (Exception $e) {
        echo "[ID = $runId] ОШИБКА: " . $e->getMessage();
        exit(1);
    }






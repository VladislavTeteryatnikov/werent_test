const { spawn } = require('child_process');

const totalRuns = 100;
let completed = 0;

console.log(`Запускаем PHP-скрипт ${totalRuns} раз одновременно\n`);

for (let i = 0; i < totalRuns; i++) {
    //Запускаем скрипт php из docker контейнера
    const child = spawn('docker', ['exec', '-i', 'php', 'php', 'work.php']);

    //Получаем сообщения из php скрипта
    child.stdout.on('data', (data) => {
        process.stdout.write(data.toString());
    });

    //Получаем ошибки
    child.stderr.on('data', (data) => {
        process.stderr.write(data.toString());
    });

    //Когда процесс завершён
    child.on('close', (code) => {
        completed++;
        if (completed === totalRuns) {
            console.log(`Все ${totalRuns} запусков завершены`);
        }
    });
}
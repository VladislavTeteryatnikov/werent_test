# Образ
FROM node:18-alpine

# Устанавливаем docker-cli
RUN apk add --no-cache docker-cli

# Рабочая директория
WORKDIR /app

# Не даем падать контейнеру
CMD ["tail", "-f", "/dev/null"]


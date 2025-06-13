FROM php:8.1-cli

# Crear carpeta de trabajo
WORKDIR /app

# Copiar todo el proyecto
COPY . /app

# Exponer puerto alternativo (por ejemplo 8080)
EXPOSE 8080

# Comando para iniciar servidor embebido apuntando a index.php
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]

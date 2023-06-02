## Montar en desarrollo

Para montar el sitio para desarrollo, debes realizar los siguientes pasos:

```
# Construye el repositorio
docker-compose build

# Sube los contendores
docker-compose up -d

# Abra línea de comandos para contenedor montado
docker exec -it gamehub_web_1 /bin/bash

# En la línea de comando abierta, ejecuta esto.
composer install

```
Finalmente, agregar el `.env`.


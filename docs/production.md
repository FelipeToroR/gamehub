## Montar en producción

Para montar el sitio en producción, debes realizar los siguientes pasos:

### Clonar repositorio

Clona el repositorio desde GitHub.
```
git clone https://github.com/fdiazb/gamehub.git
```

### Agregar archivo de variables de entorno para proyecto

Arma un archivo .env con configuración para producción.

```
docker-compose build
```

Levanta los servicios de Docker.

```
docker-compose up -d
```

### Revisar salida de contenedor para parse a proxy inverso en Apache

Debes revisar que el puerto de salida del contenedor, coincida con puerto público 80.

### Instalar composer

Ejecutar comando para instalar Composer.

```
docker exec -it gamehub_web_1 /bin/bash
composer install
```

#### Otorgar permisos a directorios 

Asigna permisos para directorios. Mientras que los contenedores estén arriba.

```
chgrp -R www-data storage bootstrap/cache uploads
chmod -R ug+rwx storage bootstrap/cache uploads
```

# Instalación limpia
Si ud. va a renovar la instalación, por favor, siga los siguientes pasos:

- Recuerda importar de instalación anterior
- .env
- copia de bd
- copia de /uploads
    - cp -r gh_old/uploads/ gamehub/uploads
# Proyecto Laravel 13

Aplicación web con autenticación de usuarios construida con Laravel 13, con un entorno de desarrollo completamente dockerizado: un solo comando levanta el servidor web, PHP y la base de datos.

![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)

## Características

- Registro, inicio y cierre de sesión
- Recuperación de contraseña
- Perfil de usuario: editar datos, cambiar contraseña y eliminar la cuenta
- Entorno reproducible con Docker Compose: no hace falta instalar PHP, Composer, Node ni MySQL en la máquina

## Stack

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.3 · Laravel 13 |
| Autenticación | Laravel Breeze |
| Base de datos | MySQL 8.4 |
| Servidor web | nginx + PHP-FPM |
| Frontend | Livewire (Volt Class API) with Alpine |
| Entorno | Docker Compose |

## Requisitos

- [Docker Engine](https://docs.docker.com/engine/install/) con el plugin Compose (verifica con `docker compose version`)
- Git

## Instalación

**1. Clona el repositorio**

```bash
git clone https://github.com/gustavos99/proyecto_laravel_13.git
cd proyecto_laravel_13
```

**2. Configura el usuario de Docker**

```bash
cp .env.example .env
```

Edita `.env` y pon en `USER_ID` y `GROUP_ID` lo que devuelven `id -u` e `id -g`. Así los archivos que creen los contenedores quedan a nombre de tu usuario.

**3. Configura Laravel**

```bash
cp src/.env.example src/.env
```

El archivo de ejemplo ya apunta a la base de datos del contenedor `db`.

**4. Levanta los contenedores**

```bash
docker compose up -d --build
```

**5. Instala dependencias, genera la clave y crea las tablas**

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

> La primera vez, MySQL tarda unos segundos en inicializarse. Si `migrate` falla con *Connection refused*, espera un momento y vuelve a ejecutarlo.

**6. Compila los assets**

```bash
docker compose run --rm node npm install
docker compose run --rm node npm run build
```

**7. Abre la aplicación**

[http://localhost:8001](http://localhost:8001)

## Servicios

| Servicio | Descripción | Puerto en tu máquina |
|---|---|---|
| `web` | nginx | 8001 |
| `app` | PHP 8.3-FPM + Composer | — (interno: 9000) |
| `db` | MySQL 8.4 | 3307 |
| `node` | Node 22, solo para tareas puntuales | — |

Credenciales de MySQL (solo para desarrollo local): base de datos `app`, usuario `app`, contraseña `secret`.

## Comandos útiles

| Acción | Comando |
|---|---|
| Levantar el entorno | `docker compose up -d` |
| Ver estado | `docker compose ps` |
| Ver logs | `docker compose logs -f app` |
| Abrir una terminal en PHP | `docker compose exec app bash` |
| Ejecutar Artisan | `docker compose exec app php artisan <comando>` |
| Ejecutar los tests | `docker compose exec app php artisan test` |
| Recompilar assets | `docker compose run --rm node npm run build` |
| Detener (conserva la base de datos) | `docker compose down` |
| Detener y borrar la base de datos | `docker compose down -v` |

## Estructura del proyecto

```
.
├── compose.yaml          # Definición de los servicios
├── docker/
│   ├── nginx/default.conf
│   └── php/Dockerfile    # PHP 8.3-FPM + extensiones + Composer
└── src/                  # Aplicación Laravel
```

## Licencia

Distribuido bajo la licencia MIT. Consulta el archivo [LICENSE](LICENSE).

## Autor

**Gustavo Salazar** · [GitHub](https://github.com/gustavos99) · [LinkedIn](https://www.linkedin.com/in/gsalazar-dev)

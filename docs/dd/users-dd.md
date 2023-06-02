# Diccionario de datos: Usuarios

Los usuarios de la plataforma son los que disfrutan de las experiencias educativas.

También existe un usuario de administración, que permite gestionar los experimentos.

Además, se utiliza una tabla para registrar los inicios de sesión de los usuarios (`user_login`).

## Tabla: `users`

### Descripción: 
Cada registro representa a un usuario.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de usuario |
| `name` | VARCHAR(255) | Not null |   | Nombre del usuario |
| `first_surname` | VARCHAR(255) |  | `NULL` | Apellido paterno del usuario |
| `second_surname` | VARCHAR(255) |  | `NULL` | Apellido materno del usuario |
| `gender` | VARCHAR(255) |  | `NULL` | Género del usuario |
| `email` | VARCHAR(255) | Not null, Unique |   | Correo electrónico del usuario |
| `course` | VARCHAR(255) |  | `NULL` | Curso inscrito del usuario |
| `course_letter` | VARCHAR(255) |  | `NULL` | Letra del curso del usuario |
| `college` | VARCHAR(255) |  | `NULL` | Colegio del usuario |
| `developer_mode` | TINYINT | Not null | `'0'` | Modo de desarrollador (1: Activado, 2: Desactivado) |
| `email_verified_at` | TIMESTAMP |  | `NULL` | Fecha de verificación de correo electrónico |
| `password` | VARCHAR(255) | Not null |   | Contraseña del usuario (cifrada) |
| `remember_token` | VARCHAR(100) |  | `NULL` | Token de recordatorio de contraseña |
| `created_at` | TIMESTAMP |  | `NULL` | Fecha de creación de registro |
| `updated_at` | TIMESTAMP |  | `NULL` | Fecha de última actualización de usuario |
| `experiment_endpoint_token` | VARCHAR(30) |  | `NULL` |  **foreign key** to column `token` on table `experiment_entrypoints`.  Token de endpoint de experimento por el cual se registró el usuario |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| users_email_unique | `email` | UNIQUE |   |
| users_experiment_endpoint_token_foreign | `experiment_endpoint_token` | INDEX |   |



## Tabla: `user_login`

### Descripción: 
Registro de inicios de sesión de los usuarios de la plataforma.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. Referencia a usuario que inició sesión |
| `created_at` | TIMESTAMP |  | `NULL` | Fecha de creación e inicio de sesión en plataforma |
| `updated_at` | TIMESTAMP |  | `NULL` | Fecha de actualización de registro (no debería usarse) |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_login_user_id_foreign | `user_id` | INDEX |   |


# Diccionario de datos: Experimentos

Los experimentos son parte del núcleo de la plataforma de juegos.
Cada experimento representa una experiencia educativa para estudiantes.

## Tabla: `experiments`

### Descripción: 
Con cada registro, en la tabla `experiments` se representa un juego base, del cual es posible crear una instancia.
Los experimentos contienen instancias de juego (que pueden ser vistas como "versiones del juego").
Cada instancia de juego, tiene asigna un valor específico a cada uno de los parámetros del juego.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador de experimento |
| `name` | VARCHAR(255) | Not null |   | Nombre de experimento |
| `description` | TEXT |  | `NULL` | Descripción de experimento |
| `status` | INT | Not null | `'0'` | Estado de experimento (0: Deshabilitado, 1: En ejecución)  |
| `time_limit` | BIGINT | Not null | `'86400'` | Tiempo límite de experimento para todas las instancias (segundos) |
| `created_at` | TIMESTAMP |  | `NULL` | Timestamp de creación de registro |
| `updated_at` | TIMESTAMP |  | `NULL` | Timestamp de actualización de registro  |
| `deleted_at` | TIMESTAMP |  | `NULL` | Timestamp de eliminado lógico |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |


## Tabla: `user_experiments`

### Descripción: 
Relación entre usuario y experimento.
Cada registro `user_experiments` es una asociación de un usuario y un experimento determinado.
Por otro lado, cada `game_instance_id` indica la relación con la instancia del juego que se le asignó a ese usuario.

El campo `game_instance_id` por defecto es nulo. Cuando el usuario selecciona un experimento, el sistema asigna una de las versiones del experimento a este campo. Las próximas veces que el usuario acceda al experimento, automáticamente se le presentará la versión de juego almacenada en este campo.

Cabe destacar que la plataforma asigna de manera automática y balanceada entre las versiones de juego de un experimento.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador  |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. ID de usuario asociado a experimento |
| `experiment_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `experiments`. ID de experimento asociado a usuario |
| `game_instance_id` | INT |  | `'0'` |  **foreign key** to column `id` on table `game_instances`. ID de instancia de juego. Asignado por la aplicación |
| `created_at` | TIMESTAMP |  | `NULL` |  Fecha de creación de registro |
| `updated_at` | TIMESTAMP |  | `NULL` |  Fecha de actualización de registro |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_experiments_user_id_foreign | `user_id` | INDEX |   |
| user_experiments_experiment_id_foreign | `experiment_id` | INDEX |   |
| user_experiments_game_instance_id_foreign | `game_instance_id` | INDEX |   |

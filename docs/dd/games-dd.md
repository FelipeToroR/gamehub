# Diccionario de datos: Juegos

Los juegos son parte fundamental de la plataforma de juegos. Estos son usados por instancias de experimento pertenecientes a cada experimento.

## Tabla: `games`

### Descripción: 
Con cada registro, en la tabla `games` se representa un juego base, del cual es posible crear una instancia.
Los experimentos contienen instancias de juego (que pueden ser vistas como "versiones del juego").
Cada instancia de juego, tiene asigna un valor específico a cada uno de los parámetros del juego.

El valor de los campos `width`, `height` y `proportion` son usados para el despliegue en la vista de juego.
Por defecto, se asigna 960x540px con proporción 1.8 que es el formato de `<canvas>` requerido para los juegos en GameHUB.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador |
| `slug` | VARCHAR(255) | Not null |   | Slug de juego |
| `name` | VARCHAR(255) | Not null |   | Nombre de juego |
| `description` | VARCHAR(255) |  | `NULL` | Descripción de juego |
| `extra` | JSON | Not null |   | Información adicional del juego (metadata) |
| `width` | INT | Not null | `'960'` | Ancho nativo de canvas (juego) |
| `height` | INT | Not null | `'540'` | Alto nativo de canvas (juego) |
| `proportion` | DOUBLE | Not null | `'1.80'` | Proporción de alto por ancho (juego) |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |

### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |

---

## Tabla: `game_parameters`

### Descripción:
Los parámetros del juego permiten habilitar opciones y características a cada juego.
Un registro de parámetro de juego define un nombre de parámetro y un tipo.

En esta tabla se definen los parámetros que permite configurar el juego; no el valor del parámetro.
El valor de los parámetros de juego son definidos en base a la instancia de juego en `game_instance_parameters`.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador de parámetro juego |
| `name` | VARCHAR(255) | Not null |   | Nombre de parámetro de juego |
| `type` | VARCHAR(255) | Not null |   | Tipo de parámetro de juego (int, boolean, decimal) |
| `game_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `games`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `description` | TEXT |  | `NULL` | Descripción de parámetro de juego (deprecated)  |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_parameters_game_id_foreign | `game_id` | INDEX |   |

---

## Tabla: `game_instances`

### Descripción: 
Una instancia de juego (`game_instance`) es una versión de un juego (`games`) con parámetros específicos.
Es posible tener múltiples instancias pertenecientes a un juego.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador |
| `slug` | VARCHAR(255) | Not null |   | Slug de instancia de juego |
| `name` | VARCHAR(255) | Not null |   | Nombre de instancia de juego |
| `description` | VARCHAR(255) |  | `NULL` | Descripción de instancia de juego |
| `game_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `games`. |
| `experiment_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `experiments`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `reward_id` | BIGINT |  | `NULL` |  **foreign key** to column `id` on table `rewards`. |
| `enable_rewards` | TINYINT | Not null | `'0'` | Habilita recompensas (0: deshabilitado, 1: habilitado) |
| `enable_badges` | TINYINT | Not null | `'0'` | Habilita medallas (0: deshabilitado, 1: habilitado) |
| `enable_performance_chart` | TINYINT | Not null | `'0'` | Habilita gráfico de rendimiento (0: deshabilitado, 1: habilitado) |
| `enable_leaderboard` | TINYINT | Not null | `'1'` | Habilita tabla de puntuación (0: deshabilitado, 1: habilitado) |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_instances_game_id_foreign | `game_id` | INDEX |   |
| game_instances_experiment_id_foreign | `experiment_id` | INDEX |   |
| game_instances_reward_id_foreign | `reward_id` | INDEX |   |

---

## Tabla: `game_instance_parameters`

### Descripción: 
Un parámetro de instancia de juego (`game_instance_parameters`) corresponde a un valor asignado para un parámetro de juego (`game_parameters`).

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   |   |
| `name` | VARCHAR(255) | Not null |   | Nombre del parámetro de la instancia |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `game_parameter_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_parameters`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_instance_parameters_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| game_instance_parameters_game_parameter_id_foreign | `game_parameter_id` | INDEX |   |

---

## Tabla: `game_exercises`

### Descripción: 
Cada registro de esta tabla, representa a un ejercicios de una instancia de juego.
Cada ejercicio que realiza un usuario es registrado en esta tabla, cuando el juego finaliza una ronda.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador |
| `event` | INT | Not null |   | Tipo de evento: (1) Inicio de partida, (2) Ejercicio, (3) Término de partida |
| `round` | INT |  | `NULL` | Ronda |
| `exercise` | TEXT |  | `NULL` | Ejercicio en formato texto |
| `user_response` | TEXT |  | `NULL` | Respuesta del usuario |
| `response` | TEXT |  | `NULL` | Respuesta correcta |
| `score` | BIGINT |  | `NULL` | Puntaje del usuario al momento de registrar el ejercicio |
| `lives` | INT |  | `NULL` | Vidas del usuario al momento de registrar el usuario |
| `time_start` | TIMESTAMP |  | `NULL` | Registro de tiempo al iniciar ejercicio |
| `time_end` | TIMESTAMP |  | `NULL` | Registro de tiempo al terminar ejercicio |
| `extra` | JSON |  | `NULL` | JSON con datos extra de ejercicios |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_exercises_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| game_exercises_user_id_foreign | `user_id` | INDEX |   |

---

## Tabla: `game_instance_scores`

### Descripción: 
Registro de puntaje máximo de instancia de juego.
Cada vez que el usuario supera su record, actualiza el valor de `max_score` y a su vez `updated_at` para mantener el último record.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `max_score` | BIGINT | Not null | `'0'` |   |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_instance_scores_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| game_instance_scores_user_id_foreign | `user_id` | INDEX |   |

---

## Tabla: `game_instance_time_counter`

### Descripción: 
Registro de tiempo de la instancia de juego.
Cada vez que el usuario realiza un registro de tiempo en un día calendario, lo registra y acumula en el campo `time_used`.
Un usuario puede tener varios de estos registros, con distinta fecha (`date`) lo cual representa el tiempo usado cada día.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador |
| `date` | DATE | Not null |   | Fecha de tiempo acumulado |
| `time_used` | BIGINT | Not null |   | Tiempo acumulado usado |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_instance_time_counter_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| game_instance_time_counter_user_id_foreign | `user_id` | INDEX |   |


## Tabla: `game_instance_times` (deprecated)

### Descripción: 
DEPRECADO
Registro de tiempo de la instancia de juego. 
Usado en versiones anteriores.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `date` | DATE | Not null |   |   |
| `remaining_time` | INT | Not null |   |   |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_instance_times_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| game_instance_times_user_id_foreign | `user_id` | INDEX |   |
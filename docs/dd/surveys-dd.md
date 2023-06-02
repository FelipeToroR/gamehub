## Tabla: `surveys`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `description` | TEXT | Not null |   |   |
| `type` | TINYINT | Not null | `'0'` | Tipo de encuesta |
| `initial_date` | DATETIME |  | `NULL` | Fecha de inicio de despliegue de test |
| `end_date` | DATETIME |  | `NULL` | Fecha de término de despliegue de test |
| `body` | JSON | Not null |   |   |
| `experiment_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `experiments`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 
| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| surveys_experiment_id_foreign | `experiment_id` | INDEX |   |


## Tabla: `survey_responses`

### Descripción: 



### Columnas: 
| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `experiment_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `experiments`. |
| `survey_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `surveys`. |
| `test` | VARCHAR(255) | Not null |   |   |
| `label` | VARCHAR(255) | Not null |   |   |
| `question` | VARCHAR(255) |  | `NULL` |   |
| `response` | TEXT |  | `NULL` |   |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| survey_responses_user_id_foreign | `user_id` | INDEX |   |
| survey_responses_experiment_id_foreign | `experiment_id` | INDEX |   |
| survey_responses_survey_id_foreign | `survey_id` | INDEX |   |


## Tabla: `test_exercises`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   |   |
| `event` | INT | Not null |   |   |
| `test` | VARCHAR(255) | Not null |   | Etiqueta de test que agrupa ejercicios |
| `label` | VARCHAR(255) | Not null |   | Etiqueta identificador de ejercicio |
| `exercise` | TEXT |  | `NULL` |   |
| `user_response` | TEXT |  | `NULL` |   |
| `response` | TEXT |  | `NULL` |   |
| `time_start` | TIMESTAMP |  | `NULL` |   |
| `time_end` | TIMESTAMP |  | `NULL` |   |
| `extra` | JSON |  | `NULL` |   |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| test_exercises_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| test_exercises_user_id_foreign | `user_id` | INDEX |   |

# Atributos asociados al usuario

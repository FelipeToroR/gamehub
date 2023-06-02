# Diccionario de datos: Medallas

Dentro de las nuevas características que estan en proceso de pruebas, consideramos uno de los aspectos básicos de gamificación.

## Tabla: `game_badges`

### Descripción: 

Medallas que permite el juego.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   |   |
| `code` | VARCHAR(255) | Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `description` | VARCHAR(255) | Not null |   |   |
| `conditions` | VARCHAR(255) | Not null |   |   |
| `game_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `games`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| game_badges_game_id_foreign | `game_id` | INDEX |   |




## Tabla: `user_game_badges`

### Descripción: 

Medallas de juego ganadas por el usuario.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `game_badge_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_badges`. |
| `game_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `games`. |
| `user_id` | BIGINT | Not null |   |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_game_badges_game_badge_id_foreign | `game_badge_id` | INDEX |   |
| user_game_badges_game_id_foreign | `game_id` | INDEX |   |
| user_game_badges_user_id_foreign | `user_id` | INDEX |   |

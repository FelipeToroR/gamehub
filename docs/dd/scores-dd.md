# Diccionario de datos: Puntajes

Dentro de las nuevas características que estan en proceso de pruebas, consideramos uno de los aspectos básicos de gamificación.

En cuanto a puntajes, se consideran dos tipos:

- **💰 Monedas**: Puntaje acumulado en forma de moneda virtual.
- **🔋 Experiencia**: Puntaje acumulado basado en los ejercicios respondidos.

---

## Tabla: `user_currencies`

### Descripción: 
Registro resumen de monedas adquiridas, un registro por usuario/instancia de juego.
Este registro se actualiza cada vez que un usuario gana o gasta monedas.
Evita realizar suma de todos los registros, cada vez que se invoca.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador |
| `amount` | BIGINT | Not null | `'0'` | Monto de monedas acumulado |
| `game_instance_id` | INT | Not null |   |  **foreign key** to column `id` on table `game_instances`. Referencia a instancia de juego a la que pertenece la cantidad de monedas |
| `user_id` | BIGINT | Not null |   |  **foreign key** to column `id` on table `users`. Referencia a usuario al cual pertenece cantidad de monedas |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_currencies_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| user_currencies_user_id_foreign | `user_id` | INDEX |   |

---

## Tabla: `user_currency_transactions`

### Descripción: 
Registro de transacciones de monedas asociadas por cada usuario.

De forma general, mantiene un registro del historial de monedas adquiridas junto a su fecha.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de transacción |
| `amount` | BIGINT | Not null | `'0'` | Monto de transacción |
| `operation` | SET | Not null |   | Operación de transacción |
| `user_currency_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `user_currencies`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_currency_transactions_user_currency_id_foreign | `user_currency_id` | INDEX |   |

---

## Tabla: `user_experiences`

### Descripción: 
Registro resumen de experiencia adquirida, un registro por usuario/instancia de juego.
Este registro se actualiza cada vez que un usuario adquiere monedas.
Evita realizar suma de todos los registros, cada vez que se invoca.


### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de experiencia de usuario |
| `amount` | BIGINT | Not null | `'0'` | Monto de ítem experiencia acumulado |
| `game_instance_id` | INT | Not null |   |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null |   |  **foreign key** to column `id` on table `users`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_experiences_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| user_experiences_user_id_foreign | `user_id` | INDEX |   |

---

## Tabla: `user_experience_transactions`

### Descripción:

Registro de transacciones de experiencia asociadas para cada instancia de juego de un usuario específico.

De forma general, mantiene un registro del historial de experiencia adquirida junto a su fecha.


### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de transacción |
| `amount` | BIGINT | Not null | `'0'` | Monto de transacción de experiencia |
| `user_experience_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `user_experiences`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_experience_transactions_user_experience_id_foreign | `user_experience_id` | INDEX |   |
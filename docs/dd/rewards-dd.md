# Diccionario de datos: Recompensas

Las recompensas requieren considerar los siguientes modelos de datos.

---

## Tabla: `rewards`

### Descripción: 

Recompensa, asignable a una instancia de juego.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de recompensa |
| `name` | VARCHAR(255) | Not null |   | Nombre de recompensa |
| `description` | VARCHAR(255) | Not null |   | Descripción de recompensa |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |

---

## Tabla: `reward_days`

### Descripción: 

Día de recompensa.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador de día de recompensa |
| `day` | INT | Not null |   | Día de premio en base a reclamo de recompensa |
| `reward_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `rewards`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| reward_days_reward_id_foreign | `reward_id` | INDEX |   |


---

## Tabla: `reward_day_items`

### Descripción: 

Ítem de día de recompensa.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   | Identificador de ítem de recompensa |
| `quantity` | INT | Not null |   | Cantidad de ítemes a entregar de `bag_item_type_id` |
| `reward_day_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `reward_days`. |
| `bag_item_type_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `bag_item_types`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| reward_day_items_reward_day_id_foreign | `reward_day_id` | INDEX |   |
| reward_day_items_bag_item_type_id_foreign | `bag_item_type_id` | INDEX |   |

---

## Tabla: `user_reward_transactions`

### Descripción: 

Almacena la transacción de recompensa para un usuario.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   | Identificador de recompensa |
| `game_instance_id` | INT | Not null |   |  **foreign key** to column `id` on table `game_instances`. |
| `user_id` | BIGINT | Not null |   |  **foreign key** to column `id` on table `users`. |
| `day_counter` | INT | Not null |   | Contador de días incremental |
| `created_at` | TIMESTAMP | Not null | `CURRENT_TIMESTAMP` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_reward_transactions_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| user_reward_transactions_user_id_foreign | `user_id` | INDEX |   |

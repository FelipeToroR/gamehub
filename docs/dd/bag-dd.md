## Tabla: `bag_item_types`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `description` | VARCHAR(255) | Not null |   |   |
| `actions` | TEXT | Not null |   |   |
| `game_id` | INT |  | `'0'` |  **foreign key** to column `id` on table `games`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| bag_item_types_game_id_foreign | `game_id` | INDEX |   |


## Tabla: `user_bag_items`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | INT | PRIMARY, Auto increments, Not null |   |   |
| `quantity` | INT | Not null |   |   |
| `user_id` | BIGINT | Not null | `'0'` |  **foreign key** to column `id` on table `users`. |
| `game_instance_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `game_instances`. |
| `bag_item_type_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `bag_item_types`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| user_bag_items_user_id_foreign | `user_id` | INDEX |   |
| user_bag_items_game_instance_id_foreign | `game_instance_id` | INDEX |   |
| user_bag_items_bag_item_type_id_foreign | `bag_item_type_id` | INDEX |   |


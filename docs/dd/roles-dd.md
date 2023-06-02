
## Tabla: `permissions`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `guard_name` | VARCHAR(255) | Not null |   |   |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |


## Tabla: `role_has_permissions`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `permission_id` | BIGINT | PRIMARY, Not null |   |  **foreign key** to column `id` on table `permissions`. |
| `role_id` | BIGINT | PRIMARY, Not null |   |  **foreign key** to column `id` on table `roles`. |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `permission_id`, `role_id` | PRIMARY |   |
| role_has_permissions_role_id_foreign | `role_id` | INDEX |   |


## Tabla: `roles`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `guard_name` | VARCHAR(255) | Not null |   |   |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |




## Tabla: `model_has_permissions`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `permission_id` | BIGINT | PRIMARY, Not null |   |  **foreign key** to column `id` on table `permissions`. |
| `model_type` | VARCHAR(255) | PRIMARY, Not null |   |   |
| `model_id` | BIGINT | PRIMARY, Not null |   |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `permission_id`, `model_id`, `model_type` | PRIMARY |   |
| model_has_permissions_model_id_model_type_index | `model_id`, `model_type` | INDEX |   |


## Tabla: `model_has_roles`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `role_id` | BIGINT | PRIMARY, Not null |   |  **foreign key** to column `id` on table `roles`. |
| `model_type` | VARCHAR(255) | PRIMARY, Not null |   |   |
| `model_id` | BIGINT | PRIMARY, Not null |   |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `role_id`, `model_id`, `model_type` | PRIMARY |   |
| model_has_roles_model_id_model_type_index | `model_id`, `model_type` | INDEX |   |


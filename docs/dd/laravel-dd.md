
## Tabla: `migrations`

### Descripción: 



### Columnas: 

| Columna     | Tipo de dato | Atributos                          | Por defecto | Descripción |
| ----------- | ------------ | ---------------------------------- | ----------- | ----------- |
| `id`        | INT          | PRIMARY, Auto increments, Not null |             |             |
| `migration` | VARCHAR(255) | Not null                           |             |             |
| `batch`     | INT          | Not null                           |             |             |


### Indices: 

| Nombre  | Columnas | Tipo    | Descripción |
| ------- | -------- | ------- | ----------- |
| PRIMARY | `id`     | PRIMARY |             |







## Tabla: `failed_jobs`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `connection` | TEXT | Not null |   |   |
| `queue` | TEXT | Not null |   |   |
| `payload` | LONGTEXT | Not null |   |   |
| `exception` | LONGTEXT | Not null |   |   |
| `failed_at` | TIMESTAMP | Not null | `CURRENT_TIMESTAMP` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |




## Tabla: `media`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `id` | BIGINT | PRIMARY, Auto increments, Not null |   |   |
| `model_type` | VARCHAR(255) | Not null |   |   |
| `model_id` | BIGINT | Not null |   |   |
| `uuid` | CHAR(36) |  | `NULL` |   |
| `collection_name` | VARCHAR(255) | Not null |   |   |
| `name` | VARCHAR(255) | Not null |   |   |
| `file_name` | VARCHAR(255) | Not null |   |   |
| `mime_type` | VARCHAR(255) |  | `NULL` |   |
| `disk` | VARCHAR(255) | Not null |   |   |
| `conversions_disk` | VARCHAR(255) |  | `NULL` |   |
| `size` | BIGINT | Not null |   |   |
| `manipulations` | JSON | Not null |   |   |
| `custom_properties` | JSON | Not null |   |   |
| `responsive_images` | JSON | Not null |   |   |
| `order_column` | INT |  | `NULL` |   |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `id` | PRIMARY |   |
| media_model_type_model_id_index | `model_type`, `model_id` | INDEX |   |




## Tabla: `password_resets`

### Descripción: 



### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `email` | VARCHAR(255) | Not null |   |   |
| `token` | VARCHAR(255) | Not null |   |   |
| `created_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| password_resets_email_index | `email` | INDEX |   |




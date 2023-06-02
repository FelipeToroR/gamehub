# Diccionario de datos: Puntos de entrada de experimento

Los experimentos son parte del núcleo de la plataforma de juegos.
Cada experimento representa una experiencia educativa para estudiantes.

Los puntos de entrada son páginas donde el estudiante puede acceder mediante una URL con un token único.

## Tabla: `experiment_entrypoints`

### Descripción: 
Cada registro `experiment_entrypoints` es un punto de entrada para un experimento en específico.

### Columnas: 

| Columna | Tipo de dato | Atributos | Por defecto | Descripción |
| --- | --- | --- | --- | ---  |
| `token` | VARCHAR(30) | PRIMARY, Not null |   | Token único para punto de entrada |
| `title` | VARCHAR(100) |  | `NULL` | Título visible por los usuarios |
| `information` | VARCHAR(255) |  | `NULL` | Información visible por los usuarios |
| `obfuscated` | INT | Not null | `'0'` | (No usado) Flag que indica si el token estará obfuscado |
| `default_college` | VARCHAR(255) |  | `NULL` | Valor por defecto para el colegio (usado en registro de usuarios) |
| `default_course` | VARCHAR(255) |  | `NULL` |  Valor por defecto para el curso (usado en registro de usuarios) |
| `experiment_id` | INT | Not null | `'0'` |  **foreign key** to column `id` on table `experiments`. |
| `created_at` | TIMESTAMP |  | `NULL` |   |
| `updated_at` | TIMESTAMP |  | `NULL` |   |
| `deleted_at` | TIMESTAMP |  | `NULL` |   |


### Indices: 

| Nombre | Columnas | Tipo | Descripción |
| --- | --- | --- | --- |
| PRIMARY | `token` | PRIMARY |   |
| experiment_entrypoints_experiment_id_foreign | `experiment_id` | INDEX |   |


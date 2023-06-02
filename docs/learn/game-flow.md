# Flujo de carga de juego

La interacción entre el juego y la plataforma (cliente/servidor) considera una serie de mensajes para entregar y recibir la información relevante.

## Load (carga)

Se ejecuta al cargar el juego.

Entrega información útil para el usuario.

```
{
  "u":{                                 // Parámetros de usuario
    "name":"Super administrador",       // Nombre del usuario
    "fullname":"Super administrador",   // Nombre completo del usuario 
    "username":"Super administrador",   // Nombre de usuario 
    "max_score":180,                    // Último puntaje máximo registrado
    "currency":2053,                    // Cantidad de monedas actual
    "badges":[                          // Lista de medallas adquiridas
      {
        "name":"MCFPP1"                 // Identificador único de medalla
      },
      {
        "name":"MCFPP2"
      },
      {
        "name":"MCFAR1"
      },
      {
        "name":"MCFIR1"
      }
    ],
    "time_used":0,                      // Tiempo usado en el día
    "time_limit":86400,                 // Tiempo máximo para el día
    "time_left":86400,                  // (deprecado)
    "tests":[                           // Lista de test
      {
        "test":"PRETEST",               // Identificador del test
        "last_label":"12"               // Último label del juego
      },
      {
        "test":"POSTEST",
        "last_label":"12"
      }
    ],
    "total_exercises":274,              // Total de ejercicios realizados por el usuario
    "to_postest": false                 // Indica si cumplió total de ejercicios segun condición 
  },
  "p":{                             // Parámetros del juego
    "currencyEnabled":true,
    "expEnabled":true,
    "badgesEnabled":true,
    "lrnObjective":101,
    "debug":false,
    "distroMode":2
  }
}
```

### Estados (`status_player`)

EL estado del jugador indica en que fase está.

Experimento:
- Total de ejercicios para terminar juego:
- Fecha límite de cierre de experimento:

Si se cumple alguno, `end_game`

`status_player` = 2 (jugando)

**¿Cuándo cambia a 3?**
SIEMPRE y cuando:
total_ej_jugador >= total_ejerc_experimento
||
fecha_actual >= fecha_definida

- Cuando guardas, te respondo con un `status_player` actualizado, puedo responder el mismo `2` o `3` cumplió la condición.


`status_player` = 3 (postest game)

**¿Cuándo cambia a 4?**
Envía en el save.
```
{
  "game":{
    "token":"VmhnU2FSZFpVYnFlV0hqTTZpOTRLdz09",         // Identificar la instancia de juego
    "experience":110,                                   // Experiencia de última ronda
    "add_currency":2,                                   // Dinero ganado en la última ronda
    ...
    "status_player": 4,                                 // Envía status player 4 (envía a pantalla de survey no-juego)
    ...
}
```

`status_player` = 4 (postest end)

** Survey**
Ninguno
Inicial
Final (bsado en experimento)



## Save (guarda)

Se ejecuta al guardar datos del juego en el servidor.

Almacena información del usuario (cliente) en el servidor, incluyendo los eventos que realizó el usuario.

```
{
  "game":{
    "token":"VmhnU2FSZFpVYnFlV0hqTTZpOTRLdz09",         // Identificar la instancia de juego
    "experience":110,                                   // Experiencia de última ronda
    "add_currency":2,                                   // Dinero ganado en la última ronda
    "time_left":0,                                      // (deprecated)
    "time_used":1504                                    // Tiempo usado en la última ronda
  },
  "exercises":[
    "{\"event\":1,\"round\":1,\"timeStart\":\"26/08/2020 16:55:42\",\"timeEnd\":0,\"lives\":3,\"score\":0}",
    "{\"event\":2,\"round\":1,\"timeStart\":\"26/08/2020 16:55:42\",\"timeEnd\":\"26/08/2020 17:05:53\",\"lives\":3,\"score\":100,\"exercise\":\"fra.tip.imp: 6/7 - 1 1/2 - 10/8 - 2 1/2\",\"response\":\"10/8\",\"userResponse\":\"10/8\",\"origin\":\"N\",\"extras\":{\"intentos\":{\"1\":\"10/8\"}}}",
    "{\"event\":2,\"round\":1,\"timeStart\":\"26/08/2020 17:05:58\",\"timeEnd\":\"26/08/2020 17:06:01\",\"lives\":2,\"score\":100,\"exercise\":\"fra.tip.imp: 1 1/7 - 7/9 - 3/6 - 12/7\",\"response\":\"12/7\",\"userResponse\":\"3/6\",\"origin\":\"N\",\"extras\":{\"intentos\":{\"1\":\"3/6\"}}}",
    "{\"event\":2,\"round\":1,\"timeStart\":\"26/08/2020 17:06:05\",\"timeEnd\":\"26/08/2020 17:06:08\",\"lives\":2,\"score\":110,\"exercise\":\"fra.tip.imp: 6/7 - 1 1/2 - 10/8 - 2 1/2\",\"response\":\"10/8\",\"userResponse\":\"10/8\",\"origin\":\"B\",\"extras\":{\"intentos\":{\"1\":\"10/8\"}}}",
    "{\"event\":3,\"round\":2,\"timeStart\":\"26/08/2020 17:06:15\",\"timeEnd\":\"26/08/2020 17:06:15\",\"lives\":2,\"score\":110}"
  ]
}
```
### Eventos

Cada uno de los eventos, tiene un tipo, el cual determina el significado del evento.

Event:
- `1` : Inicio de partida/ronda
- `2` : Ejercicio
- `3` : Término de partida
- `4` : Término inesperado de partida


## Comprar

Se ejecuta al invocar una compra desde el juego (cliente).

Envia una transacción de compra desde el usuario (cliente) al servidor.

URL de la solicitud: `/game-instances/shop/buy`.

** Envío de transacción **
```
{
  "currency":{
    "cost":4,
    "item":"ERASE_OPTION",
    "time":"26/08/2020 17:02:55"
  },
  "game":{
    "token":"VmhnU2FSZFpVYnFlV0hqTTZpOTRLdz09"
  }
}
```

** Respuesta de transacción **
```
{
    "status":0,       // Resultado 0: Correcto
    "currency":2049   // Monto actualizado
}
```

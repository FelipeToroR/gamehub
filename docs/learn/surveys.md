# Encuestas

## Administración

Para crear puntos de entrada, debe acceder como administrador a Experimentos > Seleccionar un experimento > Configurar > Encuestas

Al día de hoy, las encuestas se construyen utilizando un archivo JSON con una estructura específica.


### Creación de encuesta

...



### Estructura de encuesta

La estructura principal de una encuesta, considera un arreglo de `slides`:

```
{
  "slides":[
      ...
  ]
}
```

Dentro del arreglo de slides podemos incluir tres tipos de elementos, los cuales se definen por el valor de `type`.

**Bloque de texto (`slide-text`)**
El bloque de texto presenta una estructura general.

```
{
    "type":"slide-text",
    "title":"Ahora te realizaremos 8 preguntas"
    "body":"Luego de haber jugado por unas semanas, queremos saber si has mejorado tu nivel de conocimiento, ¡pon tu mayor esfuerzo!",
    "audio":"/public/sounds/presentacion_ejercicios_nmrbrds.ogg",
},
```
*Campos permitidos*:
- `title` : Título de bloque de texto.
- `body` : Cuerpo de bloque de texto
- `audio` (opcional): Si requiere audio de fondo, indique URL absoluta o relativa.
---
**Bloque de likert (`slide-likert`)**
Una pregunta de tipo likert con una escala de caras de 1 a 5.

```
{
    "type":"slide-likert",
    "title":"Pienso que fue una actividad aburrida"
    "label":"post_imi_g",
    "audio":"/public/sounds/post_imi_g_nmrbrds.ogg",
},
```
*Campos permitidos*:
- `title` : Pregunta de escala likert.
- `label` : Identificador alfanumerico de pregunta.
- `audio` (opcional): Si requiere audio de fondo, indique URL absoluta o relativa.

---

**Bloque de pregunta**
Una pregunta de selección múltiple que puede considerar imagenes o texto.
```
{
    "type":"slide-question",
    "label":"pre_preg_2",
    "title":"Elige la respuesta a la siguiente resta: 25 - 14",
    "alts":[
        {
            "image":"/public/images/test/P2 C.png",
            "value":"83"
        },
        {
            "image":"/public/images/test/P2 A.png",
            "value":"5"
        },
        {
            "image":"/public/images/test/P2 B.png",
            "value":"11"
        }
    ]
},
```
```
{
    "type":"slide-submit"
}
```
*Campos permitidos*:
- `title` : Pregunta de escala likert.
- `label` : Identificador alfanumerico de pregunta.
- `alts`: Arreglo de alternativas. Cada alternativa debe tener un `value` que es el valor que se almacena en base de datos.
Además puede tener una imagen que se presentará como botón en la pregunta.
- `audio` (opcional): Si requiere audio de fondo, indique URL absoluta o relativa.

### Ejemplo de encuesta

Encuesta real utilizada en experimentos.

```
{
  "slides":[
    {
      "body":"Luego de haber jugado por unas semanas, queremos saber si has mejorado tu nivel de conocimiento, ¡pon tu mayor esfuerzo!",
      "type":"slide-text",
      "audio":"/public/sounds/presentacion_ejercicios_nmrbrds.ogg",
      "title":"Ahora te realizaremos 8 preguntas"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P1 C.png",
          "value":"62"
        },
        {
          "image":"/public/images/test/P1 B.png",
          "value":"125"
        },
        {
          "image":"/public/images/test/P1 A.png",
          "value":"71"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_1",
      "title":"Elige la respuesta a la siguiente suma: 41 + 21"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P2 C.png",
          "value":"83"
        },
        {
          "image":"/public/images/test/P2 A.png",
          "value":"5"
        },
        {
          "image":"/public/images/test/P2 B.png",
          "value":"11"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_2",
      "title":"Elige la respuesta a la siguiente resta: 25 - 14"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P3 C.png",
          "value":"69"
        },
        {
          "image":"/public/images/test/P3 A.png",
          "value":"29"
        },
        {
          "image":"/public/images/test/P3 B.png",
          "value":"47"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_3",
      "title":"Elige la respuesta a la siguiente resta: 89 - 42"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P4 C.png",
          "value":"96"
        },
        {
          "image":"/public/images/test/P4 B.png",
          "value":"77"
        },
        {
          "image":"/public/images/test/P4 A.png",
          "value":"2"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_4",
      "title":"Elige la respuesta a la siguiente resta: 88 - 11"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P5 A.png",
          "value":"78"
        },
        {
          "image":"/public/images/test/P5 B.png",
          "value":"132"
        },
        {
          "image":"/public/images/test/P5 C.png",
          "value":"212"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_5",
      "title":"Elige la respuesta a la siguiente suma: 64 + 68"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P6 B.png",
          "value":"154"
        },
        {
          "image":"/public/images/test/P6 C.png",
          "value":"127"
        },
        {
          "image":"/public/images/test/P6 A.png",
          "value":"37"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_6",
      "title":"Elige la respuesta a la siguiente suma: 54 + 73"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P7 C.png",
          "value":"9"
        },
        {
          "image":"/public/images/test/P7 B.png",
          "value":"171"
        },
        {
          "image":"/public/images/test/P7 A.png",
          "value":"117"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_7",
      "title":"¿Cuál imagen representa el siguiente número?: 171"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P8 A.png",
          "value":"59"
        },
        {
          "image":"/public/images/test/P8 B.png",
          "value":"95"
        },
        {
          "image":"/public/images/test/P8 C.png",
          "value":"14"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_8",
      "title":"¿Cuál imagen representa el siguiente número?: 95"
    },
    {
      "alts":[
        {
          "image":"/public/images/test/P9 A.png",
          "value":"75"
        },
        {
          "image":"/public/images/test/P9 C.png",
          "value":"12"
        },
        {
          "image":"/public/images/test/P9 B.png",
          "value":"57"
        }
      ],
      "type":"slide-question",
      "label":"pre_preg_9",
      "title":"¿Cuál imagen representa el siguiente número?: 57"
    },
    {
      "body":"Puedes realizarlo con ayuda de un adulto, para comprender las preguntas.",
      "type":"slide-text",
      "audio":"/public/sounds/presentacion.ogg",
      "title":"Para terminar la experiencia, necesitamos que contestes una pequeña encuesta"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_a",
      "audio":"/public/sounds/post_imi_a_nmrbrds.ogg",
      "title":"La actividad fue muy agradable"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_b",
      "audio":"/public/sounds/post_imi_b_nmrbrds.ogg",
      "title":"Fui bastante capaz en los ejercicios del juego"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_c",
      "audio":"/public/sounds/post_imi_c_nmrbrds.ogg",
      "title":"Puse muy poco esfuerzo en esto"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_d",
      "audio":"/public/sounds/post_imi_d_nmrbrds.ogg",
      "title":"Estaba nervioso(a) durante la actividad"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_e",
      "audio":"/public/sounds/post_imi_e_nmrbrds.ogg",
      "title":"Hice esta actividad por que quise"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_f",
      "audio":"/public/sounds/post_imi_f_nmrbrds.ogg",
      "title":"Hacer esta actividad mejoró mis habilidades para representar números con bloques"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_g",
      "audio":"/public/sounds/post_imi_g_nmrbrds.ogg",
      "title":"Pienso que fue una actividad aburrida"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_h",
      "audio":"/public/sounds/post_imi_h_nmrbrds.ogg",
      "title":"Creo que estuve bastante bien durante la actividad"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_j",
      "audio":"/public/sounds/post_imi_j_nmrbrds.ogg",
      "title":"Me sentí tranquilo/calmado(a) al realizar la actividad"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_k",
      "audio":"/public/sounds/post_imi_k_nmrbrds.ogg",
      "title":"Hice esta actividad por obligación"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_l",
      "audio":"/public/sounds/post_imi_l_nmrbrds.ogg",
      "title":"Esta actividad me ayudó en matemáticas"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_m",
      "audio":"/public/sounds/post_imi_m_nmrbrds.ogg",
      "title":"La actividad fue divertida de hacer"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_n",
      "audio":"/public/sounds/post_imi_n_nmrbrds.ogg",
      "title":"No pude hacer muy bien la actividad"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_o",
      "audio":"/public/sounds/post_imi_o_nmrbrds.ogg",
      "title":"Para mi era importante hacerlo bien"
    },
    {
      "type":"slide-likert",
      "label":"post_imi_p",
      "audio":"/public/sounds/post_imi_p_nmrbrds.ogg",
      "title":"Sentí que tenia que hacer esto"
    },
    {
      "type":"slide-submit"
    }
  ]
}
```

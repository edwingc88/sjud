SET search_path TO sch_prueba;

DROP TABLE puntaje, persona_invitada, persona, examen_dificultad, respuesta, evaluacion, intento, opcion, pregunta, tema, examen, dificultad;

CREATE TABLE puntaje (
 id SMALLINT PRIMARY KEY,
 nombre VARCHAR(25) NOT NULL,
 minimo SMALLINT NOT NULL,
 maximo SMALLINT NOT NULL,
 mensaje TEXT NOT NULL,
 CHECK (minimo BETWEEN 0 AND 10),
 CHECK (minimo <= maximo)
);
INSERT INTO puntaje (id, nombre, minimo, maximo, mensaje) VALUES
 (0, 'Insuficiente', 0, 2, ''),
 (1, 'Pobre', 3, 4, ''),
 (2, 'Regular', 5, 6, ''),
 (4, 'Bueno', 7, 8, ''),
 (5, 'Sobresaliente', 9, 9, ''),
 (6, 'Excelente', 10, 10, '');

CREATE TABLE persona (
 id NUMERIC(20) PRIMARY KEY
);

CREATE TABLE persona_invitada (
 id NUMERIC(20) PRIMARY KEY REFERENCES persona (id) ON DELETE CASCADE ON UPDATE CASCADE,
 usuario CHAR(32) NOT NULL,
 clave CHAR(32) NOT NULL,
 nombre VARCHAR(50) NOT NULL,
 apellido VARCHAR(50) NOT NULL,
 sexo CHAR NOT NULL,
 fecha_nacimiento DATE,
 agregado_por NUMERIC(20) NOT NULL,
 correo_electronico VARCHAR(256)
 CHECK (sexo IN ('M', 'F'))
);

CREATE TABLE dificultad (
 id SMALLINT PRIMARY KEY,
 nombre VARCHAR(50) NOT NULL
);
COMMENT ON TABLE dificultad IS 'Indica el valor de la difícultad del exámen o las preguntas.';
COMMENT ON COLUMN dificultad.id IS 'Clave primaria de la díficultad.';
COMMENT ON COLUMN dificultad.nombre IS 'Nombre de la díficultad.';
INSERT INTO dificultad (id, nombre) VALUES
 (0, 'Fácil'),
 (1, 'Normal'),
 (2, 'Difícil');

CREATE TABLE examen (
 id CHAR(3) PRIMARY KEY,
 nombre VARCHAR(50) NOT NULL,
 descripcion TEXT NOT NULL,
 cantidad_preguntas SMALLINT NOT NULL,
 duracion SMALLINT NOT NULL,
 CHECK (cantidad_preguntas >= 1 OR cantidad_preguntas = -1),
 CHECK (duracion >= 1)
);
COMMENT ON TABLE examen IS 'Almacena los exámenes.';
COMMENT ON COLUMN examen.id IS 'Clave primaria del exámen.';
COMMENT ON COLUMN examen.nombre IS 'Nombre del exámen.';
COMMENT ON COLUMN examen.nombre IS 'Nombre del exámen.';
COMMENT ON COLUMN examen.descripcion IS 'Descripción larga del exámen.';
COMMENT ON COLUMN examen.cantidad_preguntas IS 'Cantidad de preguntas a realizar en el exámen, si el valor es igual a -1 entonces se presentan todas las preguntas.';
COMMENT ON COLUMN examen.duracion IS 'Duración del exámen en minutos siempre mayor a 1.';
INSERT INTO examen (id, nombre, cantidad_preguntas, duracion, descripcion) VALUES
 ('E01', 'PHP 5', 25, 20, 'Exámen de PHP 5.');

CREATE TABLE examen_dificultad (
 id_examen CHAR(3) NOT NULL REFERENCES examen (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_dificultad_seleccionada SMALLINT NOT NULL REFERENCES dificultad (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_dificultad_porcentual SMALLINT NOT NULL REFERENCES dificultad (id) ON DELETE CASCADE ON UPDATE CASCADE,
 porcentaje SMALLINT NOT NULL DEFAULT 0,
 PRIMARY KEY (id_examen, id_dificultad_seleccionada, id_dificultad_porcentual),
 CHECK (porcentaje BETWEEN 0 AND 100)
);

INSERT INTO examen_dificultad (id_examen, id_dificultad_seleccionada, id_dificultad_porcentual, porcentaje) VALUES
 ('E01', 0, 0, 80),
 ('E01', 0, 1, 10),
 ('E01', 0, 2, 10),
 ('E01', 1, 0, 30),
 ('E01', 1, 1, 50),
 ('E01', 1, 2, 20),
 ('E01', 2, 0, 10),
 ('E01', 2, 1, 10),
 ('E01', 2, 2, 80);

CREATE TABLE tema (
 id_examen CHAR(3) NOT NULL REFERENCES examen (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_tema CHAR(3) NOT NULL,
 nombre VARCHAR(256) NOT NULL,
 descripcion TEXT NOT NULL,
 PRIMARY KEY (id_examen, id_tema)
);

INSERT INTO tema (id_tema, id_examen, nombre, descripcion) VALUES
 ('T01', 'E01', 'Programación Básica de PHP', 'Examen de los fundamentos básicos del lenguaje de programación PHP.'),
 ('T02', 'E01', 'PHP como un Lenguaje de Desarrollo de Aplicaciones Web', 'Cuando se trabaja con sitios web, es importante tener un conocimiento profundo de los fundamentos de la programación del navegador Web con HTML y HTTP manipular las transacciones a través de las cabeceras y cookies. Además, esta sección del examen abarca también la persistencia de datos a través de múltiples peticiones a través de sesiones.'),
 ('T03', 'E01', 'Trabajando con Matrices', 'Las matrices son, tal vez, el aspecto más poderoso de PHP. El grado de libertad es este lenguaje permite a los desarrolladores la creación y manipulación de matrices no es nada menos que espectacular: no sólo se puede mezclar y combinar diferentes tipos de claves y valores, sino que se pueden realizar todo tipo de operaciones con ellos, desde la clasificación desde dividir a combinar. Con grandes poderes, sin embargo, vienen grandes responsabilidades. La otra cara de una gama tan amplia de posibilidades (sin doble sentido) es que el conocimiento es la mejor manera de manipular matrices no siempre es una tarea fácil. Esta parte del examen se centra en su capacidad para comprender el funcionamiento de las matrices, no sólo desde un punto de vista teórico, sino también desde el práctico. Por lo tanto, le espera una gran cantidad de preguntas en las que te encontrarás frente a un breve guión, pidió que entender lo que está mal con él o lo que el resultado final será.'),
 ('T04', 'E01', 'Cadenas y Expresiones Regulares', 'Cadenas son navaja suiza de PHP, en particular si se tiene en cuenta el hecho de que la mayoría de scripts PHP se utilizan para servir páginas web, que son, en su mayor parte, no es más que las cadenas grandes. Saber utilizar este servicio en particular es, por lo tanto, una de las habilidades más fundamentales del desarrollador de PHP, ya que va a trabajar con ellos día tras día. Por suerte, su papel esencial en la vida de un script PHP se ha traducido en la manipulación de cadenas están haciendo excepcionalmente fácil por el equipo de desarrollo de PHP. Por lo tanto, una vez que pasas los primeros obstáculos, manipular cadenas se convierte en fácil, rápido y-hasta cierto punto-incluso divertido. Sin embargo, este aspecto particular de la programación de PHP está lejos de estar libre de obstáculos. Esta parte del examen pone a prueba su conocimiento de las cadenas, así como su conocimiento del cuerpo de las funciones que se utilizan para manipular. Además, te encontrarás frente con los conceptos básicos de este arte más voodoo de escribir expresiones regulares, que, a pesar de ser una herramienta sumamente útil, demasiado a menudo olvidadas por la mayoría de los desarrolladores.'),
 ('T05', 'E01', 'Manipulación de Archivos y el Sistema de Archivos', 'Aunque es posible que nunca piensan en la manipulación de archivos como los puntos fuertes de uno de PHP, en realidad es una herramienta muy útil para el desarrollador. Incluso si sólo se desarrolla sitios web, ser capaz de leer y escribir en un archivo puede llegar a ser una capacidad muy práctico. Después de todo, recuerda que, gracias a sus envolturas de flujo (cubierto en mayor detalle en el Capítulo 10), PHP hace posible abrir un archivo remoto y leer de ella-útil, por ejemplo, para incluir el contenido de un sitio de terceros. En un nivel más básico, sin embargo, la entrada / salida de archivos se pueden utilizar para multitud de tareas. Por ejemplo, es útil para leer e interpretar el contenido de un archivo con formato previo, como el que podría recibir de un proveedor de terceros enviarle contenido sindicado o para abrir y dar salida a los archivos binarios al explorador a través de las secuencias de comandos, para que pueda más estrechamente controlar el acceso a ellos. Sea cual sea el uso final, que se pondrá a prueba no sólo en los aspectos básicos de la apertura, el cierre y el acceso a los contenidos de un archivo, sino también en los aspectos fundamentales de manipulación de ficheros que son relevantes en un entorno multiproceso, tales como el bloqueo de archivos.'),
 ('T06', 'E01', 'Fecha y Gestión del Tiempo', 'CASI CADA SITIO WEB, en algún momento, tendrá que lidiar con fechas y horas. Si es necesario recoger las fechas de nacimiento de sus usuarios, o si usted necesita para registrar el momento en que una determinada operación se llevó a cabo, las funciones de fecha de PHP puede ayudarle en sus tareas. Sin embargo, la fecha / funciones de gestión del tiempo de PHP son cualquier cosa menos perfecto. El hecho de que se basan exclusivamente en el formato timestamp UNIX hace vulnerables a una serie de peligros de los cuales usted, como desarrollador, debe ser muy consciente con el fin de evitar la búsqueda mismo en posesión de muy malos datos. Al mismo tiempo, las fechas de la gestión en la Web se ha convertido en un asunto internacional. Como resultado, usted debería ser capaz de no sólo hacer frente a las diferentes zonas horarias, pero también con diferentes locales y su forma peculiar de información de la fecha de visualización. Esta sección del examen pone a prueba sus habilidades en todas las áreas antes mencionadas.'),
 ('T07', 'E01', 'Manejo y Manipulación del Correo Electrónico', '¿Dónde estaría el mundo sin e-mail? La comunicación electrónica ha hecho posible que la gente se quede más cerca, para que las empresas llevan a cabo sus negocios de manera más eficiente y, por desgracia, para los spammers para existir. Afortunadamente, usted no tiene que ser un spammer para disfrutar de un buen uso de las capacidades de correo de PHP. De hecho, si se ejecuta una tienda online o está escribiendo una aplicación de foro, usted encontrará que la posibilidad de enviar y manipular e-mail podría ser una parte esencial de su trabajo, ya que estar en contacto con los usuarios es tan importante. Programación de gestión de correo electrónico dentro de un script PHP es, al mismo tiempo, simple y desafiante. Si todo lo que quieres hacer es enviar un simple mensaje de correo electrónico de texto, la función de correo lo hará por usted. Es sólo cuando usted entra en los aspectos más complicados de mensajería electrónica, tales como el correo y los archivos adjuntos HTML-que tiene que ir más allá de los fundamentos y aprender funciona el correo electrónico de la forma.'),
 ('T08', 'E01', 'Programación de Bases de Datos con PHP', 'Si usted desarrolla sitios web de forma dinámica impulsada por las posibilidades de que usted no va a utilizar una base de datos son muy escasas. Sin embargo, a pesar del hecho de que no se puede hacer sin en cualquier entorno web moderna, muchos desarrolladores sólo tienen una comprensión rudimentaria de cómo funcionan las bases de datos y qué técnicas de bases de datos son adecuados. Porque PHP soporta tantos tipos diferentes de bases de datos y el examen de Zend es sólo acerca de ser un buen programador de PHP, usted encontrará que las preguntas de esta sección del examen no están dirigidos a cualquier sistema de gestión de base de datos concreta después de todo, la mayoría de las empresas que comercializan DBMS, incluyendo MySQL AB, tienen sus propios programas de certificación. En su lugar, se le interrogó sobre su conocimiento de la teoría de bases de datos y programación, lo que es sumamente importante, no importa qué DBMS que utiliza para sus aplicaciones.'),
 ('T09', 'E01', 'Stream y Programación en Red', 'CUANDO SE TRATA DE tratar con fuentes de datos externas, PHP proporciona una gran cantidad de formas diferentes de comunicarse con el mundo exterior. Estos incluyen instalaciones como acceso a archivos y gestión del correo electrónico. Sin embargo, estos dos sistemas son altamente especializados: ofertas de gestión de archivos con el sistema de archivos local, mientras que las funciones de correo electrónico sólo manejan un aspecto muy limitado de las comunicaciones de red. Para las necesidades más generales, PHP proporciona una utilidad llamada arroyos, que simplemente permiten tratar cualquier origen de datos como un archivo. Por ejemplo, los "fopen wrappers" que se pueden utilizar para cargar el contenido de una página web externa en el script son un excelente ejemplo de las corrientes: te dejan usar las funciones de archivo para extraer contenido de Internet. Por último, las operaciones más complejas pueden ser manejados a través de la programación del zócalo, que permite el más alto nivel de flexibilidad posible. Esta sección del examen pone a prueba su conocimiento de estas dos áreas de especialización.'),
 ('T10', 'E01', 'Escribir Aplicaciones PHP Seguras', 'La desventaja de de entrada baja barrera de PHP es el hecho de que el lenguaje es tan poderoso y fácil de usar que es fácil olvidar la importancia de la seguridad en el contexto de las aplicaciones web. A pesar de su importancia, la seguridad es, posiblemente, el aspecto más-a menudo ignorada de un sitio web. Aún más, lamentablemente, hay muchas maneras de poner en peligro un sistema desde el interior que uno tiene que estar constantemente al acecho de posibles problemas. Cuando las PYME estaban diseñando el examen, una gran cantidad de énfasis fue puesto en la seguridad, no sólo para las cuestiones directamente relacionadas con él, pero sobre todas las cuestiones que se refieren a cada tema. Escribir una aplicación segura comienza con buen conocimiento de algunas técnicas fundamentales, que se encuentra cubierto en este capítulo.'),
 ('T11', 'E01', 'Depuración de Código y Gestión del Rendimiento', 'No importa la experiencia de un desarrollador que eres, o lo mucho que te esfuerces, las aplicaciones tendrán errores. Ellos son una parte inevitable de la vida, como la muerte y los impuestos (aunque por lo general-aunque no siempre-menos peligrosa una costosa que la segunda). Ser capaz de identificar los errores es el primer paso para resolverlos. De hecho, muchos desarrolladores pasan horas y horas mirando fijamente a una página de código sólo porque sus aplicaciones no tienen una buena capacidad de control de errores en el primer lugar. Haciendo caso omiso de este aspecto de la programación es un poco como la esperanza de que los errores no vuelvan a ocurrir: sin esperanza! Las preguntas del examen de Zend que se centran en torno a esta zona de la prueba de conocimientos básicos sobre temas relacionados con la depuración y optimización de código, así como en las instalaciones que PHP proporciona para este propósito específico.');

CREATE TABLE pregunta (
 id_examen CHAR(3) NOT NULL,
 id_tema CHAR(3) NOT NULL,
 id_pregunta CHAR(3) NOT NULL,
 id_dificultad SMALLINT NOT NULL REFERENCES dificultad (id) ON DELETE CASCADE ON UPDATE CASCADE,
 enunciado TEXT NOT NULL,
 respuesta TEXT NOT NULL,
 FOREIGN KEY (id_examen, id_tema) REFERENCES tema (id_examen, id_tema) ON DELETE CASCADE ON UPDATE CASCADE,
 PRIMARY KEY (id_examen, id_tema, id_pregunta)
);

INSERT INTO pregunta (id_pregunta, id_tema, id_examen, id_dificultad, enunciado, respuesta) VALUES
 ('P01', 'T01', 'E01', 0, '¿Cuál de las siguientes afirmaciones es correcta? ', 'La respuesta más acertada es "PHP es un lenguaje interpretado basado en el motor de Zend normalmente incrustado en el código HTML. Como tal, se utiliza principalmente para desarrollar documentos HTML, aunque puede ser utilizado sólo como bien para desarrollar otros tipos de documentos, tales como XML".'),
 ('P02', 'T01', 'E01', 0, '¿Cuál de las siguientes etiquetas no es una forma válida de empezar y terminar un bloque de código PHP? ', 'Las etiquetas como [code][phpasp] [/phpasp][/code] y [code][phpecho] [/phpecho][/code] no se utilizan con frecuencia en la programación PHP, pero son formas válidas para delimitar un bloque de código PHP. La etiqueta [code]<! !>[/code] es inválida. Tenga en cuenta, en todo caso, que algunas de estas formas de etiquetas no siempre están disponibles.'),
 ('P03', 'T01', 'E01', 0, '¿Cuál de las siguientes opciones es un código inválido de PHP? ', 'La variables de PHP siempre inician con un signo de dólar y son un secuencia de caracteres y numeros del alfábeto Latino más el caracter de subrayado. [code]${MiVar}[/code] es nombre de variable válida. Sin embargo no pueden iniciar con números, haciendo inválido la declaración de la variable [code]$10_otro[/code].'),
 ('P04', 'T01', 'E01', 1, '¿Qué imprime el siguiente segmento de código?
<?php

define(''MIVALOR'', ''10'');
$myarray[10] = ''Perro'';
$myarray[] = ''Humano'';
$myarray[''MIVALOR''] = ''Gato'';
$myarray[''Perro''] = ''Gato'';

echo ''El valor es: '', $miArray[MIVALOR], PHP_EOL;

?>', 'The important thing to note here is that the [code]$myarray[/code] array''s key value is being referenced without quotes around it. Because of this, the key being accessed is not the [code]myvalue[/code] string but the value represented by the myvalue constant. Hence, it is equivalent to accessing [code]$myarray[10][/code], which is Dog.'),
 ('P05', 'T01', 'E01', 0, '¿Cuál es la diferencia entre [code]print()[/code] y [code]echo()[/code]?', 'Even though print() and echo() are essentially interchangeable most of the time, there is a substantial difference between them. While print() behaves like a function with its own return value (although it is a language construct), echo() is actually a language construct that has no return value and cannot, therefore, be used in an expression. Thus, Answer A is correct.'),
 ('P06', 'T01', 'E01', 2, '¿Cuál es la salida del código siguiente?
<?php
$a = 10;
$b = 20;
$c = 4;
$d = 8;
$e = 1.0;

$f = $c + $d * 2;
$g = $f % 20;
$h = $b - $a + $c + 2;
$i = $h >> $c;
$j = $j * $e;

print $j;
?>', 'Other than the simple math, the % operator is a modulus, which returns whatever the remainder would be if its two operands were divided. The << operator is a left-shift operator, which effectively multiplies an integer number by powers of two. Finally, the ultimate answer is multiplied by a floating point and, therefore, its type changes accordingly. However, the result is still printed out without any fractional part, since the latter is nil.'),
 ('P07', 'T01', 'E01', 1, '¿Qué valores deben ser asignados a las variables [code]$a[/code], [code]$b[/code] y [code]$c[/code] para que la siguiente secuencia de comandos imprima la cadena [code]¡Hola, mundo![/code]?
<?php

$string = "!Hola, mundo!";
$a = ?;
$b = ?;
$c = ?;

if ($a) {
    if ($b && !$c) {
        echo ''¡Adios mundo cruel!'';
    } else if (!$b && !$c) {
        echo ''Nada por aquí'';
    }
} else {
    if (!$b) {
        if (!$a && (!$b && $c)) {
            echo ''!Hola, mundo!'';
        } else {
            echo ''Adios mundo'';
        }
    } else {
        echo ''No exactamente.'';
    }
}

?>', 'Following the logic of the conditions, the only way to get to the Hello, World! string is in the else condition of the first if statement. Thus, $a must be False. Likewise, $b must be False. The final conditional relies on both previous conditions ($a and $b) being False, but insists that $c be True (Answer D).'),
 ('P08', 'T01', 'E01', 1, '¿Cuál es la salida del código siguiente?
<?php

$array = ''0123456789ABCDEFG'';

$s = '''';

for ($i = 1; $i < 50; $i++) {
    $s .= $array[rand(0, strlen($array) - 1)];
}

echo $s;

?>', 'The correct answer is C. As of PHP 4.2.0, there is no need to initialize the random number generator using srand() unless a specific sequence of pseudorandom numbers is sought. Besides, even if the random number generator had not been seeded, the script would have still outputted 49 pseudo-random characters—the same ones every time. The $array variable, though a string, can be accessed as an array, in which case the individual characters corresponding to the numeric index used will be returned. Finally, the for loop starts from 1 and continues until $i is less than 50—for a total of 49 times.'),
 ('P09', 'T01', 'E01', 0, '¿Qué sentencia del lenguaje puede representar mejor la siguiente serie de condicionales [code]if[/code]?
<?php

if ($a == ''a'') {
    algunaFuncion();
} else if ($a == ''b'') {
    otraFuncion();
} else if ($a == ''c'') {
    haceAlgo();
} else {
    noHaceNada();
}

?>', 'A series of if...else if code blocks checking for a single condition as above is a perfect place to use a switch statement:
<?php
switch($a) {
    case ''a'':
        algunaFuncion();
        break;
    case ''b'':
        otraFuncion();
        break;
    case ''c'':
        haceAlgo();
        break;
    default:
        noHaceNada();
}
?>
Because there is a catch-all else condition, a default case must also be provided for that situation. Answer E is correct.'),
 ('P10', 'T01', 'E01', 1, '¿Cuál es la mejor manera de recorrer el vector [code]$miArray[/code], asumiendo que usted desea modificar el valor de cada elemento?
<?php

$miArray = array(''Mi Cadena'', ''Otra Cadena'', ''¡Hola, Mamá!'');

?>', 'Normally, the foreach statement is the most appropriate construct for iterating through an
array. However, because we are being asked to modify each element in the array, this option
is not available, since foreach works on a copy of the array and would therefore result in
added overhead. Although a while loop or a do...while loop might work, because the array is
sequentially indexed a for statement is best suited for the task, making Answer A correct:
<?php
$miArray = array(''Mi Cadena'', ''Otra Cadena'', ''¡Hola, Mamá!'');
for ($i = 0; $i < count($miArray); $i++) {
    $miArray[$i] .= " ($i)";
}
?>'),
 ('P11', 'T01', 'E01', 2, '¿Qué debe ir en el segmento comentado para producir la salida de la siguiente matriz?
[br][br][b]Salida:[/b][pre]Array
{
    [0] => 1
    [1] => 2
    [2] => 4
    [3] => 8
    [4] => 16
    [5] => 32
    [6] => 64
    [7] => 128
    [8] => 256
    [9] => 512
}[/pre]
[b]Código:[/b]<?php

define(''DETENTE_EN'', 1024);

$resultado = array();

/* Código faltante */
{
    $resultado[] = $idx;
}

print_r($resultado);

?>', 'As it is only possible to add a single line of code to the segment provided, the only statement that makes sense is a for loop, making the choice either C or D. In order to select the for loop that actually produces the correct result, we must first of all revisit its structural elements. In PHP, for loops are declared as follows: for (<init statement>; <continue until statement>; <iteration statement>) where the <init statement> is executed prior to entering the loop. The for loop then begins executing the code within its code block until the <continue until> statement evaluates to False. Every time an iteration of the loop is completed, the <iteration statement> is executed. Applying this to our code segment, the correct for statement is: [code]for ($idx = 1; $idx < DETENTE_EN; $idx *= 2)[/code]'),
 ('P12', 'T01', 'E01', 1, 'Elija la declaración apropiada de la función para una "definición por usuario" para la función [code]es_bisiesto()[/code]. Asuma que, si no ingresa un valor, la función [code]is_leap[/code] utiliza el año [code]2000[/code] como valor por defecto:
<?php

/* Declare aquí la función */
{
    return !($anio % 4) && (($anio % 100) || !($anio % 400));
}
var_dump(es_bisiesto(1987)); /* Imprime false */
var_dump(es_bisiesto());     /* Imprime true */

?>', 'Of the five options, only two are valid PHP function declarations (A and D). Of these two declarations, only one will provide a default parameter if none is passed—Answer A.'),
 ('P13', 'T01', 'E01', 1, '¿Cuál es el valor que se muestra cuando se ejecuta lo siguiente?[br][br]Suponga que el código se ejecuta utilizando la siguiente URL: [code]testscript.php?c=25[/code]
<?php

function proceso($c, $d = 25)
{
    global $e;
    $retval = $c + $d - $_GET[''c''] - $e;
    return $retval;
}

$e = 10;
echo proceso(5);

?>', 'This question is designed to test your knowledge of how PHP scopes variables when dealing with functions. Specifically, you must understand how the global statement works to bring global variables into the local scope, and the scope-less nature of superglobal arrays such as [code]$_GET[/code], [code]$_POST[/code], [code]$_COOKIE[/code], [code]$_REQUEST[/code] and others. In this case, the math works out to [code]5 + 25 - 25 - 10[/code], which is [code]-5[/code], or answer B.'),
 ('P14', 'T01', 'E01', 2, '¿Cuáles son los índices enteros faltantes? Cada [code]?[/code] del código siguiente representa un índice entero en contra de la matriz [code]$s[/code]. Con el fin de mostrar la cadena [code]¡Hola, mundo![/code] cuando se ejecute.[br][br]<?php

function mifuncion($a, $b = true)
{
    if ($a && !$b) {
        echo "¡Hola, Mundo!\n";
    }
}

$s = array(
    0 => ''mi'',
    1 => ''llamada'',
    2 => ''$function'',
    3 => '' '',
    4 => ''funcion'',
    5 => ''$a'',
    6 => ''$b'',
    7 => ''a'',
    8 => ''b'',
    9 => ''''
);

$a = true;
$b = false;

/* Groupo A */
$name = $s[?] . $s[?] . $s[?] . $s[?] . $s[?] . $s[?];

/* Groupo B */
$name(${$s[?]}, ${$s[?]});

?>', 'Functions can be called dynamically by appending parentheses (as well as any parameter needed) to a variable containing the name of the function to call. Thus, for Group A the appropriate index combination is 0, 4, 9, 9, 9, 9, which evaluates to the string myfunction. The parameters, on the other hand, are evaluated as variables dynamically using the [code]${}[/code] construct. This means the appropriate indexes for group B are 7 and 8, which evaluate to [code]${''a''}[/code] and [code]${''b''}-meaning[/code] the variables $a and $b respectively. Therefore, the correct answer is D.'),
 ('P15', 'T01', 'E01', 0, '¿Qué sentencia se utiliza para la inclusión de un segmento de código PHP en tiempo de ejecución y compilación?', 'In recent versions of PHP, the only difference between require() (or require_once()) and include() (or include_once()) is in the fact that, while the former will only throw a warning and allow the script to continue its execution if the include file is not found, the latter will throw an error and halt the script. Therefore, Answer E is correct.'),
 ('P16', 'T01', 'E01', 0, '¿Bajo qué circunstancias es imposible asignar un valor por defecto a un parámetro mientras se declara una función?', 'When a parameter is declared as being passed by reference you cannot specify a default value for it, since the interpreter will expect a variable that can be modified from within the function itself. Therefore, Answer C is correct.'),
 ('P17', 'T01', 'E01', 0, '¿Qué operador devuelve verdadero si cualquiera de sus operandos se puede evaluar como verdadero, pero no ambos?', 'La respuesta correcta es el operador de "O Exclusivo / Exclusive-Or" (XOR).'),
 ('P18', 'T01', 'E01', 0, '¿Cómo es el operador identidad [code]===[/code] al comparar dos valores?', 'El operador de identidad trabaja primero comparando los tipos de ambos operandos, y luego sus valores. Si existe alguna diferencia en alguno de los caso devuelve falso.'),
 ('P19', 'T01', 'E01', 2, '¿Cuál de las siguientes expresiones multiplica el valor de la variable entera [code]$a[/code] por 4? (Elija dos opciones)', 'La función [code]pow[/code] se utiliza para calcular 2² que corresponde a 4. Y el operador "bit a bit" de "desplazamiento a izquierda" se utiliza para cambiar el valor de [code]$a[/code] por dos bits a la izquierda, lo que corresponde a una multiplicación por 4.'),
 ('P20', 'T01', 'E01', 0, '¿Cómo puede un script de llegar a una terminación limpia?', 'Un script no necesariamente termina cuando se llega al final del archivo que no sea el principal, por lo que el "actual" archivo puede ser incluido externamente. En cuanto a PHP y Apache se son interrumpidos, difícilmente pueden ser consideradas maneras "limpias" de terminar un "script".'),
 ('P01', 'T02', 'E01', 0, 'How are session variables accessed?', 'Although session data can be accessed using the global variables if the register_globals INI setting is turned on, the exam uses a version of PHP configured using the default php.ini file found in the official PHP distribution. In recent versions of PHP, the register_globals setting is turned off by default because of its serious security implications. As a result, Answer E is correct.'),
 ('P02', 'T02', 'E01', 0, 'What function causes the following header to be added to your server''s output?', 'Clearly, this question refers to the setcookie or setrawcookie functions, although the header function could be used as well.'),
 ('P03', 'T02', 'E01', 0, 'Bajo circuntancias normales e ignorando cualquier fallo en el navegador puede un cookie ser accedido desde un dominio diferente al que fue asignado?', 'Browsers simply do not allow an HTTP transaction that takes place on one domain to set cookies for another domain. Doing otherwise would present clear security implications: for example, a malicious page on one domain could overwrite your session ID for another domain and force you to use another session to which a third party has access without your knowledge.'),
 ('P04', 'T02', 'E01', 0, 'How can the [code]index.php[/code] script access the email form element of the following HTML form?
[pre][code]
<form action="index.php" method="post">
    <input type="text" name="email" />
</form>
[/code][/pre]', 'Since the form’s method is post, the script will only be able to read the value through the
$_POST and $_REQUEST superglobal arrays. The element’s name (email) is used as the key for the
value in the array and, therefore, Answers B and D are correct. Note that, although perfectly
valid from a logical perspective, the use of $_REQUEST should be discouraged because of
potential security implications.'),
 ('P05', 'T02', 'E01', 0, 'What will be the net effect of running the following script on the [code]$s[/code] string? <?php
$s = ''<p>Hello</p>'';
$ss = htmlentities($s);
echo $s;
?>', 'This question tests nothing about your knowledge of HTML encoding—and everything
about your ability to properly interpret code. The $s function is left unaltered by the call to
htmlentities(), which returns the modified string so that it can be assigned to $ss. Therefore,
Answers B and D are correct. If you’re wondering whether this is an unfair “trick” question,
do keep in mind that, often, the ability to find and resolve bugs revolves around discovering
little mistakes like this one.'),
 ('P06', 'T02', 'E01', 0, 'If no expiration time is explicitly set for a cookie, what happens to it?', ''),
 ('P07', 'T02', 'E01', 0, 'Consider the following form and subsequent script. What will the script print out if the user types the word "php" and "prueba" in the two text boxes respectively?[pre][code]<form action="index.php" method="post">
    <input type="text" name="element[]">
    <input type="text" name="element[]">
</form>[/code][/pre]', '');

CREATE TABLE opcion (
 id_examen CHAR(3) NOT NULL,
 id_tema CHAR(3) NOT NULL,
 id_pregunta CHAR(3) NOT NULL,
 id_opcion CHAR NOT NULL,
 nombre TEXT NOT NULL,
 es_correcta BOOLEAN NOT NULL DEFAULT FALSE,
 FOREIGN KEY (id_examen, id_tema, id_pregunta) REFERENCES pregunta (id_examen, id_tema, id_pregunta) ON DELETE CASCADE ON UPDATE CASCADE,
 PRIMARY KEY (id_examen, id_tema, id_pregunta, id_opcion)
);

INSERT INTO opcion (id_opcion, id_pregunta, id_tema, id_examen, es_correcta, nombre) VALUES
 ('A', 'P01', 'T01', 'E01', FALSE, 'PHP es un lenguaje de programación dinámico basado en el motor de PHP. Se utiliza principalmente para desarrollar contenido dinámico para la Base de Datos, aunque también puede ser usado para generar documentos HTML (entre otros).'),
 ('B', 'P01', 'T01', 'E01', FALSE, 'PHP es un lenguaje de programación embebido basado en el motor de Zend. Se utiliza principalmente para desarrollar contenido HTML dinámico, aunque también puede ser usado para generar documentos XML (entre otros).'),
 ('C', 'P01', 'T01', 'E01', FALSE, 'PHP es un lenguaje de programación originado de Perl basado en el motor de PHP. Se utiliza principalmente para desarrollar contenido Web dinámico, aunque también puede ser usado para generar documentos estáticos (entre otros).'),
 ('D', 'P01', 'T01', 'E01', FALSE, 'PHP es un lenguaje de programación embebido basado en el motor de Zend. Se utiliza principalmente para desarrollar contenido dinámico Docbook, aunque también puede ser usado para generar documentos desde MySQL (entre otros).'),
 ('E', 'P01', 'T01', 'E01', FALSE, 'PHP es un lenguaje de programación originario de Zend basado en el motor de PHP. Se utiliza principalmente para desarrollar contenido dinámico de imágenes, aunque también puede ser usado para generar documentos HTML (entre otros).'),
 ('A', 'P02', 'T01', 'E01', FALSE, '[code]<% %>[/code]'),
 ('B', 'P02', 'T01', 'E01', FALSE, '[code]<? ?>[/code]'),
 ('C', 'P02', 'T01', 'E01', FALSE, '[code]<?= ?>[/code]'),
 ('D', 'P02', 'T01', 'E01', FALSE, '[code]<! !>[/code]'),
 ('E', 'P02', 'T01', 'E01', FALSE, '[code]<?php ?>[/code]'),
 ('A', 'P03', 'T01', 'E01', FALSE, '[code]$_10[/code]'),
 ('B', 'P03', 'T01', 'E01', FALSE, '[code]${"MiVar"}[/code]'),
 ('C', 'P03', 'T01', 'E01', FALSE, '[code]&$algo[/code]'),
 ('D', 'P03', 'T01', 'E01', FALSE, '[code]$10_otro[/code]'),
 ('E', 'P03', 'T01', 'E01', FALSE, '[code]$aVaRi[/code]'),
 ('A', 'P04', 'T01', 'E01', FALSE, '[code]El valor es: Perro[/code]'),
 ('B', 'P04', 'T01', 'E01', FALSE, '[code]El valor es: Humano[/code]'),
 ('C', 'P04', 'T01', 'E01', FALSE, '[code]El valor es: Gato[/code]'),
 ('D', 'P04', 'T01', 'E01', FALSE, '[code]El valor es: 10[/code]'),
 ('A', 'P05', 'T01', 'E01', FALSE, '[code]print()[/code] se puede usar como parte de una expresión, mientras que [code]echo()[/code] no puede.'),
 ('B', 'P05', 'T01', 'E01', FALSE, '[code]echo()[/code] sxore puede usar como parte de una expresión, mientras que [code]print()[/code] no puede.'),
 ('C', 'P05', 'T01', 'E01', FALSE, '[code]echo()[/code] puede ser utilizado en la versión CLI de PHP, mientras que [code]print()[/code] no puede.'),
 ('D', 'P05', 'T01', 'E01', FALSE, '[code]print()[/code] puede ser utilizado en la versión CLI de PHP, mientras que [code]echo()[/code] no puede.'),
 ('E', 'P05', 'T01', 'E01', FALSE, 'No hay ninguna diferencia, ambas funciones imprimen texto.'),
 ('A', 'P06', 'T01', 'E01', FALSE, '[code]128[/code]'),
 ('B', 'P06', 'T01', 'E01', FALSE, '[code]42[/code]'),
 ('C', 'P06', 'T01', 'E01', FALSE, '[code]242.0[/code]'),
 ('D', 'P06', 'T01', 'E01', FALSE, '[code]256[/code]'),
 ('E', 'P06', 'T01', 'E01', FALSE, '[code]342[/code]'),
 ('A', 'P07', 'T01', 'E01', FALSE, '[code]false[/code], [code]true[/code] y [code]false[/code].'),
 ('B', 'P07', 'T01', 'E01', FALSE, '[code]true[/code], [code]true[/code] y [code]false[/code].'),
 ('C', 'P07', 'T01', 'E01', FALSE, '[code]false[/code], [code]true[/code] y [code]true[/code].'),
 ('D', 'P07', 'T01', 'E01', FALSE, '[code]false[/code], [code]false[/code] y [code]true[/code].'),
 ('E', 'P07', 'T01', 'E01', FALSE, '[code]true[/code], [code]true[/code] y [code]true[/code].'),
 ('A', 'P08', 'T01', 'E01', FALSE, 'Una cadena de 50 caracteres aleatorios.'),
 ('B', 'P08', 'T01', 'E01', FALSE, 'Una cadena de 49 copias del mismo carácter, ya que el generador de números aleatorios no se ha inicializado.'),
 ('C', 'P08', 'T01', 'E01', FALSE, 'Una cadena de 49 caracteres aleatorios.'),
 ('D', 'P08', 'T01', 'E01', FALSE, 'Nada, porque la variable [code]$array[/code] no es una matriz.'),
 ('E', 'P08', 'T01', 'E01', FALSE, 'Una cadena de 49 caracteres con la letra "G".'),
 ('A', 'P09', 'T01', 'E01', FALSE, 'Una sentencia [code]switch[/code] sin un caso por defecto.'),
 ('B', 'P09', 'T01', 'E01', FALSE, 'Una llamada a una función recursiva.'),
 ('C', 'P09', 'T01', 'E01', FALSE, 'Una sentencia [code]while[/code].'),
 ('D', 'P09', 'T01', 'E01', FALSE, 'Está es la única representación de esta lógica.'),
 ('E', 'P09', 'T01', 'E01', FALSE, 'Una sentencia [code]switch[/code] utilizando un caso por defecto.'),
 ('A', 'P10', 'T01', 'E01', FALSE, 'Usando un bucle [code]for[/code].'),
 ('B', 'P10', 'T01', 'E01', FALSE, 'El uso de un bucle [code]foreach[/code].'),
 ('C', 'P10', 'T01', 'E01', FALSE, 'El uso de un bucle [code]while[/code].'),
 ('D', 'P10', 'T01', 'E01', FALSE, 'El uso de un bucle [code]do..while[/code].'),
 ('E', 'P10', 'T01', 'E01', FALSE, 'No hay manera de lograr este objetivo'),
 ('A', 'P11', 'T01', 'E01', FALSE, '[code]foreach ($result as $key => $val)[/code]'),
 ('B', 'P11', 'T01', 'E01', FALSE, '[code]while ($idx *= 2)[/code]'),
 ('C', 'P11', 'T01', 'E01', FALSE, '[code]for ($idx = 1; $idx < DETENTE_EN; $idx *= 2)[/code]'),
 ('D', 'P11', 'T01', 'E01', FALSE, '[code]for ($idx *= 2; DETENTE_EN >= $idx; $idx = 0)[/code]'),
 ('E', 'P11', 'T01', 'E01', FALSE, '[code]while ($idx < DETENTE_EN) do $idx *= 2[/code]'),
 ('A', 'P12', 'T01', 'E01', FALSE, '[code]function es_bisiesto($anio = 2000)[/code]'),
 ('B', 'P12', 'T01', 'E01', FALSE, '[code]es_bisiesto($anio default 2000)[/code]'),
 ('C', 'P12', 'T01', 'E01', FALSE, '[code]function es_bisiesto($anio default 2000)[/code]'),
 ('D', 'P12', 'T01', 'E01', FALSE, '[code]function es_bisiesto($anio)[/phpinline]'),
 ('E', 'P12', 'T01', 'E01', FALSE, '[code]function es_bisiesto(2000 = $anio)[/code]'),
 ('A', 'P13', 'T01', 'E01', FALSE, '[code]25[/code]'),
 ('B', 'P13', 'T01', 'E01', FALSE, '[code]-5[/code]'),
 ('C', 'P13', 'T01', 'E01', FALSE, '[code]10[/code]'),
 ('D', 'P13', 'T01', 'E01', FALSE, '[code]5[/code]'),
 ('E', 'P13', 'T01', 'E01', FALSE, '[code]0[/code]'),
 ('A', 'P14', 'T01', 'E01', FALSE, '[code]Grupo A: 4,3,0,4,9,9 y Grupo B: 7,8[/code]'),
 ('B', 'P14', 'T01', 'E01', FALSE, '[code]Grupo A: 1,3,0,4,9,9 y Grupo B: 7,6[/code]'),
 ('C', 'P14', 'T01', 'E01', FALSE, '[code]Grupo A: 1,3,2,3,0,4 y Grupo B: 5,8[/code]'),
 ('D', 'P14', 'T01', 'E01', TRUE, '[code]Grupo A: 0,4,9,9,9,9 y Grupo B: 7,8[/code]'),
 ('E', 'P14', 'T01', 'E01', FALSE, '[code]Grupo A: 4,3,0,4,9,9 y Grupo B: 7,8[/code]'),
 ('A', 'P15', 'T01', 'E01', FALSE, '[code]include_once[/code] e [code]include[/code]'),
 ('B', 'P15', 'T01', 'E01', FALSE, '[code]require[/code] e [code]include[/code]'),
 ('C', 'P15', 'T01', 'E01', FALSE, '[code]require_once[/code] e [code]include[/code]'),
 ('D', 'P15', 'T01', 'E01', FALSE, '[code]include[/code] e [code]require[/code]'),
 ('E', 'P15', 'T01', 'E01', FALSE, 'Todas las demás respuestas son correctas.'),
 ('A', 'P16', 'T01', 'E01', FALSE, 'Cuando el parámetro es booleano.'),
 ('B', 'P16', 'T01', 'E01', FALSE, 'Cuando la función se declara como un miembro de una clase.'),
 ('C', 'P16', 'T01', 'E01', FALSE, 'Cuando el parámetro se declara como pasado por referencia.'),
 ('D', 'P16', 'T01', 'E01', FALSE, 'Cuando la función contiene sólo un parámetro.'),
 ('E', 'P16', 'T01', 'E01', FALSE, 'Nunca.'),
 ('A', 'P17', 'T01', 'E01', FALSE, '[code]& (AND)[/code]'),
 ('B', 'P17', 'T01', 'E01', FALSE, '[code]| (OR)[/code]'),
 ('C', 'P17', 'T01', 'E01', FALSE, '[code]^ (XOR)[/code]'),
 ('D', 'P17', 'T01', 'E01', FALSE, '[code]~ (NOT)[/code]'),
 ('A', 'P18', 'T01', 'E01', FALSE, 'Las convierte en un tipo común de datos compatible y luego compara los valores resultantes.'),
 ('B', 'P18', 'T01', 'E01', FALSE, 'Devuelve verdadero sólo sí ambas son del mismo tipo y valor.'),
 ('C', 'P18', 'T01', 'E01', FALSE, 'Si los dos valores son cadenas, se realiza una comparación léxica.'),
 ('D', 'P18', 'T01', 'E01', FALSE, 'Basa su comparación de la función C [code]strcmp[/code] exclusivamente.'),
 ('E', 'P18', 'T01', 'E01', FALSE, 'Se convierte ambos valores a cadenas y las compara.'),
 ('A', 'P19', 'T01', 'E01', FALSE, '[code]$a *= pow(2, 2) >> 2;[/code]'),
 ('B', 'P19', 'T01', 'E01', FALSE, '[code]$a *= pow(2, 2) << 2;[/code]'),
 ('C', 'P19', 'T01', 'E01', FALSE, '[code]$a *= pow(2, 2) * 2;[/code]'),
 ('D', 'P19', 'T01', 'E01', FALSE, '[code]$a += $a + $a;[/code]'),
 ('E', 'P19', 'T01', 'E01', FALSE, 'Ninguna de las opciones.'),
 ('A', 'P20', 'T01', 'E01', FALSE, 'Cuando [code]exit()[/code] es invocada.'),
 ('B', 'P20', 'T01', 'E01', FALSE, 'Cuando la ejecución alcanza el final del archivo actual.'),
 ('C', 'P20', 'T01', 'E01', FALSE, 'Cuando se interrumpe por un error de PHP.'),
 ('D', 'P20', 'T01', 'E01', FALSE, 'Cuando Apache termina debido a un problema en el sistema.'),
 ('A', 'P01', 'T02', 'E01', FALSE, 'Through [code]$_GET[/code]'),
 ('B', 'P01', 'T02', 'E01', FALSE, 'Through [code]$_POST[/code]'),
 ('C', 'P01', 'T02', 'E01', FALSE, 'Through [code]$_REQUEST[/code]'),
 ('D', 'P01', 'T02', 'E01', FALSE, 'Through [code]Through global variables[/code]'),
 ('E', 'P01', 'T02', 'E01', FALSE, 'Through [code]Ninguna de las opciones[/code]'),
 ('A', 'P02', 'T02', 'E01', FALSE, '[code]setcookie()[/code], [code]setrawcookie()[/code], o [code]header()[/code]'),
 ('B', 'P02', 'T02', 'E01', FALSE, '[code]setcookie()[/code] y [code]setrawcookie()[/code]'),
 ('C', 'P02', 'T02', 'E01', FALSE, '[code]cookie()[/code]'),
 ('D', 'P02', 'T02', 'E01', FALSE, '[code]set_apache_headers()[/code]'),
 ('E', 'P02', 'T02', 'E01', FALSE, '[code]addcookie()[/code] o [code]addrawcookie()[/code]'),
 ('F', 'P02', 'T02', 'E01', FALSE, '[code]set_ini()[/code]'),
 ('A', 'P03', 'T02', 'E01', FALSE, 'Por una consulta al encabezado [code]HTTP_REMOTE_COOKIE[/code].'),
 ('B', 'P03', 'T02', 'E01', TRUE, 'Esto no puede hacerse.'),
 ('C', 'P03', 'T02', 'E01', FALSE, 'By setting a different domain when calling [code]setcookie()[/code]'),
 ('D', 'P03', 'T02', 'E01', FALSE, 'By sending an additional request to the browser'),
 ('E', 'P03', 'T02', 'E01', FALSE, 'By using Javascript to send the cookie as part of the URL'),
 ('A', 'P04', 'T02', 'E01', FALSE, '[code]$_GET[''email''][/code]'),
 ('B', 'P04', 'T02', 'E01', TRUE, '[code]$_POST[''email''][/code] o [code]$_REQUEST[''email''][/code]'),
 ('C', 'P04', 'T02', 'E01', FALSE, '[code]$_SESSION[''text''][/code]'),
 ('D', 'P04', 'T02', 'E01', FALSE, '[code]$_POST[''email_0''][/code]'),
 ('E', 'P04', 'T02', 'E01', FALSE, '[code]$_POST[''text''][/code]'),
 ('A', 'P05', 'T02', 'E01', FALSE, 'The string will become longer because the angular brackets will be converted to their HTML meta character equivalents'),
 ('B', 'P05', 'T02', 'E01', FALSE, 'La cadena permanece sin cambios'),
 ('C', 'P05', 'T02', 'E01', FALSE, 'If the string is printed to a browser, the angular brackets will be visible'),
 ('D', 'P05', 'T02', 'E01', FALSE, 'If the string is printed to a browser, the angular brackets will not be visible and it will be interpreted as HTML'),
 ('E', 'P05', 'T02', 'E01', FALSE, 'La cadena es destruida por la llamar a [code]htmlentities()[/code].'),
 ('A', 'P06', 'T02', 'E01', FALSE, 'It expires right away'),
 ('B', 'P06', 'T02', 'E01', FALSE, 'It never expires'),
 ('C', 'P06', 'T02', 'E01', FALSE, 'It is not set'),
 ('D', 'P06', 'T02', 'E01', FALSE, 'It expires at the end of the user''s browser session'),
 ('E', 'P06', 'T02', 'E01', FALSE, 'It expires only, if the script doesn''t create a server-side session'),
 ('A', 'P07', 'T02', 'E01', FALSE, 'Nada'),
 ('B', 'P07', 'T02', 'E01', FALSE, 'Array'),
 ('C', 'P07', 'T02', 'E01', FALSE, 'Imprime una nota (notice)'),
 ('D', 'P07', 'T02', 'E01', FALSE, 'phpgrandioso'),
 ('E', 'P07', 'T02', 'E01', FALSE, 'grandiosophp');

CREATE TABLE intento (
 id SERIAL PRIMARY KEY,
 id_dificultad SMALLINT NOT NULL REFERENCES dificultad (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_persona NUMERIC(20) NOT NULL REFERENCES persona (id) ON DELETE CASCADE ON UPDATE CASCADE,
 sesion CHAR(26) NOT NULL,
 es_abandono BOOLEAN NOT NULL DEFAULT FALSE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);

CREATE TABLE evaluacion (
 id_intento INTEGER NOT NULL REFERENCES intento (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_examen CHAR(3) NOT NULL,
 id_tema CHAR(3) NOT NULL,
 id_pregunta CHAR(3) NOT NULL,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP,
 PRIMARY KEY (id_intento, id_examen, id_tema, id_pregunta),
 FOREIGN KEY (id_examen, id_tema, id_pregunta) REFERENCES pregunta (id_examen, id_tema, id_pregunta) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE respuesta (
 id_intento INTEGER NOT NULL,
 id_examen CHAR(3) NOT NULL,
 id_tema CHAR(3) NOT NULL,
 id_pregunta CHAR(3) NOT NULL,
 id_opcion CHAR NOT NULL,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP,
 PRIMARY KEY (id_intento, id_examen, id_tema, id_pregunta, id_opcion),
 FOREIGN KEY (id_intento, id_examen, id_tema, id_pregunta) REFERENCES evaluacion (id_intento, id_examen, id_tema, id_pregunta) ON DELETE CASCADE ON UPDATE CASCADE,
 FOREIGN KEY (id_examen, id_tema, id_pregunta, id_opcion) REFERENCES opcion (id_examen, id_tema, id_pregunta, id_opcion) ON DELETE CASCADE ON UPDATE CASCADE
);
<?php
// recogemos la información de los botones de tipo radio
$p1 = $_REQUEST['p1'];
$p2 = $_REQUEST['p2'];
$p3 = $_REQUEST['p3'];
$p4 = $_REQUEST['p4'];
$p5 = $_REQUEST['p5'];
echo $p1," - ",$p2," - ",$p3," - ",$p4," - ",$p5;

$usuario = $_REQUEST['usuario'];

//guardar respuestas
$sql="REPLACE respuestas "
        . "(id_user, id_pregunta, id_respuesta) "
        . "VALUES "
        . "($usuario,1,$p1) "
        . "($usuario,2,$p2) "
        . "($usuario,3,$p3) "
        . "($usuario,4,$p4) ";
//Conectarnos a la base de datos
$conexion = new mysqli('localhost', 'root', 'ausias', 'Practica cuestionario');
if ($conexion->connect_errno) {
    die("Error de conexion: $conexion->connect_error");
   $conexion->query($sql);
}

if (empty($p1)) $p1=0; //si no hay valor le ponemos 0
if (empty($p2)) $p2=0;
if (empty($p3)) $p3=0;
if (empty($p4)) $p4=0;

//obtener las respuesas correctas y erróneas 
$sql = "SELECT preguntas.opcion_correcta as a, respuestas.respuesta as b "
        . "FROM preguntas, respuestas "
        . "WHERE respuestas.id_user= $usuario AND preguntas.id=respuestas.id_pregunta ";
echo $sql . "<br>";
$result = $conexion->query($sql);
$blanco = 0;
$aciertos = 0;
$errores = 0;
while ($fila = $result->fetch_assoc()) {
    if ($fila['b'] == 0) {
        $blanco++;
    } elseif ($fila['b'] == $fila['a']) {
        $aciertos++;
    } else {
        $errores++;
    }
    echo $fila['a'],"->",$fila['b'],"<br>";
}
echo " Has tenido $aciertos aciertos, $errores errores ";
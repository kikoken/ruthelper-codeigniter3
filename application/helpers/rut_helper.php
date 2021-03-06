<?php
/**
* Limpiamos formato de rut ingresado
* eliminamos puntos, guiones y espacio
* se deja en minúscula todo el registro
* @param  string $rut dato de rut chileno
* @return string rut chileno limpiado
*/
function cleanRut($rut){
    return strtolower(preg_replace('/[^0-9kK]/','',mysql_real_escape_string($rut)));
}

/** valida_rut($r)
* No importa si el RUT esta con punto (.), comas (,),
* guion (-),k (minuscula | mayuscula) da igual.
* ----------------------------------------------------
* @param $r string cadena de rut chileno
* @return boolean
*/
function isRut($r){
    if((!$r) || (is_array($r)))
    return false; /* Hace falta el rut */

    if(!$r = preg_replace('|[^0-9kK]|i', '', $r))
        return false; /* Era código basura */

    if(!((strlen($r) == 8) or (strlen($r) == 9)))
        return false; /* La cantidad de carácteres no es válida. */

    $v = strtoupper(substr($r, -1));
    if(!$r = substr($r, 0, -1))
        return false;

    if(!((int)$r > 0))
        return false; /* No es un valor numérico */

    $x = 2; $s = 0;
    for($i = (strlen($r) - 1); $i >= 0; $i--){
        if($x > 7)
            $x = 2;
        $s += ($r[$i] * $x);
        $x++;
    }
    $dv=11-($s % 11);
    if($dv == 10)
        $dv = 'K';
    if($dv == 11)
        $dv = '0';
    if($dv == $v)
        return true;
    return false;    
}

/**
 * Formatea rut agregando puntos y guión
 * @param  string $rut rut chileno
 * @return string      devuelve rut formateado
 */
function formatRut($rut) {
    //invertimos rut
    $rutinvertido   = strrev($rut);
    $rutformato     ='';

    //recorremos rut invertido y agregamos guión y puntos
    for($i=0;$i<strlen($rutinvertido);$i++){
        $rutformato .= ($i==0)?$rutinvertido[$i].'-':$rutinvertido[$i];
        $rutformato .= ($i==3 || $i==6)?'.':'';
    }
    return strrev($rutformato);
}
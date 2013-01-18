<?php

/**
 * Converte a Data de mysql para formato brasileiro e vice-versa
 * @param String $data Data a ser convertida
 * @return String Data convertida de mysql para brasileiro
 */
function convertDate($data) {
    $exp = explode('-', $data);
    $exp = array_reverse($exp);
    $date = implode('-', $exp);
    return $date;
}
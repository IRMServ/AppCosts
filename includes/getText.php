<?php

function getTexto(mysqli $conn, $property,$id)
{
    $query = "select {$property} from textos_responsoci where idtextos_responsoci = {$id}";    
    $q = $conn->query($query);    
    $r = $q->fetch_object();
    return $r->$property;
}
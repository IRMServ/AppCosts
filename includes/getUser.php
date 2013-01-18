<?php

function getUser(mysqli $conn, $property,$id)
{
    $query = "select {$property} from users where idusers = {$id}";    
    $q = $conn->query($query);    
    $r = $q->fetch_object();
    return $r->$property;
}
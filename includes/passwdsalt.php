<?php

/**
 * Tempera uma senha com um <i>salt</i> aleatório
 * @param String $passwd Senha a ser temperada
 * @return String Senha temperada
 */
function setPasswdSalt($passwd) {
    $pass = md5(uniqid(time()));
    $newpass = md5($passwd . $pass);
    return $pass . ':' . $newpass;
}

/**
 * Compara a senha em texto com a senha criptografada no banco e retorna verdadeiro ou falso.
 * @param String $pass A senha em text/plain
 * @param String $cript A senha criptografada
 * @return Boolean
 */
function getPasswdSalt($pass, $cript) {
    list($salt, $passcript) = explode(':', $cript);
    return md5($pass . $salt) === $passcript ? true : false;
}
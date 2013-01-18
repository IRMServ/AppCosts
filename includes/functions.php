<?php   






/**
 * Testa se um valor existe ou não. Uso para textfields.
 * @param String $value Um valor para ser testado
 * @return String O valor a ser testado
 */
function returnvalue($value) {
    return isset($value) || !empty($value) || !is_null($value) ? $value : '';
}

/**
 * Testa se um valor existe, se exitir ele retorna checked. Uso para checkboxes.
 * @param Mixed $value Valor a ser testado
 * @return String Parâmetro checked
 */
function returnchecked($value) {

    return $value == 1 ? "checked='checked'" : '';
}

/**
 * Testa se um valor é nulo, vazio, se existe é igual ao selecionado. Se todas as condições foram aceitas, será selecionad o valor no combobox.
 * @param String $value Valor a ser testado
 * @param string $needle Valor selecionado
 * @return string
 */
function returnselected($value, $needle) {
    return (isset($value) || !empty($value) || !is_null($value)) && ($value == $needle) ? "selected='selected'" : '';
}

//echo setPasswdSalt('admin');
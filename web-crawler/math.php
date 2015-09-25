<?php

function mod($a, $n) {
    return ($a % $n) + ($a < 0 ? $n : 0);
}

/**
 *
 * @Find position of Nth occurance of search string
 *
 * @param string $search The search string
 *
 * @param string $string The string to seach
 *
 * @param int $offset The Nth occurance of string
 *
 * @return int or false if not found
 *
 */
function strposOffset($search, $string, $offset)
{
    /*** explode the string ***/
    $arr = explode($search, $string);
    /*** check the search is not out of bounds ***/
    switch( $offset )
    {
        case $offset == 0:
        return false;
        break;
    
        case $offset > max(array_keys($arr)):
        return false;
        break;

        default:
        return strlen(implode($search, array_slice($arr, 0, $offset)));
    }
}

?>
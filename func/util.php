<?php

function condAssign($array, $index, $default=NULL)
{
    return (isset($array[$index])) ? $array[$index] : $default;
}

?>
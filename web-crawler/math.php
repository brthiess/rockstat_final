<?php

function mod($a, $n) {
    return ($a % $n) + ($a < 0 ? $n : 0);
}

?>
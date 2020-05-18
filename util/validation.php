<?php
function is_present($value) {
    if (isset($value) && strlen($value) > 0) {
        return true;
    } else {
        return false;
    }
}

function is_valid_number($value, $min = NULL,
        $max = NULL, $required = true) {
    if ($required && !is_present($value)) { return false; }
    if (!is_numeric($value)) { return false; }
    if (isset($min) && $value < $min) {
        return false;
    }
    if (isset($max) && $value > $max) {
        return false;
    }
    return true;
}
?>
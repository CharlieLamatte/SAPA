<?php

function add(&$array, $label, $value) {
    $array['values'][] = $value;
    $array['labels'][] = $label;
}
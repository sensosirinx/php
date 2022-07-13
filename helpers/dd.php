<?php

// A simple die and dump function for debugging.
function dd($obj)
{
    echo '<pre>';
    var_dump($obj);
    echo '</pre>';
    die();
}

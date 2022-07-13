<?php

/**
 * @param string $viewName
 * @param array $context
 * @return int
 */
function view(string $viewName, array $context=[]): int
{
    extract($context);
    $filePath = str_replace('.', '/', $viewName);
    $path = "../views/".$filePath.".php";
    return require ($path);
}

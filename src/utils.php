<?php

/* Wordpress doesn't like autoloaders, create our custom one. */
function qbWpListsLoadClass($className, $create = false, $arg = null)
{
    $fullClassName = 'qbWpLists' . $className;

    if (!class_exists($fullClassName)) {
        require_once QBWPLISTS_DIR . 'classes/' . $className . '.class.php';
    }

    return $create ? new $fullClassName($arg) : true;
}

/* Simplify getting templates */
function qbWpListsFindTemplate($template)
{
    return QBWPLISTS_DIR . 'templates/' . $template . '.template.php';
}

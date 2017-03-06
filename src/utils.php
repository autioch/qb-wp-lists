<?php

/* Wordpress doesn't like autoloaders, create our custom one. */
function qbWpListsLoadClass($pathArray, $className, $create = false, $arg = null)
{
    echo '<pre>';
    echo '                        ',  print_r($pathArray, true);
    echo '</pre>';
    echo '<pre>';
    echo '                        ',  $className;
    echo '</pre>';
    echo '<pre>';
    echo QBWPLISTS_DIR . join(DIRECTORY_SEPARATOR, $pathArray) . DIRECTORY_SEPARATOR . $className . '.class.php';
    echo '</pre>';
    $fullClassName = 'qbWpLists' . $className;

    if (!class_exists($fullClassName)) {
        require_once QBWPLISTS_DIR . join(DIRECTORY_SEPARATOR, $pathArray) . DIRECTORY_SEPARATOR . $className . '.class.php';
    }

    return $create ? new $fullClassName($arg) : true;
}

/* Simplify getting templates */
function qbWpListsFindTemplate($template)
{
    return QBWPLISTS_DIR . 'templates' . DIRECTORY_SEPARATOR . $template . '.template.php';
}

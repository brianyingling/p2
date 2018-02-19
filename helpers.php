<?php
/**
 * Utility function to quickly dump data to the page
 * @param null $mixed
 */
function dump($mixed = null)
{
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
}
/**
 * Recursively escape HTML entities
 * @param null $mixed
 * @return array|string
 */
function sanitize($mixed = null)
{
    if (!is_array($mixed)) {
        return convertHtmlEntities($mixed);
    }
    function array_map_recursive($callback, $array)
    {
        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };
        return array_map($func, $array);
    }
    return array_map_recursive('convertHtmlEntities', $mixed);
}
/**
 * Escape HTML entities in the given String $str
 * @param $str
 * @return string
 */
function convertHtmlEntities($str)
{
    return htmlentities($str, ENT_QUOTES, "UTF-8");
}
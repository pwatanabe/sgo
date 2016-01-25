<?php
/**
 * @param string $query
 * @param mixed $arg1, $arg2...$argN
 *
 */
class Glob{
    
    function tratar_query($query)
    {
        global $QUERY;

        $args = func_get_args();
        $query = array_shift($args);

        foreach ($args as $key => $arg) {
            if (is_string($arg)) {
                $args[$key] = mysql_real_escape_string($arg);
            }
        }

        array_unshift($args, $query);
        $query = call_user_func_array('sprintf', $args);
        $QUERY = $query;

        return mysql_query($query);
    }
}
?>
<?php
// include_once(dirname(__FILE__)."/model/class_sql.php");
include_once("../model/class_config.php");

$config = new Config();

$_SESSION['temp_limit_atraso'] = $config->get_config('temp_limit_atraso', $_SESSION['id_empresa']);

?>
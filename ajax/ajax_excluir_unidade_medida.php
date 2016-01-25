<?php

include_once("../model/class_unidade_medida_bd.php");

$unidade = new Unidade_medida();

$unidade->ocultar_unidade_medida($_GET['id']);
?>

<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 15/11/12 #
require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/config.php");

$secondajax = post("secondajax");

$sql = new MySql();
$sql->Query("UPDATE visitas SET nrlasttajax='$secondajax' WHERE (txtip='".System::getIp()."' OR txtcookie='".System::getCookie()."' AND txtcookie <> '') AND dtcadastro LIKE '".date("Y-m-d")."%' AND nrfirstajax IS NOT NULL AND nrlasttajax IS NULL");
?>
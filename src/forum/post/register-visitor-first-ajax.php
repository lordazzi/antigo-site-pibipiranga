<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 15/11/12 #
require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/config.php");

$width = post("width");
$height = post("height");
$firstajax = post("firstajax");
$language = post("language");
$system = post("system");
$browser = post("browser");

$sql = new MySql();
$needupdate = $sql->Query("SELECT COUNT(idvisita) AS visitado FROM visitas WHERE (txtip='".System::getIp()."' OR txtcookie='".System::getCookie()."' AND txtcookie <> '') AND dtcadastro LIKE '".date("Y-m-d")."%' AND isjs=0");
$needupdate = (bool) $needupdate[0]["visitado"];
if ($needupdate == TRUE) {
	$sql->Query("UPDATE visitas SET isjs=1, nrscreenwidth='$width', nrscreenheight='$height', txtlanguage='$language', nrfirstajax='$firstajax', txtjssystem='$system', txtjsbrowser='$browser' WHERE (txtip='".System::getIp()."' OR txtcookie='".System::getCookie()."' AND txtcookie <> '') AND dtcadastro LIKE '".date("Y-m-d")."%'");
}

echo $sql->getJson(TRUE);
?>
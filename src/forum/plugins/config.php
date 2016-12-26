<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/php/functions.php");

function __autoload($class) {
	$class = strtolower($class);
	require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/php/class/$class.class.php");
}

$sql = new MySql();
//verificando se existe cookies vazios
$sql->Query("UPDATE txtcookie SET txtcookie='".System::saveCookie()."' WHERE txtip='".System::getIp()."' AND txtcookie='' AND dtcadastro LIKE '".date("Y-m-d")."%'");

//verificando se essa pessoa já visitou o site antes
$visita = $sql->Query("SELECT COUNT(idvisita) AS existe FROM visitas WHERE (txtip='".System::getIp()."' OR txtcookie='".System::getCookie()."') AND dtcadastro LIKE '".date("Y-m-d")."%'");
$visita = (bool) $visita[0]["existe"];
if ($visita == FALSE) {
	if ($_SESSION["id"] == FALSE) { $id = "NULL"; } else { $id = $_SESSION["id"]; }
	$sql->Query("INSERT INTO visitas (idaccount, txtip, txtcookie, txtbrowserstring, txtfrom, dtcadastro) VALUES ($id, '".System::getIp()."', '".System::saveCookie()."', '".System::getBrowseString()."', '".System::getComeFrom()."', NOW())");
}

?>
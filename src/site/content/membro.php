<?php
include("../conn.php");
if (!$_SESSION["S_logado"]) { header("index.php"); exit; }
include("../header.php");
include("../menu.php");
include("../leftbar.php");
//Se não existir um GET enviando o ID de quem é o perfil, ele mostra o perfil de quem está usando
if (!$_GET["id"] OR $_GET["id"] == $_SESSION["S_IDmembros"]) {
	$id = addslashes($_SESSION["S_IDmembros"]);
	$perfil_title = "Meu perfil";
}

else {
	$id = addslashes($_GET["id"]);
}

$data = mysql_query("SELECT * FROM membros WHERE IDmembros=$id");
$membro = mysql_fetch_array($data);
if ($perfil_title == "") {
	$perfil_title = "Perfil de ".$membro["apelido"];
}
?>
<h1><? echo $perfil_title; ?></h1>
<br />

<?

$perfil = str_replace("\'", "'", $membro["perfil"]);
$perfil = str_replace('\"', '"', $perfil);
$perfil = nl2br($perfil);
echo $perfil;

include("../rightbar.php");
include("../footer.php");
?>
<?php
include("../conn.php");
if (!$_SESSION["S_logado"]) { header("index.php"); exit; }
include("../header.php");
include("../menu.php");
include("../leftbar.php");

if ($_POST["salvar_config"]) {
	//Receber sempre notifica��o 
	if ($_POST["notifc_recebe_sempre"] == "on") {
		$notifc_recebe_sempre = 1;
	}
	
	else {
		$notifc_recebe_sempre = 0;
	}
	
	//Receber sempre notifica��o
	if ($_POST["notifc_like_sempre"] == "on") {
		$notifc_like_sempre = 1;
	}
	
	else {
		$notifc_like_sempre = 0;
	}
	
	//S� receber as notifica��es das fotos/videos que eu tiver comentado
	if ($_POST["notifc_recebe_meus"] == "on") {
		$notifc_recebe_meus = 1;
	}
	
	else {
		$notifc_recebe_meus = 0;
	}
	
	//Nunca receber notifica��o de nada
	if ($_POST["notifc_envia_nunca"] == "on") {
		$notifc_envia_nunca = 1;
	}
	
	else {
		$notifc_envia_nunca = 0;
	}
	
	mysql_query("UPDATE membros SET notifc_recebe_sempre=$notifc_recebe_sempre, notifc_like_sempre=$notifc_like_sempre, notifc_recebe_meus=$notifc_recebe_meus, notifc_envia_nunca=$notifc_envia_nunca WHERE IDmembros=".$_SESSION["S_IDmembros"]);
}

$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$_SESSION["S_IDmembros"]);
$configs = mysql_fetch_array($data);
?>
<h1>Minhas configra��es</h1>
<a href="novidades.php" class="estatuto" style="float: right;">Minhas novidades</a><br />
<br />
<form method="POST" action="">
	<table>
		<tr><td style="border: 1px solid #000000;"><input name="notifc_recebe_sempre" type="checkbox" <? if ($configs["notifc_recebe_sempre"] == 1) { echo " checked='checked' "; } ?> /> Receber notifica��o SEMPRE que alguma foto/v�deo for comentado.</td></tr>
		<tr><td style="border: 1px solid #000000;"><input name="notifc_like_sempre" type="checkbox" <? if ($configs["notifc_like_sempre"] == 1) { echo " checked='checked' "; } ?> /> Receber notifica��o SEMPRE que algu�m 'gostar' ou 'n�o gostar' de uma foto/v�deo</td></tr>
		<tr><td style="border: 1px solid #000000;"><input name="notifc_recebe_meus" type="checkbox"  <? if ($configs["notifc_recebe_meus"] == 1) { echo " checked='checked' "; } ?> /> S� receber notifica��es quando alguma coisa que eu participei (gostei, n�o gostei, comentei) for comentada.</td></tr>
		<tr><td style="border: 1px solid #000000;"><input name="notifc_envia_nunca" type="checkbox" <? if ($configs["notifc_envia_nunca"] == 1) { echo " checked='checked' "; } ?> /> Quando eu comentar alguma coisa no site, n�o enviar notifica��o para ningu�m.</td></tr>
	</table>
	<input name="salvar_config" style="cursor:pointer;" type="submit" value="Salvar" />
</form>
<?
include("../rightbar.php");
include("../footer.php");
?>
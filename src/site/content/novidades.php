<?php
include("../conn.php");
if (!$_SESSION["S_logado"]) { header("index.php"); exit; }
if ($_GET["sendme"]) {
	$data = mysql_query("SELECT * FROM membros_novidades WHERE IDnovidade=".addslashes($_GET["sendme"]));
	$sendme = mysql_fetch_array($data);
	mysql_query("DELETE FROM membros_novidades WHERE IDnovidade=".addslashes($_GET["sendme"]));
	header("location: ".$sendme["link"]);
	echo "
		<script type='text/javascript'>
			window.location.href = '".$sendme["link"]."';
		</script>
	";
	exit;
}
include("../header.php");
include("../menu.php");
include("../leftbar.php");
?>
<h1>Minhas novidades</h1>
<a href="novidades_config.php" class="estatuto" style="float: right;">Minhas configurações</a>
<br />
<br />
<?
$data = mysql_query("SELECT * FROM membros_novidades WHERE IDmembros_afetado=".$_SESSION["S_IDmembros"]);
while ($novidades = mysql_fetch_array($data)) {
	echo "<div style='cursor: pointer;' class='eventos' onClick=\" window.location.href = 'novidades.php?sendme=".$novidades["IDnovidade"]."'; \">".$novidades["content"]." (".bd2human($novidades["datahora"]).") </div>";
}

include("../rightbar.php");
include("../footer.php");
?>
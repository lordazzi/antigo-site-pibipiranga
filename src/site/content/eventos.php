<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

$data = mysql_query("SELECT * FROM eventos WHERE IDeventos=".addslashes($_GET["id"]));
$eventos = mysql_fetch_array($data);

echo "<h1>".$eventos["nome_L"]."</h1><br />";
echo "<b>Data: </b>".bd2human($eventos["data"])."<br />";
echo "<b>Horário: </b>".substr($eventos["inicio"], 0, 5)."<br />";
echo "<br />";
echo $eventos["content"];

include("../rightbar.php");
include("../footer.php");
?>
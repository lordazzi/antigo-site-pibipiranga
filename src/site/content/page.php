<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

$data = mysql_query("SELECT * FROM pages WHERE IDpage=".addslashes($_GET["id"]));
$eventos = mysql_fetch_array($data);

echo "<h1>".$eventos["titulo"]."</h1><br />";
echo $eventos["content"];

include("../rightbar.php");
include("../footer.php");
?>
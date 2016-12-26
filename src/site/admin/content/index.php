<?php 
include("../conn.php");
include("../header.php");
include("../menu.php");

echo "<h1 style='text-align: center;'>Instruções sobre a área administrativa</h1>";

for ($IntFor = 1; $IntFor <= ACESSOS_QTD; $IntFor++) {
	if ($_SESSION["S_poderes2"] OR $_SESSION["S_poderes".$IntFor]) { echo "<b>Acesso $IntFor: ".$ACESSOS[$IntFor][0]." ></b> ".$ACESSOS[$IntFor][1]."<br />"; }
}

include("../footer.php");
?>
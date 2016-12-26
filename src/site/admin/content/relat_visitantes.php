<?php 
  include("../conn.php");
  if (!$_SESSION["S_poderes7"]) { header("../../content"); exit; }
  include("../header.php");
  include("../menu.php");
?>

<!-- Importando calendario -->
<link rel="stylesheet" type="text/css" href="../../../plugins/js/calendario/jquery.click-calendario-1.0.css" />
<script type="text/javascript" src="../../../plugins/js/calendario/jquery.click-calendario-1.0.js"></script>

<!-- Mascara -->
<script type="text/javascript" src="../../../plugins/js/mascara/jquery.maskedinput-1.1.4.pack.js"/></script>

<script type="text/javascript">
	$(document).ready(function(){
		//mascara
		$("#primeira").mask("99/99/9999");
		$("#segunda").mask("99/99/9999");
		
		//calendario
		$('#primeira').focus(function(){
			$(this).calendario({
				target:'#primeira'
			});
		});
		
		$('#segunda').focus(function(){
			$(this).calendario({
				target:'#segunda'
			});
		});
		
	});
</script>

<form method="POST" action="" style="margin: 14px">
	<label for="primeira" style="margin: 1px;">Primeira data: <input name="primeira" id="primeira" type="text" /></label>
	<label for="segunda" style="margin: 1px;">Segunda data: <input name="segunda" id="segunda" type="text" /></label>
	<input type="submit" name="generate" style="margin: -28px 0 0 0" value="Gerar gráfico" />
</form>

<IMG src="visitas_img.php?d1=<? 

	if ($_POST) {
		echo human2bd($_POST["primeira"]);
	}

	else {
		echo nextday(date("Y-m-d"), -7, "Y-m-d"); 
	}

?>&d2=<?

	if ($_POST) {
		echo human2bd($_POST["segunda"]);
	}

	else {
		echo date("Y-m-d");
	}
?>" width="655" style="border-radius: 0 0 25px 0;" />
  
<?php
  include("../footer.php");
?>
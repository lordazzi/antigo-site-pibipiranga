<?
include("../conn.php");
include("../header.php");

if (!$_GET["ano"] AND !$_GET["alb"] AND !$_GET["f"]) {
	$data = mysql_query("SELECT DISTINCT SubString( dataevento, 1, 4 ) FROM albuns ORDER BY dataevento");
	while ($years_array = mysql_fetch_array($data)) {
		echo "
			<a href='fotos.php?ano=".$years_array["SubString( dataevento, 1, 4 )"]."'>
				<div class='button'>".$years_array["SubString( dataevento, 1, 4 )"]."</div>
			</a>";
	}
}

elseif ($_GET["alb"] AND $_GET["f"]) {
	//chamando o álbum e suas informações
	$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["alb"]));
	$album = mysql_fetch_array($data);

	//chamando a foto selecionada especifícamente
	$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"]));
	$foto_selecionada = mysql_fetch_array($data);

	$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDalbuns=".addslashes($_GET["alb"]));
	$whiles = 0; $me = 0; $antes = ""; $depois = "";
	while ($full = mysql_fetch_array($data))
	{
	  $array_fotos[$whiles] = $full["IDfotos"];
	  $whiles++;
	  if ($_GET["f"] == $full["IDfotos"]) { $me = $whiles; } //descobre que a variavel atual é a propria foto
	  elseif ($me == 0) { $antes = $full["IDfotos"]; } //pega a variavel que vem antes
	  elseif ($me != "" AND $depois == "") { $depois = $full["IDfotos"]; } //pega a variavel que vem depois
	}

	//Caso seja a primeira foto ou a ultima
	if ($antes == "") { $antes = $array_fotos[count($array_fotos) - 1]; }
	if ($depois == "") { $depois = $array_fotos[0]; }
	$height = getimagesize("../../arquivo/fotos_albuns/".$album["pasta"]."/".$foto_selecionada["fotos"]);
	$height = $height[0];
	if ($_GET["gira"]) {
		$style = " style='-webkit-transform: rotate(90deg); -moz-transform: rotate(90deg); -o-transform: rotate(90deg); height: ".$height."px; ";
	}
	
	
	echo "<h1>".$album["nome"]." ($me/$whiles)</h1>
	  
	  <a href='fotos.php?alb=".$_GET["alb"]."&f=".$antes."'>
		<div class='button' style='width: 30%; float: left; text-align: center;'> <<< </div>
	  </a>
	  
	  <a href='fotos.php?alb=".$_GET["alb"]."&f=".$depois."'>
		<div class='button' style='width: 30%; float: left; text-align: center;'> >>> </div>
	  </a>
	  
	  <IMG src='../../arquivo/fotos_albuns/".$album["pasta"]."/".$foto_selecionada["fotos"]."' width='100%'>
	  
	  <!-- <div class='button' onClick=\"window.location.href = 'fotos.php?alb=".$_GET["alb"]."&f=".$_GET["f"]."'; \">VER IMAGEM GRANDE</div> -->
	  <a href='fotos.php?alb=".$_GET["alb"]."&f=".$_GET["f"]."'>
		<div class='button'>SELECIONAR ANO</div>
	  </a>";
}

elseif ($_GET["ano"]) {
	$data = mysql_query("SELECT * FROM albuns WHERE dataevento LIKE '".addslashes($_GET["ano"])."%'");
	while ($albuns = mysql_fetch_array($data)) {
		echo "
			<a href='fotos.php?alb=".$albuns["IDalbuns"]."&f=".$albuns["fotocapa"]."'>
				<div class='button'>".$albuns["nome"]."</div>
			</a>";
	}
	echo "
		<a href='fotos.php'>
			<div class='button'>SELECIONAR ANO</div>
		</a>";
}
?>

<div class="button" onClick="window.location.href = 'index.php'; ">VOLTAR</div>

<?
include("../footer.php");
?>
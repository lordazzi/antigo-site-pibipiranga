<?php
include("../conn.php");
include("../header.php");
//Essa função faz com que a página não retorne com o scroll 0 depois de ter a página atualizada, mas no local onde estava antes
echo '
<script language="javascript">
function fixScroll(url) 
{
  var pos = window.scrollY;
  window.location.href = url+"&y="+pos;
}

</script>';
include("../menu.php");
include("../leftbar.php");

echo "<h1>Álbuns de fotos</h1>";

//verificando qual o ano que se deseja pegar os albuns
if ($_GET["a"]) { $ano = $_GET["a"]; }
else
{
  $whiles = 0;//o código busca albuns do (ano atual - $whiles), caso não tenha achado na tentativa anterior
  $runwhile = true; //corre o while até ele encontrar albuns de algum ano, dá erro se não existir nenhum album cadastrado no BD
  while ($runwhile == true)
  {
    $ano = date("Y") - $whiles;
    $data = mysql_query("SELECT * FROM albuns WHERE tipo='foto' AND dataevento LIKE '%".$ano."%'");
	if (mysql_num_rows($data) != 0) { $runwhile = false; }
	$whiles++;
  }
}

//CHAMANDO TODOS OS ÁLBUNS DO ANO EM QUESTÃO
$data = mysql_query("SELECT * FROM albuns WHERE tipo='foto' AND dataevento LIKE '%".$ano."%' ORDER BY dataevento");
while ($albfotos = mysql_fetch_array($data))
{
  $info = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".$albfotos["fotocapa"]);
  $fotocapa = mysql_fetch_array($info);
  echo "
  <a href='fotos.php?a=".$albfotos["IDalbuns"]."&f=".$fotocapa["IDfotos"]."' class='album'>
	<div>
		<IMG src='../../arquivo/fotos_albuns/".$albfotos["pasta"]."/".$fotocapa["fotos"]."' />
		<b>".$albfotos["nome"]."</b><br />
		".bd2human($albfotos["dataevento"])."
	</div>
  </a>";
}

//CRIA O MENU DE ANOS
$data = mysql_query("SELECT DISTINCT SubString( dataevento, 1, 4 ) FROM albuns WHERE tipo='foto' ORDER BY dataevento");
echo "<div id='menu_anos'>|";
while ($years_array = mysql_fetch_array($data)) {
	echo "<a href=\"javascript: fixScroll('albfotos.php?a=".$years_array["SubString( dataevento, 1, 4 )"]."')\">".$years_array["SubString( dataevento, 1, 4 )"]."</a> | ";
}
echo "</div>";

include("../rightbar.php");
include("../footer.php");
if ($_GET["y"]) { echo '<script language="javascript">window.scrollTo(0, '.$_GET["y"].');</script>'; }
?>
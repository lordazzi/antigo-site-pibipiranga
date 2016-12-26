<?
include("../conn.php");
include("../header.php");

 // AQUI EU CRIO UM GRANDE ARRAY COM TODAS AS INFORMAÇÕES QUE PODEM ENTRAR NA PARTE DE ATUALIZAÇÕES //
//Carrega os aniversariantes e colocando eles em ordem de data
$data = mysql_query("SELECT * FROM membros");
while ($membros = mysql_fetch_array($data))
{
  $d = substr($membros["nascimento"], 8, 2);
  $m = substr($membros["nascimento"], 5, 2);
  if (date("m") == 12 AND $m < 12) { $y = date("Y"); $y++; }
  else                             { $y = date("Y"); }
  
  $atual[$whiles] = $y . "-" . $m . "-" . $d . "A" . $membros["IDmembros"];
  $whiles++;
}

rsort($atual); //colocando em ordem

echo "<h1>Ultimos aniversariantes:</h1>";

$run = 0;
$nova = 0;
while($run < $whiles)
{
  $tabela = substr($atual[$run], 10, 1);
  $d = substr($atual[$run], 8, 2);
  $m = substr($atual[$run], 5, 2);
  $y = substr($atual[$run], 0, 4);
  
  if ($tabela == "A") //membros
  {
    $d = substr($atual[$run], 8, 2);
    $m = substr($atual[$run], 5, 2);
    for ($intdofor = 0; $intdofor < 7; $intdofor++) //Aniversariantes dos ultimos 7 dias, contando com hoje
    {
      $dia = date('d', mktime(0, 0, 0, date('m'), date('d') - $intdofor, date('Y')));
      $mes = date('m', mktime(0, 0, 0, date('m'), date('d') - $intdofor, date('Y')));
      $ano = date('y', mktime(0, 0, 0, date('m'), date('d') - $intdofor, date('Y')));
      if ($d == $dia AND $m == $mes)
      {
        $ID = substr($atual[$run], 11);
        $data = mysql_query("SELECT * FROM membros WHERE IDmembros=$ID");
        $membros = mysql_fetch_array($data);
        echo "Parabéns ".$membros["apelido"]."!!! [$dia/$m]<br />
		<br />";
      }
    }
  }
  $run++;
}
?>

<a href="index.php">
	<div class="button">VOLTAR</div>
</a>

  <!-- ANIVERSARIANTES DO MÊS -->
	<h1>Próximos aniversariantes:</h1>
	<?php
	  $hojeD = date("d");
	  $hojeM = date("m");
	  $hojeY = date("Y");
	  $data = mysql_query("SELECT apelido, nascimento FROM membros");

	  $whileint = 0;
	  while ($niversdb = mysql_fetch_array($data))
	  {
		//não alterar essa forma, se nao mexe na ordem alfabética, sequencia: MES DIA NOME
		if (substr($niversdb["nascimento"], 5, 2) == "01" AND $hojeM == 12) { $mes = "13"; } //para evitar erros no mês de dezembro, o mês de  janeiro é transformado em 13º mês
		elseif (substr($niversdb["nascimento"], 5, 2) == "02" AND $hojeM == 12) { $mes = "14"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "03" AND $hojeM == 12) { $mes = "15"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "04" AND $hojeM == 12) { $mes = "16"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "05" AND $hojeM == 12) { $mes = "17"; }
		else { $mes = substr($niversdb["nascimento"], 5, 2); }
		$niversarray[$whileint] = $mes . "/" . substr($niversdb["nascimento"], 8, 2) . "; apelido: " . $niversdb["apelido"]; //Ordem: mm/dd; apelido: xxx
		$whileint++;
	  }
	  sort($niversarray);
	  
	  $runarray = 0; $finishwhile = 0;
	  while ($finishwhile != 10) //mostra 10 aniversariantes
	  {
		$dia = substr($niversarray[$runarray], 3, 2);
		$mes = substr($niversarray[$runarray], 0, 2);
		$wherenome = strpos($niversarray[$runarray], "apelido: ");
		$wherenome = $comeca_nome + 15;
		$o_nome = substr($niversarray[$runarray], $wherenome);

		
		if (($hojeM < $mes) OR ($hojeM == $mes AND $hojeD <= $dia))
		{
		  if ($mes == "13") { $mes = "01"; }
		  if ($hojeM == $mes AND $hojeD == $dia) { echo "<p class='red'>"; }
		  else                                   { echo "<p>"; }
		  echo "<b>".upper_acento($o_nome)."</b> [" . $dia . "/" . $mes . "]<br /></p>";
		  $finishwhile++;
		}
		$runarray++;
	  }
	?>
		
	<a href="index.php">
		<div class="button">VOLTAR</div>
	</a>
	
<?
include("../footer.php");
?>
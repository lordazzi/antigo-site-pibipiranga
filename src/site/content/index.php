<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

{//CHAMANDO DO BANDO DE DADOS E COLOCANDO EM ORDEM
 // AQUI EU CRIO UM GRANDE ARRAY COM TODAS AS INFORMAÇÕES QUE PODEM ENTRAR NA PARTE DE ATUALIZAÇÕES //
$whiles = 0;
//Carrega s avisos e colocando eles em ordem de data
if ($_SESSION["situacao"] == "logado") { $data = mysql_query("SELECT * FROM avisos WHERE restrito=1 ORDER BY aparece"); }
else                                   { $data = mysql_query("SELECT * FROM avisos ORDER BY aparece");                  }
while ($avisos = mysql_fetch_array($data))
{
  $d = substr($avisos["aparece"], 8, 2);
  $m = substr($avisos["aparece"], 5, 2);
  $y = substr($avisos["aparece"], 0, 4);
  $atual[$whiles] = $y . "-" . $m . "-" . $d . "C" . $avisos["IDavisos"];
  $whiles++;
}

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

//Carrega os eventos e colocando eles em ordem de data
$data = mysql_query("SELECT * FROM eventos ORDER BY data");
while ($eventos = mysql_fetch_array($data))
{
  $d = substr($eventos["data"], 8, 2);
  $m = substr($eventos["data"], 5, 2);
  $y = substr($eventos["data"], 0, 4);
  $atual[$whiles] = $y . "-" . $m . "-" . $d . "B" . $eventos["IDeventos"];
  $whiles++;
  
  $ontem = date('Y-m-d', mktime(0, 0, 0, $m, $d - 1, $y));
  $atual[$whiles] = $ontem . "B" . $eventos["IDeventos"];
  $whiles++;
  
  $semana = date('Y-m-d', mktime(0, 0, 0, $m, $d - 7, $y));
  $atual[$whiles] = $semana . "B" . $eventos["IDeventos"];
  $whiles++;
}

rsort($atual); //colocando em ordem
}//fechando a região

echo "<h1>Mural</h1>";

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
        if ($escreve[$dia . $mes . $ano] != true)
        {
          echo "<h1>$d de " . numbtomonth($m) . "</h1>";
          $escreve[date($dia . $mes . $ano)] = true;

        /* Esse vetor é usado para saber se a data já foi escrita, com ele eu
         * tenho controle de tudo independente de em qual tabela esteja
         * registrado a informação; date("dmy") retorna como dia mes e ano tudo
         * junto em dois digitos cada, por exemplo: $escreve[170711] = true;
         */
        }
        $ID = substr($atual[$run], 11);
        $data = mysql_query("SELECT * FROM membros WHERE IDmembros=$ID");
        $membros = mysql_fetch_array($data);
        echo "<div class='niver'><span class='blind'>Parabéns " . $membros["apelido"] . "!!!</span></div><br />";
      }
    }
  }
  
  elseif ($tabela == "B") //eventos
  {
    //pega a data do evento
    $day = substr($atual[$run], 8, 2);
    $month = substr($atual[$run], 5, 2);
    $year = substr($atual[$run], 0, 4);
    $ID = substr($atual[$run], 11);

    $evento = $year . "-" . $month . "-" . $day;

    $data = mysql_query("SELECT * FROM eventos WHERE IDeventos=" . $ID);
    $eventos = mysql_fetch_array($data);
    $d = substr($eventos["data"], 8, 2);
    $m = substr($eventos["data"], 5, 2);
    $y = substr($eventos["data"], 0, 4);
    
    $hoje = $y . "-" . $m . "-" . $d;
    
    //descobre que dia cai o ontem do evento
    $ontem = date('Y-m-d', mktime(0, 0, 0, $m, $d - 1, $y));

    //descobre que dia cai uma semana antes do evento
    $semana = date('Y-m-d', mktime(0, 0, 0, $m, $d - 7, $y));
    
                      //NO CASO DE UM EVENTO NESSE MES //                                   //NO CASO DE UM EVENTO O MES PASSADO //                       // NO CASO DE UM EVENTO QUE OCORREU O ANO PASSADO //
    if (($day <= date("d") AND $month <= date("m") AND $year <= date("Y")) OR ($day > date("d") AND $month < date("m") AND $year <= date("Y")) OR ($day > date("d") AND $month == 12 AND date("m") == 1 AND ($year - 1) <= date("Y")))
    {
     $DezDias = date('Ymd', mktime(0, 0, 0, $month, $day + 10, $year));
     $hoje = date('Ymd');
      if ($DezDias >= $hoje)
      {
        if ($evento == $hoje)
        {
			if ($eventos["aviso_nodia"] == 1) {
				$year = substr($year, 2, 2);
				if ($escreve[$day . $month . $year] != true) {
					echo "<h1>$day de " . numbtomonth($month) . "</h1>";
					$escreve[date($day . $month . $year)] = true;
				}
				$h = substr($eventos["inicio"], 0, 2);
				$min = substr($eventos["inicio"], 3, 2);
				echo "<div class='eventos'>Hoje tem ".$eventos["nome_S"]."! Às ".$h."h".$min."!<br /> O que você ainda esta fazendo ai!?</div><br />";
			}
        }
    
        elseif ($evento == $ontem)
        {
			if ($eventos["aviso_dia_antes"] == 1) {
				$year = substr($year, 2, 2);
				if ($escreve[$day . $month . $year] != true) {
					echo "<h1>$day de " . numbtomonth($month) . "</h1>";
					$escreve[date($day . $month . $year)] = true;
				}
				$h = substr($eventos["inicio"], 0, 2);
				$min = substr($eventos["inicio"], 3, 2);
				echo "<div class='eventos'>Amanhã tem ".$eventos["nome_S"]."! Às " . $h ."h" . $min . "</div><br />";
			}
        }
    
        elseif ($evento == $semana)
        {
			if ($eventos["aviso_semana_antes"] == 1) {
				$year = substr($year, 2, 2);
				if ($escreve[$day . $month . $year] != true) {
					echo "<h1>$day de " . numbtomonth($month) . "</h1>";
					$escreve[date($day . $month . $year)] = true;
				}

				echo "<div class='eventos'>Daqui uma semana tem ".$eventos["nome_S"]."</div><br />";
			}
        }
      }
    }
  }
  
  elseif ($tabela == "C") //avisos
  {
  }
  $run++;
}

include("../rightbar.php");
include("../footer.php");
?>
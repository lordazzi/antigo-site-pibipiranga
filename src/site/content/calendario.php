<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

####################
#INICIO DAS FUNÇÕES#
####################

function addDay($M, $D, $A, $W)
{

//Equivalendo os valores numericos por valores  por palavras
if      ($M == 1)  { $mes_escrito = "janeiro"; }
else if ($M == 2)  { $mes_escrito = "fevereiro"; }
else if ($M == 3)  { $mes_escrito = "março"; }
else if ($M == 4)  { $mes_escrito = "abril"; }
else if ($M == 5)  { $mes_escrito = "maio"; }
else if ($M == 6)  { $mes_escrito = "junho"; }
else if ($M == 7)  { $mes_escrito = "julho"; }
else if ($M == 8)  { $mes_escrito = "agosto"; }
else if ($M == 9)  { $mes_escrito = "setembro"; }
else if ($M == 10) { $mes_escrito = "outubro"; }
else if ($M == 11) { $mes_escrito = "novembro"; }
else if ($M == 12) { $mes_escrito = "dezembro"; }

   $hoje_D = date("d");
   $hoje_M = date("m");
   $hoje_A = date("Y");

          //marca os dias com atividades com um fundo legal ;D
          $DATA = mysql_query("SELECT * FROM eventos");
          while($agenda = mysql_fetch_array($DATA))
          {
                 //Convertendo os dias e meses para inteiro e depois fazendo a converção de inteiro para string...
            $M = $M + 1 - 1;
            $D = $D + 1 - 1;
            if ($D < 10) {
              $D = $D + 1 - 1;
              $D = "0" . $D;
            }

            if ($M < 10) {
              $M = $M + 1 - 1;
              $M = "0" . $M;
            }

            //Procurando por eventos
            if ($agenda["data"] == $A . "-" . $M . "-" . $D)
            {
              $varial = $D % 2;

              if ($varial == 0)
              {
                if ($W == "sab")
                {
                  echo "<td class='sab_evt1'";
                }

                else if ($W == "dom")
                {
                  echo "<td class='dom_evt1'";
                }

                else
                {
                  echo "<td class='none_evt1'";
                }
              }
              
              else
              {
                if ($W == "sab")
                {
                  echo "<td class='sab_evt2'";
                }

                else if ($W == "dom")
                {
                  echo "<td class='dom_evt2'";
                }

                else
                {
                  echo "<td class='none_evt2'";
                }
              }
            }
          }

           //Ajustando os dias da semana para que eles fiquem personalizados
          if (($D < $hoje_D AND $M == $hoje_M AND $A == $hoje_A) OR ($M < $hoje_M AND $A == $hoje_A) OR ($A < $hoje_A))
          {
              if ($W == "sab")
              {
                 echo "<td class='pastsab'";
              }

              else if ($W == "dom")
              {
                 echo "<td class='pastdom'";
              }

              else
              {
                 echo "<td class='past'";
              }
           }

           else if ($D == $hoje_D AND $M == $hoje_M AND $A == $hoje_A)
           {
              echo "<td class='hoje'";
           }

           else if ($W == "sab")
           {
              echo "<td class='sab'";
           }

           else if ($W == "dom")
           {
              echo "<td class='dom'";
           }
           else
           {
              echo "<td class='none'";
           }


   //convertendo os número menores que 10 para string, para que assim possa colocar neles um 0 a esquerda como enfeite
   $D = $D + 1 - 1;
   if ($D < 10)
      $D = "0" . $D;

   echo ">$mes_escrito
            <div>$D</div>";

    $data = mysql_query("SELECT * FROM eventos WHERE data='$A-$M-$D'");
    if (mysql_num_rows($data) > 0)
    {
        echo "<div class='special'>
                <div>
                 <b>$D/$M/$A</b><br />";
        while($agenda = mysql_fetch_array($data))
        {
          if ($agenda["link_externo"]) { echo "<a href='" . $agenda["link_externo"] . "' target='_blank'>"; }
          else                         { echo "<a href='eventos.php?id=" . $agenda["IDeventos"] . "'>"; }
          echo $agenda['nome_S'] . "</a><br />";
        }
        echo "</div>
            </div>";
    }
    else
    {
    }

    echo "</td>";
}//final da function

###################
#FIM DAS FUNÇÕES#
##################
     echo "<h1>Calendario de eventos:</h1>";

     //Uma linha inicial na tabela mostrando qual coluna representa qual dia da semana
     echo "<table id='calendario'>
             <tr class='weekday'>
               <td>DOM</td>  <td>SEG</td>  <td>TER</td>  <td>QUA</td>  <td>QUI</td>  <td>SEX</td> <td>SAB</td>
             </tr>";

     //Vendo em que dia o calendario deve começar
     $start_dia = date("d") - date("w") - 7;  //Eu quero que mostre a ultima semana como decoração ;)
     $start_mes = date("m");
     $start_ano = date("Y");

        if ($start_dia <= 0)
        {
            //Se o dia for igual ou menor a zero o mês é trocado, e o dia "domingo" deverá ser encontrado novamente
            $start_mes = $start_mes - 1;
            if ($start_mes <= 0)
            {
                $start_mes = 12;
                $start_ano = $start_ano - 1;
            }

            //Agora ele vê quantos dias tem o mês para poder colocar ele no dia certo
            if ($start_mes == 1 OR $start_mes == 3 OR $start_mes == 5 OR $start_mes == 7 OR $start_mes == 8 OR $start_mes == 10 OR $start_mes == 12)
            {
                $start_dia = 31;
            }
            else if ($start_mes == 4 OR $start_mes == 6 OR $start_mes == 9 OR $start_mes == 11)
            {
                $start_dia = 30;
            }
            else if ($start_mes == 2)
            {
                $bissexto = date("L", mktime(0, 0, 0, 1, 1, $start_ano));
                if($bissexto == 0)
                   $start_dia = 28;
                else
                   $start_dia = 29;
           }
        }
        $weekday = date("w", mktime(0, 0, 0, $start_mes, $start_dia, $start_ano)); //Pegando o dia da semana do dia alterado pela sequencia anterior
        $start_dia = $start_dia - $weekday;

     $whiler = 0; //Essa variavel executa o while para que ele rode 42 vezes, que é o que eu preciso
     $table_system = 1; //Essa variavel é usada dentro do while com o intuido de montar a tabela da forma correta em seus TRs e TDs

     //Só para poder manter os valores iniciais armazenadas nas variaveis originais e enviar para o while valores que ele possa alterar para desenvolver o calendario... ;D
     $while_dia = $start_dia;
     $while_mes = $start_mes - 1 + 1;
     $while_ano = $start_ano;

     while ($whiler < 42)
     {
        if ($table_system == 1)
        {
           echo "<tr>";
           addDay($while_mes, $while_dia, $while_ano, "dom");
           $table_system = 2;
        }

        else if ($table_system == 7)
        {
           addDay($while_mes, $while_dia, $while_ano, "sab");
           echo "</tr>";
           $table_system = 1;
        }

        else
        {
           addDay($while_mes, $while_dia, $while_ano, "varial");
           $table_system = $table_system + 1;
        }

        //Aumentando um dia
        $while_dia = $while_dia + 1;
        $bissexto = date("L", mktime(0, 0, 0, 1, 1, $while_ano));

        //A verificação é sempre feita com um dia a mais
        if ($while_dia == 29 AND $bissexto == 0 AND $while_mes == 2)
        {
            $while_dia = 1;
            $while_mes = 3;
        }

        else if ($while_dia == 30 AND $bissexto == 1 AND $while_mes == 2)
        {
            $while_dia = 1;
            $while_mes = 3;
        }

        else if (($while_dia == 32 AND $while_mes == 1) OR ($while_dia == 32 AND $while_mes == 3) OR ($while_dia == 32 AND $while_mes == 5) OR ($while_dia == 32 AND $while_mes == 7) OR ($while_dia == 32 AND $while_mes == 8) OR ($while_dia == 32 AND $while_mes == 10) OR ($while_dia == 32 AND $while_mes == 12))
        {
            $while_dia = 1;
            $while_mes = $while_mes + 1;
        }

        else if (($while_dia == 31 AND $while_mes == 4) OR ($while_dia == 31 AND $while_mes == 6) OR ($while_dia == 31 AND $while_mes == 9) OR ($while_dia == 31 AND $while_mes == 11))
        {
            $while_dia = 1;
            $while_mes = $while_mes + 1;
        }

        if ($while_mes == 13)
        {
           $while_mes = 1;
           $while_ano = $while_ano + 1;
        }

         //Essa variavel faz com que o while seja concluido quando ela chegar em um determinado valor
        $whiler = $whiler + 1;
     }
     echo "</table>";

include("../rightbar.php");
include("../footer.php");
?>
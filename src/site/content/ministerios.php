<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

echo "<h1>Ministérios da igreja</h1>";

$data = mysql_query("SELECT * FROM ministerios ORDER BY posicao");
$style = 0;
while ($ministerios = mysql_fetch_array($data))
{
  if ($style == 0)
  {
    echo "
        <div class='minsA'>
           <img src='../../arquivo/fotos_ministerios/" . $ministerios["liderfoto"] . "'>
              <div>
			    <span class='blind'><b>" . $ministerios["ministerio"];
                if ($ministerios["ministerio"]) { echo "<br />"; } //Verificando se o ministério tem nome
                echo $ministerios["lidertitulo"] . " " . $ministerios["lidernome"] . "</b></span><br />
                <br />
                <span class='blind'>" . $ministerios["conteudo"] . "</span>
              </div>
            </td></tr>
          </table>
        </div>";
      $style = 1;
  }

  else
  {
    echo "
        <div class='minsB'>
          <div>
            <span class='blind'><b>" . $ministerios["ministerio"] . "<br />
            " . $ministerios["lidertitulo"] . " " . $ministerios["lidernome"] . "</b><span class='blind'><br />
            <br />
            <span class='blind'>" . $ministerios["conteudo"] . "</span>
          </div>
          <img src='../../arquivo/fotos_ministerios/" . $ministerios["liderfoto"] . "'>
        </div>";
      $style = 0;
  }
  echo "<br /><br />";
}

include("../rightbar.php");
include("../footer.php");
?>
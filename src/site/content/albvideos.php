<?php
include("../conn.php");
include("../header.php");
//Essa fun��o faz com que a p�gina n�o retorne com o scroll 0 depois de ter a p�gina atualizada, mas no local onde estava antes
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

echo "<h1>�lbuns de v�deos</h1>";

if (!$_GET["alb"]) {
	$data = mysql_query("SELECT * FROM albuns WHERE tipo='video' ORDER BY created");
	while ($albuns = mysql_fetch_array($data)) {
		echo "<div class='alb_video' onClick=\" window.location.href = '?alb=".$albuns["IDalbuns"]."'; \">".upper_acento($albuns["nome"])."</div>";
	}
}

else {
	//CHAMANDO TODOS OS V�DEOS DO ALB�M EM QUEST�O
	$data = mysql_query("SELECT * FROM albuns_videos WHERE IDalbuns=".addslashes($_GET["alb"]));
	while ($albvideos = mysql_fetch_array($data))
	{
	  $xml = youtube_xmlload($albvideos["urlid"]);
	  //titulo do v�deo
	  foreach($xml->title as $title) {
		$title = utf8_decode($title);
	  }
	  //descri��o do v�deo
	  foreach($xml->content as $content) {
		$content = utf8_decode($content);
	  }
	  echo "
	  <a href='video.php?v=".$albvideos["IDvideo"]."' class='album'>
		<div>
			<IMG src='http://i1.ytimg.com/vi/".$albvideos["urlid"]."/default.jpg' />
			<b>".$title."</b><br />
		</div>
	  </a>";
	}
}

include("../rightbar.php");
include("../footer.php");
if ($_GET["y"]) { echo '<script language="javascript">window.scrollTo(0, '.$_GET["y"].');</script>'; }
?>
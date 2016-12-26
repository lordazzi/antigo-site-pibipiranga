<?php
include("../conn.php");
include("../header.php");
include("../menu.php");
include("../leftbar.php");

$data = mysql_query("SELECT * FROM albuns_videos WHERE IDvideo=".addslashes($_GET["v"]));
$video = mysql_fetch_array($data);
$xml = youtube_xmlload($video["urlid"]);

//titulo do vídeo
foreach($xml->title as $title) {
	$title = utf8_decode($title);
}

//descrição do vídeo
foreach($xml->content as $content) {
	$content = utf8_decode(nl2br($content));
}

echo '
	<center>
		<h1>'.$title.'</h1>
		<iframe width="420" height="315" src="http://www.youtube.com/embed/'.$video["urlid"].'" frameborder="0" allowfullscreen></iframe><br />
		<br />
		'.$content.'
	</center>';

include("../rightbar.php");
include("../footer.php");
?>
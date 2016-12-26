<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 08/01/13 #
require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/config.php");

$content = get("?");
if ($content == "") {
	$content = urlCompile($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/css/style.css");
}
$content = file_get_contents(urlDecompile($content));

$less = new lessc();
echo $less->compile($content);
?>
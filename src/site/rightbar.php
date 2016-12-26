</div> <!-- fechando DIV CONTENT que foi aberta no arquivo leftbar.php -->

<script language="javascript" type="text/javascript">
	function myRealStyle(myId) {
		document.getElementById(myId).style.color = "#000000";
		document.getElementById(myId).style.fontStyle = "normal";
		if (document.getElementById(myId).value == "Envie uma sugestão sobre a igreja, sobre o site, sobre o que você desejar!") {
			document.getElementById(myId).value = "";
		}
	}

	function myEffectStyle(myId) {
		if (document.getElementById(myId).value == "") {
			document.getElementById(myId).style.color = "#999999";
			document.getElementById(myId).style.fontStyle = "italic";
			document.getElementById(myId).value = "Envie uma sugestão sobre a igreja, sobre o site, sobre o que você desejar!";
		}
	}
</script>
<?
if ($_POST["suggest"] AND $_SESSION["S_logado"]) {
	$ipuser = getip();
	$browser = getbrowser();
	$os = getos();
	$content = addslashes($_POST["content"]);
	if ($_POST["content"] != "") {
		mysql_query("INSERT INTO `logs` (`IDmembros`, `ipadress`, `browser`, `os`, `tipo`, `data`, `content`) VALUES ('".$_SESSION["S_IDmembros"]."', '$ipuser', '$browser', '$os', 'sugestão', '".date("Y-m-d h:s:i")."', '$content')");
	}
}
?>
<div id="rightbar">
	<? if ($_SESSION["S_logado"]) { ?>
	<h1>Sugestão</h1>
	<form method="POST" action="">
		<textarea name="content" id="js_content" onFocus='myRealStyle("js_content");' onBlur='myEffectStyle("js_content");'>Envie uma sugestão sobre a igreja, sobre o site, sobre o que você desejar!</textarea>
		<input name="suggest" type="submit" value="Sugerir" />
	</form>
	<br />
	<? } ?>
	<h1>Campanhas</h1>
		<IMG src="../../arquivo/banners_campanhas/oleo.png" width="150" style="cursor: pointer;" onClick=" window.location.href = 'page.php?id=1'; " />
</div>
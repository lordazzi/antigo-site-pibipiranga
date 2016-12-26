<?php 
  include("../conn.php");
  if (!$_SESSION["S_poderes19"]) { header("../../content"); exit; }
  include("../header.php");
  include("../menu.php");
?>
<h1 style='text-align: center;'>Importação de vídeos e criação de álbuns</h1>
<script type="text/javascript">
//ajeitando a escrita do usuário
function ajeita_nome() {
	if (document.getElementById("album_nome").value != ajeita(document.getElementById("album_nome").value)) {
		document.getElementById("album_nome").value = ajeita(document.getElementById("album_nome").value);
		final_select("album_nome");
	}
}

//trás o cursor para o final da textbox
function final_select(elemId, caretPos) {
	var elem = document.getElementById(elemId);
	var caretPos = document.getElementById(elemId).value.length;

	if(elem != null) {
		if(elem.createTextRange) {
			var range = elem.createTextRange();
			range.move('character', caretPos);
			range.select();
		}
		else {
			if(elem.selectionStart) {
				elem.focus();
				elem.setSelectionRange(caretPos, caretPos);
			}
			else
				elem.focus();
		}
	}
}
</script>
<?

//criando um novo álbum, via POST
if ($_POST["criar_album"]) {
	$ero = "";
	if ($_POST["album"] != "") {
		if (onlyletter($_POST["album"], "1234567890áéíóúãõçâêô-_")) {
			$album = ajeita($_POST["album"]);
			$album = addslashes($album);
		}
		
		else {
			$erro .= "Há caracteres inválidos no nome do álbum. ";
		}
	}
	
	else {
		$erro .= "Ops! Você esqueceu de digitar um nome para o seu álbum. ";
	}
	
	if ($erro == "") {
		mysql_query("INSERT INTO albuns (nome, tipo, created) VALUES ('$album', 'video', '".date("Y-m-d h:i:s")."')");
	}
	
	else {
		echo "
		<script type='text/javascript'>
			alert('$erro');
		</script>";
	}
}

//Importando o vídeo do youtube
elseif ($_POST["importer"]) {
	$erro = "";
	if ($urlid = youtube_isvalid($_POST["url"])) {
		$data = mysql_query("SELECT * FROM albuns_videos WHERE urlid=$urlid");
		if (mysql_num_rows($data)) {
			$erro .= "Esse vídeo já foi incluido. ";
		}
	}
	
	else {
		$erro .= "URL inválida. ";
	}
	
	if ($erro == "") {
		mysql_query("INSERT INTO albuns_videos (IDalbuns, urlid) VALUES (".addslashes($_GET["alb"]).", '".addslashes($urlid)."')");
	}
	
	else {
		echo "
		<script type='text/javascript'>
			alert('$erro');
		</script>";
	}
}

//Exibindo as informações do álbuns que podem ser escolhidos
$data = mysql_query("SELECT * FROM albuns WHERE tipo='video'");
echo "
<div class='subcontent' style='width: 200px;'>
	<table style='width: 100%;'>
		<tr>
			<td><b>Albuns</b></td>
		</tr>";
while ($albuns = mysql_fetch_array($data)) {
	echo "
		<tr>
			<td onClick=\" window.location.href='?alb=".$albuns["IDalbuns"]."'; \">".$albuns["nome"]."</td>
		</tr>";
}
echo "</table>
</div>
<br />";

echo "
<div class='subcontent' style='width: 135px;'>
	<form method='POST' action=''>
		Criar um novo álbum:<br />
		<input type='text' name='album' id='album_nome' onKeyUp='ajeita_nome()' maxlength='32' /> <input type='submit' name='criar_album' value='Criar' />
	</form>
</div>
";

//quando ele selecionar um album, aparece uma tela pedindo que ele coloque a URL para importar um vídeo para este álbum
if ($_GET["alb"]) {
	$data = mysql_query("SELECT * FROM albuns WHERE tipo='video' AND IDalbuns=".addslashes($_GET["alb"]));
	$video = mysql_fetch_array($data);
	?>
	<div id="css_back_black" style="display: block;">
		<div class="window" style="width: 175px;">
			<IMG src="../../../plugins/img/youtube.jpg" title="Você pode importar somente vídeos do youtube!" style="width: 170px;" />
			<? echo "<h1>Importando para:<br />".$video["nome"]."</h1>"; ?>
			<form method="POST" action="">
				<input name="url" type="text" /><br />
				<input name="importer" type="submit" value="Importar" />
				<input type="button" onClick="window.location.href='?'" value="Voltar" />
			</form>
		</div>
	</div>
	<?php
}
  include("../footer.php");
?>
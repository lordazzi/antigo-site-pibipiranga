<?php
include("../conn.php");
//Você só pode entrar se essas duas informações estiverem no link a = ALBUM, f = FOTO
if (!$_GET["f"] OR !$_GET["a"]) { exit(); }

//GOSTEI E NÃO GOSTEI
if ($_GET["like"] AND $_SESSION["S_logado"]) {
	//Só pode gostar dessa foto se você ainda não 'gostou' dela nem 'não gostou'
	$data_like = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND positivo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");
	$data_unlike = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND negativo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");
	//Se você nem 'não gostou' nem 'gostou' da foto ainda
	if (mysql_num_rows($data_like) == 0 AND mysql_num_rows($data_unlike) == 0) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$pos = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET positivo_index='".$pos["positivo_index"].$_SESSION["S_IDmembros"].".' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	//Se você somente não gostou da foto e quer alterar para gostou
	elseif (mysql_num_rows($data_like) == 0 AND mysql_num_rows($data_unlike) == 1) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$pos = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET negativo_index='".str_replace($_SESSION["S_IDmembros"].".", "", $pos["negativo_index"])."', positivo_index='".$pos["positivo_index"].$_SESSION["S_IDmembros"].".' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	//Se você gostou da foto antes, mas quer retirar isso agora
	elseif (mysql_num_rows($data_like) == 1 AND mysql_num_rows($data_unlike) == 0) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$pos = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET positivo_index='".str_replace($_SESSION["S_IDmembros"].".", "", $pos["positivo_index"])."' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["a"]));
	$album = mysql_fetch_array($data);
	
	$data = mysql_query("SELECT * FROM membros WHERE notifc_like_sempre=1");
	while ($membro = mysql_fetch_array($data)) {
		if ($membro["IDmembros"] != $_SESSION["S_IDmembros"]) {
			mysql_query("INSERT INTO membros_novidades (IDmembros_afetado, IDmembros_executor, datahora, link, content) VALUES (".$membro["IDmembros"].", ".$_SESSION["S_IDmembros"].", '".date("Y-m-d H:i:s")."', 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."', '".$_SESSION["S_apelido"]." gostou de uma foto do album do evento ".$album["nome"]."')");
		}
	}
	header("location: fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]);
	echo "
		<script type='text/javascript'>
			window.location.href = 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."';
		</script>
	";
	exit;
}

elseif ($_GET["unlike"] AND $_SESSION["S_logado"]) {
	//Só pode 'não gostar' dessa foto se você ainda não 'não gostou' dela nem 'gostou'
	$data_like = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND positivo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");
	$data_unlike = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND negativo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");
	//Se você nem 'não gostou' nem 'gostou' da foto ainda
	if (mysql_num_rows($data_like) == 0 AND mysql_num_rows($data_unlike) == 0) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$neg = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET negativo_index='".$neg["negativo_index"].$_SESSION["S_IDmembros"].".' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	//Se você somente não gostou da foto e quer alterar para gostou
	elseif (mysql_num_rows($data_unlike) == 0 AND mysql_num_rows($data_like) == 1) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$neg = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET positivo_index='".str_replace($_SESSION["S_IDmembros"].".", "", $neg["positivo_index"])."', negativo_index='".$neg["negativo_index"].$_SESSION["S_IDmembros"].".' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	//Se você gostou da foto antes, mas quer retirar isso agora
	elseif (mysql_num_rows($data_unlike) == 1 AND mysql_num_rows($data_like) == 0) {
		$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
		$neg = mysql_fetch_array($data);
		mysql_query("UPDATE albuns_fotos SET negativo_index='".str_replace($_SESSION["S_IDmembros"].".", "", $neg["negativo_index"])."' WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
	}
	
	$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["a"]));
	$album = mysql_fetch_array($data);
	
	$data = mysql_query("SELECT * FROM membros WHERE notifc_like_sempre=1");
	while ($membro = mysql_fetch_array($data)) {
		if ($membro["IDmembros"] != $_SESSION["S_IDmembros"]) {
			mysql_query("INSERT INTO membros_novidades (IDmembros_afetado, IDmembros_executor, datahora, link, content) VALUES (".$membro["IDmembros"].", ".$_SESSION["S_IDmembros"].", '".date("Y-m-d H:i:s")."', 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."', '".$_SESSION["S_apelido"]." não gostou de uma foto do album do evento ".$album["nome"]."')");
		}
	}
	
	header("location: fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]);
	echo "
		<script type='text/javascript'>
			window.location.href = 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."';
		</script>
	";
	exit;
}

//Isso indica que está sendo enviada uma solicitação de alteração da foto inicial do album para esta
elseif ($_GET["active"] == true AND $_SESSION["S_poderes18"]) {
	mysql_query("UPDATE albuns SET fotocapa='".addslashes($_GET["f"])."' WHERE IDalbuns='".addslashes($_GET["a"])."'");
	echo "
		<script type='text/javascript'>
			window.location.href = 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."';
		</script>
	";
}
include("../header.php");

//Deleta o comentário de uma foto, seo usuario tiver autoridade para isso
if ($_GET["delete"]) {
	$data = mysql_query("SELECT * FROM albuns_comentarios WHERE IDcomentarios=".addslashes($_GET["delete"])." AND IDmembros=".$_SESSION["S_IDmembros"]);
	if (@mysql_num_rows($data) == 1) {
		mysql_query("DELETE FROM albuns_comentarios WHERE IDcomentarios=".addslashes($_GET["delete"]));
		echo "
			<script type='text/javascript'>
				window.location.href = 'fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&y=".$_GET["y"]."';
			</script>
		";
	}
}

//Essa função faz com que a página não retorne com o scroll 0 depois de ter a página atualizada, mas no local onde estava antes
echo '
<script language="javascript">
	function fixScroll(url) {
	  var pos = window.scrollY;
	  window.location.href = url+"&y="+pos;
	}
</script>';

?>
<script type='text/javascript'>
	//usado somente em textareas
	function checkmylines(q, a, b, c, d) {
		if (a > b + 1 || c > d + 1) {
			document.getElementById("js_commenter").rows = q+1;
		}
	}
</script>
<?

include("../menu.php");
include("../leftbar.php");

//chamando o álbum e suas informações
$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["a"]));
$album = mysql_fetch_array($data);

//chamando a foto selecionada especifícamente
$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"]));
$foto_selecionada = mysql_fetch_array($data);

$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDalbuns=".addslashes($_GET["a"]));
$whiles = 0; $me = 0; $antes = ""; $depois = ""; $controle = " | ";
while ($full = mysql_fetch_array($data)) {
	$array_fotos[$whiles] = $full["IDfotos"];
	$whiles++;
	$controle .= "<a style='cursor:pointer' onClick=\" fixScroll('fotos.php?a=".addslashes($_GET["a"])."&f=".$full["IDfotos"]."') \" class='estatuto'>$whiles</a> | ";
	if ($_GET["f"] == $full["IDfotos"]) { $me = $whiles; } //descobre que a variavel atual é a propria foto
	elseif ($me == 0) { $antes = $full["IDfotos"]; } //pega a variavel que vem antes
	elseif ($me != "" AND $depois == "") { $depois = $full["IDfotos"]; } //pega a variavel que vem depois
}

//Caso seja a primeira foto ou a ultima
if ($antes == "") { $antes = $array_fotos[count($array_fotos) - 1]; }
if ($depois == "") { $depois = $array_fotos[0]; }
echo "<h1>".$album["nome"]."</h1>";

echo "<div id='foto_grande'>";
//Se a pessoa que estiver vendo o album for administrador com acesso a upload de fotos, ele tem liberdade de alterar a capa do album
if ($album["fotocapa"] == $_GET["f"] AND $_SESSION["S_poderes18"]) { echo "<div id='is_cape' class='on'></div>"; }
elseif ($_SESSION["S_poderes18"]) { echo "<div id='is_cape' onClick=' window.location.href = \"fotos.php?f=".$_GET["f"]."&a=".$_GET["a"]."&y=".$_GET["y"]."&active=true\"; ' ></div>"; }
echo "	
  <div id='img_count'>$me/$whiles</div>
  <div id='esquerda' OnClick='fixScroll(\"fotos.php?a=".$_GET["a"]."&f=".$antes."\")'></div>
  <IMG src='../../arquivo/fotos_albuns/".$album["pasta"]."/".$foto_selecionada["fotos"]."'>
  <div id='direita' OnClick='fixScroll(\"fotos.php?a=".$_GET["a"]."&f=".$depois."\")'></div>
<div id='foto_footer'><a href='../../arquivo/fotos_albuns/".$album["pasta"]."/".$foto_selecionada["fotos"]."' target='_blank'>Ver foto no tamanho original</a></div>";

//GOSTAR E NÃO GOSTAR
if ($_SESSION["S_logado"]) {
	$data_like = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND positivo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");
	$data_unlike = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"])." AND negativo_index LIKE '%.".$_SESSION["S_IDmembros"].".%'");

	//GOSTEI
	if (mysql_num_rows($data_like) == 0) {
		echo "<div class='gostei' title='Gostei!' onClick=\" fixScroll('fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&like=true'); \"></div>";
	}
	
	else {
		echo "<div class='gostei' title='Gostei! (desfazer)' onClick=\" fixScroll('fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&like=true'); \" style=\" background-image: url('../../plugins/img/block_pos.gif'); \"></div>";
	}
	
	//NÃO GOSTEI
	if (mysql_num_rows($data_unlike) == 0) {
		echo "<div class='nao_gostei' title='Não gostei!' onClick=\" fixScroll('fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&unlike=true'); \"></div>";
	}
	
	else {
		echo "<div class='nao_gostei' title='Não gostei! (desfazer)' onClick=\" fixScroll('fotos.php?a=".$_GET["a"]."&f=".$_GET["f"]."&unlike=true'); \" style=\" background-image: url('../../plugins/img/block_neg.gif');\"></div>";
	}
}
echo "</div>";

$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
$foto = mysql_fetch_array($data);
$negativo = explode(".", $foto["negativo_index"]);
$positivo = explode(".", $foto["positivo_index"]);
$br = "";

if (count($negativo) == 2 AND count($positivo) == 2) { //O número que retorna quando se explode essa linha, quando ela esta vazia, é 2
	$nothing = " style='display:none;' ";
}

elseif (count($negativo) > 2 AND count($positivo) > 2) { //Se os dois tiverem pelo menos uma pessoa cadastrada
	$br = "<br />";
}

//MOSTRANDO ESCRITO QUEM GOSTOU E QUEM NÃO GOSTOU
echo "
<div $nothing class='like'>
	<img src='../../plugins/img/like_unlike.png' />
	<span style='color: #009900;'>";
	for ($IntFor = 1; $IntFor < count($positivo)-1; $IntFor++) {
		$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$positivo[$IntFor]);
		$membro = mysql_fetch_array($data);
		
		//se é feito sem separação, separado por vírgula, separado por E ou separado por vírgula e E
		//nada
		if ($IntFor == 1) {
			echo $membro["apelido"];
		}
		
		//E
		elseif ($IntFor == count($positivo) - 2) {
			echo " e ".$membro["apelido"];
		}
		
		//vírgula
		else {
			echo ", ".$membro["apelido"];
		}
	}
	
	//Questões de pluralidade
	if (count($positivo) == 3) { //3 quer dizer que só há um registro
		echo " gostou desta foto.";
	}
	
	elseif (count($positivo) > 3) {
		echo " gostaram desta foto.";
	}
	
	echo "</span>$br
	$br
	<span style='color: #CC0000;'>";
	for ($IntFor = 1; $IntFor < count($negativo) - 1; $IntFor++) {
		$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$negativo[$IntFor]);
		$membro = mysql_fetch_array($data);
		
		//se é feito sem separação, separado por vírgula, separado por E ou separado por vírgula e E
		//nada
		if ($IntFor == 1) {
			echo $membro["apelido"];
		}
		
		//E
		elseif (count($negativo) - 1) {
			echo " e ".$membro["apelido"];
		}
		
		//vírgula
		else {
			echo ", ".$membro["apelido"];
		}
	}
	
	//Questões de pluralidade
	if (count($negativo) == 3) { //3 quer dizer que só há um registro
		echo " não gostou desta foto.";
	}
	
	elseif (count($negativo) > 3) {
		echo " não gostaram desta foto.";
	}
	
	echo "</span>
</div>
";

//COMENTARIOS NAS FOTOS
//Esse POST recebe um comentario quando ele é feito, o POST é colocado um pouco acima da listagem dos comentarios para que quando os comentarios sejam chamados do banco de dados ele apareça junto
if ($_POST["submit_comment"] AND $_SESSION["S_logado"]) {
	if ($_POST["commenter"] != "") {
		$commenter = addslashes($_POST["commenter"]);
		$commenter = nl2br($commenter);
		mysql_query("INSERT INTO albuns_comentarios (IDmembros, IDitem, tipo, content, data) VALUES (".$_SESSION["S_IDmembros"].", ".addslashes($_GET["f"]).", 'foto', '$commenter', '".date("Y-m-d H-i-s")."')");
		
		//Avisando as pessoas que essa foto foi comentada
		$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$_SESSION["S_IDmembros"]);
		$config = mysql_fetch_array($data);
		//O usuário permite que aquilo que for postado por ele seja notificado para os outros?
		if ($config["notifc_envia_nunca"] == 0) {
			//vendo qual dessas pessoas está nos comentários
			$data = mysql_query("SELECT DISTINCT IDmembros FROM `albuns_comentarios`");
			$sql = "";
			//Será enviado para todos os que já comentaram essa foto
			while ($membro = mysql_fetch_array($data)) {
				if ($membro["notifc_recebe_meus"] == 1 AND $membro["IDmembros"] != $_SESSION["S_IDmembros"]) {
					$sql .= " OR IDmembros = ".$membro["IDmembros"]; //montando a QUERY
				}
			}
			
			$data = mysql_query("SELECT * FROM albuns_fotos WHERE IDfotos=".addslashes($_GET["f"])." AND IDalbuns=".addslashes($_GET["a"]));
			$foto = mysql_fetch_array($data);
			$negativo = explode(".", $foto["negativo_index"]);
			$positivo = explode(".", $foto["positivo_index"]);
			
			for ($IntFor = 1; $IntFor < count($positivo) -1; $IntFor++) {
				$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$positivo[$IntFor]);
				$membro = mysql_fetch_array($data);
				
				//Você não precisa ser notificado de um comentário que você mesmo fez B:
				if ($membro["notifc_recebe_meus"] == 1 AND $positivo[$IntFor] != $_SESSION["S_IDmembros"]) {
					$sql .= " OR IDmembros = ".$positivo[$IntFor];
				}
			}
			
			for ($IntFor = 1; $IntFor < count($negativo) -1; $IntFor++) {
				$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$negativo[$IntFor]);
				$membro = mysql_fetch_array($data);
				
				//Você não precisa ser notificado de um comentário que você mesmo fez B:
				if ($membro["notifc_recebe_meus"] == 1 AND $negativo[$IntFor] != $_SESSION["S_IDmembros"]) {
					$sql .= " OR IDmembros = ".$negativo[$IntFor];
				}
			}
			
			$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["a"]));
			$album = mysql_fetch_array($data);
			
			//QUERY FINAL (enviando a novidade de que uma foto foi comentada para as pessoas que desejam receber)
			$data = mysql_query("SELECT * FROM membros WHERE notifc_recebe_sempre=1 ".$sql);
			while ($final = mysql_fetch_array($data)) {
				mysql_query("INSERT membros_novidades (IDmembros_afetado, IDmembros_executor, datahora, link, content) VALUES (".$final["IDmembros"].", ".$_SESSION["S_IDmembros"].", '".date("Y-m-d H:i:s")."', 'fotos.php?a=".addslashes($_GET["a"])."&f=".addslashes($_GET["f"])."&Y=true', '".$_SESSION["S_apelido"]." comentou uma foto do album do evento ".$album["nome"].".')");
			}
		}
	}
}

//COMENTÁRIOS NAS FOTOS
$data  = mysql_query("SELECT * FROM albuns_comentarios WHERE IDitem='".addslashes($_GET["f"])."' AND tipo='foto' ORDER BY data");
while ($comentarios = mysql_fetch_array($data)) {
	//Pegando as informações do membro que fez a postagem
	$data_membro = mysql_query("SELECT * FROM membros WHERE IDmembros=".$comentarios["IDmembros"]);
	$membro = mysql_fetch_array($data_membro);
	
	//ajeitando a data e hora para um forma humanamente entendivel
	$date = explode(" ", $comentarios["data"]);
	$date[0] = bd2human($date[0]);
	$date = $date[0]." ".substr($date[1], 0, 5);
	
	//Verificando se o usuário é o responsável pelo POST, se ele for, tem o direito de deletar
	if ($comentarios["IDmembros"] == $_SESSION["S_IDmembros"] OR $_SESSION["S_poderes3"]) { //poder 3 = moderador
		$delete = "<img src='../../plugins/img/delete.png' onClick=\" fixScroll('?a=".$_GET["a"]."&f=".$_GET["f"]."&delete=".$comentarios["IDcomentarios"]."') \" />";
	}
	
	else {
		$delete = "";
	}
	
	$content = str_replace('\"', '"', $comentarios["content"]);
	$content = str_replace("\'", "'", $content);
	
	echo "
		<div class='comment'>
			$delete
			<span>
				<IMG src='../../arquivo/fotos_membros/".$membro["foto"]."' /><br />
				<b>".$membro["apelido"]."</b>
			</span>
			<span class='comment'>".$content."</span>
			<div>$date</div>
		</div>
	";
}
if ($_SESSION["S_logado"]) {
	echo "
	<div class='reply'>
		<form method='POST' action=''>
			<textarea name='commenter' rows='1' id='js_commenter' onKeyUp=\" checkmylines(this.rows, this.scrollHeight, this.offsetHeight, this.scrollWidth, this.offsetWidth) \"></textarea>
			<input type='submit' name='submit_comment' value='Enviar' />
		</form>
	</div>
	";
}

//Facilitando a navegação, essa variavel recebe os valores logo quando a foto é apresentada, perto da linha 150
$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["a"]));
$alb = mysql_fetch_array($data);
echo "<div class='comment' style='padding: 10px;'>";
echo $controle." <a class='estatuto' style='cursor:pointer' href='albfotos.php?a=".substr($alb["dataevento"], 0, 4)."'>voltar</a>";
echo "</div>";

include("../rightbar.php");
include("../footer.php");
if ($_GET["y"]) { echo '<script language="javascript">window.scrollTo(0, '.$_GET["y"].');</script>'; }
elseif ($_GET["Y"] == true) { echo '<script language="javascript">window.scrollTo(0, window.scrollMaxY);</script>'; }
elseif ($_POST["submit_comment"]) { echo '<script language="javascript">window.scrollTo(0, window.scrollMaxY);</script>'; }
?>
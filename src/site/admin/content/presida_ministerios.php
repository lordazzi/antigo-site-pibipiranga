<?
  include("../conn.php");
  if (!$_SESSION["S_poderes11"]) { header("../../content"); exit; }
   
   //aqui ele move os minist�rios para cima e para baixo de acordo com as ordens dadas pelo usu�rio, depois disso ele redireciona a p�gina para que os valores de comando GET sejam perdidos.
  if ($_GET["slide"]) {
	$data = mysql_query("SELECT * FROM ministerios");
	$mins_qtd = mysql_num_rows($data);
	$data = mysql_query("SELECT * FROM ministerios WHERE IDministerios=".addslashes($_GET["id"]));
	$min_info = mysql_fetch_array($data);
	if ($_GET["slide"] == "up") {
		if ($min_info["posicao"] != 1) {
			mysql_query("UPDATE ministerios SET posicao=0 WHERE IDministerios=".addslashes($_GET["id"]));
			mysql_query("UPDATE ministerios SET posicao=".$min_info["posicao"]." WHERE posicao=".($min_info["posicao"] - 1));
			mysql_query("UPDATE ministerios SET posicao=".($min_info["posicao"] - 1)." WHERE posicao=0");
			header("location: ?y=".$_GET["y"]); 
		}
	}
	
	elseif ($_GET["slide"] == "down") {
		if ($min_info["posicao"] != $mins_qtd) {
			mysql_query("UPDATE ministerios SET posicao=0 WHERE IDministerios=".addslashes($_GET["id"]));
			mysql_query("UPDATE ministerios SET posicao=".$min_info["posicao"]." WHERE posicao=".($min_info["posicao"] + 1));
			mysql_query("UPDATE ministerios SET posicao=".($min_info["posicao"] + 1)." WHERE posicao=0");
			header("location: ?y=".$_GET["y"]);
		}
	}
  }
  
  
  
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
  
	//CADASTRA NO BANCO DE DADOS SE N�O HOUVER NENHUM ERRO
	if ($_POST["novo_ministerio"]) {
		$msg_erro = "";
		if ($_POST["ministerio"] != "") {
			if (onlyletter($_POST["ministerio"], "�����������")) {
				$ministerio = addslashes($_POST["ministerio"]);
				$ministerio = ajeita($ministerio);
			}
			
			else {
				$msg_erro .= "Voc� utilizou caracteres inv�lidos para o nome do minist�rio. ";
			}
		}
		
		else {
			$msg_erro .= "O nome do minist�rio n�o pode ser nulo. ";
		}
		
		if ($_POST["lider_titulo"] != "") {
			if (onlyletter($_POST["lider_titulo"], "����������")) {
				$lider_titulo = addslashes($_POST["lider_titulo"]);
				$lider_titulo = ajeita($lider_titulo);
			}
			
			else {
				$msg_erro .= "Voc� utilizou caracteres inv�lidos para o campo do t�tulo do l�der do minist�rio. ";
			}
		}
		
		else {
			$msg_erro .= "Voc� n�o pode deixar o t�tulo do l�der vazio. ";
		}
		
		if ($_POST["lider_nome"] != "") {
			if (onlyletter($_POST["lider_nome"], "����������")) {
				$lider_nome = addslashes($_POST["lider_nome"]);
				$lider_nome = ajeita($lider_nome);
			}
			
			else {
				$msg_erro .= "Voc� utilizou caracteres inv�lidos no nome do l�der do minist�rio. ";
			}
		}
		
		else {
			$msg_erro .= "O nome do l�der n�o pode ser vazio. ";
		}
		
		if ($_POST["description"] != "") {
			if (onlyletter($_POST["description"], "�����������,.!?;:()'@#$%&*1234567890������-_+={}[]|\/".'"')) {
				$description = addslashes($_POST["description"]);
			}
			
			else {
				$msg_erro .= "Voc� utilizou caracteres inv�lidos para descrever. ";
			}
		}
		
		else {
			$msg_erro .= "A descri��o n�o pode ser nula. ";
		}
		
		if ($msg_erro == "") {		
			$data_mins = mysql_query("SELECT * FROM ministerios");
			$last_position = mysql_num_rows($data_mins);
			$last_position += 1;
			mysql_query("INSERT INTO ministerios (posicao, ministerio, lidertitulo, lidernome, liderfoto, conteudo) VALUES ($last_position, '$ministerio', '$lider_titulo', '$lider_nome', 'padrao.jpg', '$description')");
			echo "<script type='text/javascript'>alert('O minist�rio foi criado com sucesso!');</script>";
		}
		
		else {
			echo "<script type='text/javascript'>alert('".$msg_erro."');</script>";
		}
	}

?>
<h1 style='text-align: center;'>Criar minist�rios</h1>
<br />
<div class='subcontent' style="width: 340px;">
	<form method="POST" action="?y=0">
		<label class="new_mins">Nome do minist�rio:</label> <input type="text" name="ministerio" style="width: 172px;" class="new_mins" value="<? echo $_POST["ministerio"]; ?>" /><br /><br />
		<label class="new_mins">T�tulo do l�der:</label>	<input type="text" name="lider_titulo" style="width: 172px;" value="L�der" class="new_mins" value="<? echo $_POST["lider_titulo"]; ?>" /><br /><br />
		<label class="new_mins">Nome do l�der:</label> 		<input type="text" name="lider_nome" style="width: 172px;" class="new_mins" value="<? echo $_POST["lider_nome"]; ?>" /><br /><br />
		<textarea class="new_mins" name="description"></textarea><br />
		<input type="submit" name="novo_ministerio" value="Criar" />
	</form>
</div>
<br />
<br />
<h1 style='text-align: center;'>Editar minist�rios</h1>
<br />
<div class='subcontent' style='width: 745px'>
<div class="title_mins mins_min" style="clear: both;">Ministerio</div> <div class="title_mins mins_nome">Nome</div> <div class="title_mins mins_pos">Posi��o</div>
	<?php
	  $data = mysql_query("SELECT * FROM ministerios ORDER BY posicao");
	  $whiles = 0;
	  while ($mins = mysql_fetch_array($data)) {
		if ($whiles == 0) { $mins_up = ""; $internal = " style='margin: 0 0 0 12px'"; } else { $mins_up = "<div class='mins_up' onClick=' fixScroll(\"?slide=up&id=".$mins["IDministerios"]."\") '></div>"; $internal = "";}
		if ($whiles == (mysql_num_rows($data) - 1)) { $mins_down = ""; } else { $mins_down = "<div class='mins_down' $internal  onClick=' fixScroll(\"?slide=down&id=".$mins["IDministerios"]."\") '></div>"; }
		echo "
			<span class='content_mins'>
				<div class='mins_min' style='clear: both;'>".$mins["ministerio"]."</div>
				<div class='mins_nome'>".$mins["lidertitulo"]." ".$mins["lidernome"]."</div>
				<div class='mins_pos'> ".$mins_up." ".$mins_down." </div>
				<div class='content_mins'><a href='#'>Editar</a></div>
			</span>
			";
		$whiles++;
	  }
	  echo "
	  <div style='clear: both;'></div>
  </div><!-- fechando a DIV subcontent -->";
  include("../footer.php");
  if ($_GET["y"]) { echo '<script language="javascript">window.scrollTo(0, '.$_GET["y"].');</script>'; }
?>
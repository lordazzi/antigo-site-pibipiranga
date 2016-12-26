<?php 
	include("../conn.php");
	if (!$_SESSION["S_poderes18"]) { header("../../content"); exit; }
	
	//Redimencionando as imagens, passando para a pasta certa e as associando no banco de dados
	if ($_GET["close"]) {
		//importando a classe que redimenciona imagens
		echo "
		<head>
			<script type='text/javascript'>
				function redirect() {
					window.location.href = '?';
				}
			</script>
		</head>
		<body onload='redirect()'>
			<b>
				 <img src='../../../plugins/img/loading.gif' /> Redimencionando fotos. <br />
				 <img src='../../../plugins/img/loading.gif' /> Tirando da área temporaria. <br /> 
				 <img src='../../../plugins/img/loading.gif' /> Associando ao álbum. <br />
			 </b>
			 Aguarde até que a página faça o redirecionamento automaticamente, caso contrário o álbum não será concluido!<br />";
		$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["close"]));
		$album = mysql_fetch_array($data);
		if (!file_exists("../../../arquivo/fotos_albuns/".$album["pasta"])) {
			mkdir("../../../arquivo/fotos_albuns/".$album["pasta"]);
		}
		
		$ponteiro  = opendir("../../../arquivo/arquivos_tmp/".$album["pasta"]);
		$whiles = 0;
		while ($nome_itens = readdir($ponteiro)) {
			if ($nome_itens != "." AND $nome_itens != "..") {
				//pegando somente a parte do nome da pasta que contém letras
				$truename = str_replace("0", "", $album["pasta"]);	$truename = str_replace("1", "", $truename);
				$truename = str_replace("2", "", $truename);		$truename = str_replace("3", "", $truename);
				$truename = str_replace("4", "", $truename);		$truename = str_replace("5", "", $truename);
				$truename = str_replace("6", "", $truename);		$truename = str_replace("7", "", $truename);
				$truename = str_replace("8", "", $truename);		$truename = str_replace("9", "", $truename);
				$truename .= $whiles.date("_ymdhis").".jpg";
				
				//renomeando
				rename("../../../arquivo/arquivos_tmp/".$album["pasta"]."/".$nome_itens, "../../../arquivo/arquivos_tmp/".$album["pasta"]."/".$truename);
				//redimencionando
				redimensiona("../../../arquivo/arquivos_tmp/".$album["pasta"]."/".$truename, "../../../arquivo/fotos_albuns/".$album["pasta"]."/".$truename);
				//associando a imagem ao banco de dados
				mysql_query("INSERT INTO albuns_fotos (IDalbuns, fotos) VALUES (".addslashes($_GET["close"]).", '".$truename."')");
				$fotoid = mysql_insert_id();
				if ($whiles == 0) {
					mysql_query("UPDATE albuns SET fotocapa='$fotoid' WHERE IDalbuns=".addslashes($_GET["close"]));
				}
				$whiles++;
			}
			echo "<br />";
		}
		echo "</body>";
		@killdir("../../../arquivo/arquivos_tmp/".$album["pasta"]);
		exit;
	}
	
	include("../header.php");
?>

<!-- Importando calendario -->
<link rel="stylesheet" type="text/css" href="../../../plugins/js/calendario/jquery.click-calendario-1.0.css" />
<script type="text/javascript" src="../../../plugins/js/calendario/jquery.click-calendario-1.0.js"></script>

<!-- Mascara -->
<script type="text/javascript" src="../../../plugins/js/mascara/jquery.maskedinput-1.1.4.pack.js"/></script>

<script type="text/javascript">
	$(document).ready(function(){
		//mascara
		$("#evento_data").mask("99/99/9999");
		
		//calendario
		$('#evento_data').focus(function(){
			$(this).calendario({
				target:'#evento_data'
			});
		});
		
	});
	
	//Pegando a data e colocando junto do nome da pasta
	var date, nome;
	function muda_nome() {
		date = document.getElementById("evento_data").value;
		date = date.split("/");
		date[2] = date[2].substring(2, 4);
		date = date[0] + "" + date[1] + "" + date[2];
		document.getElementById("pasta_date").innerHTML = date;
	}
	
	//Adiciona opções no menu
	function add_options() {
		nome = document.getElementById("album_nome").value;
		nome = nome.split(" ");
		
		//tirando os acentos
		nome = str_replace("Ã", "A", nome);		nome = str_replace("Â", "A", nome);
		nome = str_replace("À", "A", nome);		nome = str_replace("Ä", "A", nome);
		nome = str_replace("Á", "A", nome);		nome = str_replace("@", "A", nome);
		nome = str_replace("Ë", "E", nome);		nome = str_replace("É", "E", nome);
		nome = str_replace("È", "E", nome);		nome = str_replace("Ê", "E", nome);
		nome = str_replace("Í", "I", nome);		nome = str_replace("Ì", "I", nome);
		nome = str_replace("Ï", "I", nome);		nome = str_replace("Î", "I", nome);
		nome = str_replace("Ó", "O", nome);		nome = str_replace("Õ", "O", nome);
		nome = str_replace("Ô", "O", nome);		nome = str_replace("Ò", "O", nome);
		nome = str_replace("Ú", "U", nome);		nome = str_replace("Û", "U", nome);
		nome = str_replace("Ù", "U", nome);		nome = str_replace("Ü", "U", nome);
		nome = str_replace("Ö", "O", nome);		nome = str_replace("Ñ", "N", nome);
		nome = str_replace("Ç", "C", nome);		nome = str_replace("0", "", nome);
		nome = str_replace("1", "", nome);		nome = str_replace("2", "", nome);
		nome = str_replace("3", "", nome);		nome = str_replace("4", "", nome);
		nome = str_replace("5", "", nome);		nome = str_replace("6", "", nome);
		nome = str_replace("7", "", nome);		nome = str_replace("8", "", nome);
		nome = str_replace("9", "", nome);		nome = str_replace("ã", "A", nome);
		nome = str_replace("â", "A", nome);		nome = str_replace("à", "A", nome);
		nome = str_replace("ä", "A", nome);		nome = str_replace("á", "A", nome);
		nome = str_replace("ë", "E", nome);		nome = str_replace("é", "E", nome);
		nome = str_replace("è", "E", nome);		nome = str_replace("ê", "E", nome);
		nome = str_replace("í", "I", nome);		nome = str_replace("ì", "I", nome);
		nome = str_replace("ï", "I", nome);		nome = str_replace("î", "I", nome);
		nome = str_replace("ó", "O", nome);		nome = str_replace("õ", "O", nome);
		nome = str_replace("ô", "O", nome);		nome = str_replace("ò", "O", nome);
		nome = str_replace("ú", "U", nome);		nome = str_replace("û", "U", nome);
		nome = str_replace("ù", "U", nome);		nome = str_replace("ü", "U", nome);
		nome = str_replace("ö", "O", nome);		nome = str_replace("ñ", "N", nome);
		nome = str_replace("ç", "C", nome);
		
		document.getElementById("pasta_nome").innerHTML = "";
		var first;
		for (IntFor = 0; IntFor < nome.length; IntFor++) {
			//dando um selected no primeiro
			if (IntFor == 0) { first = " selected='selected' "; }
			else { first = ""; }
			
			//só pode ser selecionado se a palavra tiver mais de 3 letras
			if (nome[IntFor].length > 2) {
				document.getElementById("pasta_nome").innerHTML += "<option value="+IntFor+first+">"+nome[IntFor].toUpperCase()+"</option>";
			}
		}
	}
	
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
	
	//funciona em conjunto dos comandos no final da página
	function fixScroll(url) {
	  var pos = window.scrollY;
	  window.location.href = url+"&y="+pos;
	}

</script>
  
<?
	include("../menu.php");
	
	//POST de criação do álbum
	if ($_POST["criar_album"]) {
	
		$erro = "";
		//VALIDAÇÃO DO NOME
		if ($_POST["album_nome"] != "") {
			if (onlyletter($_POST["album_nome"], "-áéíóúâêçàãõç.!@#$%&*()1234567890")) {
				$nome = addslashes($_POST["album_nome"]);
				$nome = ajeita($nome);
			}
			
			else {
				$erro .= "O nome do álbum contém caracteres inválidos. \\n ";
			}
		}
		
		else {
			$erro .= "O nome do álbum não pode ser nulo. \\n ";
		}
		
		//VALIDAÇÃO DA DATA
		if ($_POST["evento_data"] != "") {
			$date = explode("/", $_POST["evento_data"]);
			if (strlen($date[0]) == 2 AND strlen($date[1]) == 2 AND strlen($date[2]) == 4) {
				//apenas números
				if (onlynumbers($date[0]) AND onlynumbers($date[1]) AND onlynumbers($date[2])) {
					//a data é possivel?
					if (dateexists($date[2]."-".$date[1]."-".$date[0])) {
						$date = $_POST["evento_data"];
					}
					
					else {
						$erro .= "Essa data não é possivel. ";
					}
				}
				
				else {
					$erro .= "A data pode conter apenas números. ";
				}
			}
			
			else {
				$erro .= "A data está em um formato estranho. ";
			}
		}
		
		else {
			$erro .= "O campo da data não pode ser nulo. ";
		}
		
		//fazendo o nome da pasta
		$pasta = explode(" ", $_POST["album_nome"]);
		$pasta = $pasta[$_POST["pasta"]];
		$pasta = strtoupper($pasta);
		$date = explode("/", $_POST["evento_data"]);
		$pasta = $pasta.$date[0].$date[1].substr($date[2], 2, 2);
		$pasta = unacenta($pasta); //tirando os acentos
		
		$data = mysql_query("SELECT * FROM albuns WHERE pasta=".$pasta);
		if (@mysql_num_rows($data) != 0) {
			$erro .= "Seleciona outro nome para a pasta! Esse nome de pasta já existe. ";
		}
		
		if ($erro == "") {
			//agindo
			mkdir("../../../arquivo/fotos_albuns/".$pasta);
			mysql_query("INSERT INTO albuns (nome, tipo, pasta, dataevento, fotocapa, created) VALUES ('$nome', 'foto', '$pasta', '".human2bd($_POST["evento_data"])."', 0, '".date("Y-m-d h:i:s")."')");
			$lastid = mysql_insert_id();
			echo "
			<script type='text/javascript'>
				window.location.href = 'av_fotos.php?alb=$lastid';
			</script>
			";
		}
		
		else {
			echo "
			<script type='text/javascript'>
				alert('".$erro."');
			</script>";
		}
	}
	
?>

<h1 style='text-align: center;'>Upload de fotos e criação de albuns</h1>

<form method="POST" action="">
	<div class="subcontent" style="width: 290px;" onMouseMove="muda_nome()">
		<label for="album_nome">Nome do álbum</label> <input name="album_nome" id="album_nome" maxlength="32" type="text" onKeyUp="add_options(), ajeita_nome()" /><br />
		<label for="evento_data">Data do evento</label> <input name="evento_data" id="evento_data" type="text" onKeyUp="muda_nome()" />
		<label for="pasta" title="Esse é o nome da pasta que as fotos do álbum ficaram armazenadas dentro do servidor.">Nome da pasta</label>
		<select name="pasta" id="pasta_nome" title="Esse é o nome da pasta que as fotos do álbum ficaram armazenadas dentro do servidor." style="max-width: 105px;">
		</select><b id="pasta_date" title="Esse é o nome da pasta que as fotos do álbum ficaram armazenadas dentro do servidor.">000000</b>
		<input type="submit" name="criar_album" value="Criar album">
	</div>
</form>

<br />
<h1 style='text-align: center;'>Adicionar fotos nos albuns</h1>
<div class="subcontent" style="width: 400px;">
	<?
	//CRIA O MENU DE ANOS
	$data = mysql_query("SELECT DISTINCT SubString( dataevento, 1, 4 ) FROM albuns WHERE tipo='foto' ORDER BY dataevento");
	echo "<div id='menu_anos' style='padding: 0px;'>|";
	while ($years_array = mysql_fetch_array($data)) {
		echo "<a style='padding: 0px;' href='javascript: fixScroll(\"av_fotos.php?ano=".$years_array["SubString( dataevento, 1, 4 )"]."\")'>".$years_array["SubString( dataevento, 1, 4 )"]."</a> | ";
	}
	echo "</div>";
	?>
	<br />
	<table>
		<tr>
			<td style="width: 150px; font-weight: bold;">Data do evento</td>
			<td style="width: 70%; font-weight: bold;">Nome</td>
		</tr>
		<?
			if (!$_GET["ano"]) {//se não tiver um ano na URL
				$ano = date("Y"); $ItsOk = false;
				do {
					//busca um ano em que haja fotos
					$data = @mysql_query("SELECT * FROM albuns WHERE dataevento LIKE '$ano%' AND tipo='foto'");
					if (mysql_num_rows($data)) {
						$ItsOk = true;
					}
					
					else {
						$ano = $ano - 1;
					}
				} while($ItsOk == false);
			}
			
			else {
				$ano = addslashes($_GET["ano"]);
			}
			
			$data = mysql_query("SELECT * FROM albuns WHERE dataevento LIKE '$ano%' AND tipo='foto' ORDER BY dataevento");
			while ($eventos = mysql_fetch_array($data)) {
				echo "
				<tr>
					<td onClick=\"window.location.href = '?alb=".$eventos["IDalbuns"]."'; \">".bd2human($eventos["dataevento"])."</td>
					<td onClick=\"window.location.href = '?alb=".$eventos["IDalbuns"]."'; \">".$eventos["nome"]."</td>
				</tr>";
			}
		?>
	</table>
</div>


<?php
include("../footer.php");
  
  //É importante que essa opeção seja feita depois do footer para que as influências do CSS sejam anuladas sobre essa parte
if ($_GET["alb"] AND onlynumbers($_GET["alb"])) { ?><!-- Se a variavel GET referente ao ID do album exitir e se for composta apenas por números -->
	<div id="css_back_black" style="display: block;">
		<div class="window" style="width: 385px;">
			<? 
				$data = mysql_query("SELECT * FROM albuns WHERE IDalbuns=".addslashes($_GET["alb"]));
				$album = mysql_fetch_array($data);
				echo "<b>Album: </b>".$album["nome"]." (".bd2human($album["dataevento"]).")";
				
				//Deletando a pasta antiga, se tiver e depois criando uma nova
				@killdir("../../../arquivo/arquivos_tmp/".$album["pasta"]);
				@mkdir("../../../arquivo/arquivos_tmp/".$album["pasta"]);
			
				//Importando a class de upload de imagens
				require_once "../../../plugins/php/phpuploader/include_phpuploader.php";
				$uploader = new PhpUploader();
				$uploader->MultipleFilesUpload=true;
				$uploader->InsertText="Envie no máximo 15 arquivos por vez.";
				$uploader->MaxSizeKB=1024000;
				$uploader->AllowedFileExtensions="*.jpg,*.png,*.gif";
				$uploader->SaveDirectory="../../../arquivo/arquivos_tmp/".$album["pasta"];
				$uploader->FlashUploadMode="Partial";
				$uploader->Render();
			?>
			
			<!-- um javascriptizinho burocrático -->
			<script type='text/javascript'>
				function CuteWebUI_AjaxUploader_OnTaskComplete(task) { }
			</script>
			<button onClick="window.location.href = '?'; ">Voltar</button>
			<button onClick="window.location.href = '?close=<? echo $_GET["alb"]; ?>'; ">Finalizar</button>
		</div>
	</div>
	<?
}//fechando o GET a cima
  if ($_GET["y"]) { echo '<script language="javascript">window.scrollTo(0, '.$_GET["y"].');</script>'; } //funciona em conjunto da função FIXSCOLL
?>
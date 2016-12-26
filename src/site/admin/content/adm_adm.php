<?php 
  include("../conn.php");
  if (!$_SESSION["S_poderes2"]) { header("../../content"); exit; }
  include("../header.php");
  include("../menu.php");
  
  $n_de_acessos = 23; //constante de número de acessos, se o número de acessos aumentar, somente essa variavel tem necessidade de ser alterada, ao invés do arquivo inteiro.
  //A descrição deve ser alterada também, por que ela é somente texto puro
?>
<!-- Funções em JavaScript -->
<script language="javascript" type="text/javascript">
//Essa função é referente ao aumentar e diminuir do texto explicativo a respeito dos acessos administrativos
function aumenta() {
	document.getElementById("js_aumenta").style.display = "none";
	document.getElementById("js_diminui").style.display = "block";
	document.getElementById("js_explica_span").style.display = "block";
	document.getElementById("js_explica_form").action = "";
}

function diminui() {
	document.getElementById("js_aumenta").style.display = "block";
	document.getElementById("js_diminui").style.display = "none";
	document.getElementById("js_explica_span").style.display = "none";
	document.getElementById("js_explica_form").action = "?hidden=true";
}

function myRealStyle(myId) {
	document.getElementById(myId).style.color = "#000000";
	document.getElementById(myId).style.fontStyle = "normal";
	document.getElementById(myId).value = "";
}

function myEffectStyle(myId) {
	if (document.getElementById(myId).value == "")
	{
		document.getElementById(myId).style.color = "#999999";
		document.getElementById(myId).style.fontStyle = "italic";
		if (myId == "js_input_nome") {
			document.getElementById(myId).value = "Por nome";
		}
		
		else if (myId == "js_input_endereco") {
			document.getElementById(myId).value = "Por endereço";
		}
	}
}

//Essa função faz com que a tela de adição de um novo administrador seja vista, lançando nela os valores dos parametros de nome e id do usuário
function turn_adm(idmembros, nome) {
	document.getElementById("js_membro_nome").innerHTML = nome;
	document.getElementById("js_membro_id").value = idmembros;
	document.getElementById("css_back_black").style.display = "block";
	document.getElementById("js_add_adm").style.display = "block";
}

</script>
<h1 style='text-align: center;'>Administração de administradores</h1>
<?php

//Verificando quantos membros tem poderes administrativos, pela tabela de poderes
$data = mysql_query("SELECT * FROM membros_poderes");
$whiles = 0; $membros[0] = 0; 
while ($os_poderes = mysql_fetch_array($data))
{
  $runwhile = count($membros);
  $whiles2 = 0; $isnew = true; //é um usuário novo? verdade?
  do {//o DO é necessario porque o array começa vazio e ele não rodaria a primeira vez nunca se não tiver um DO 
	if ($membros[$whiles2] == $os_poderes["IDmembros"]) { $isnew = false;  } //se for encontrado um ID de membros no BD igual a um no array, ele não é novo....
	$whiles2++;
  }
  while ($whiles2 < $runwhile);
  if ($isnew == true) { $membros[$whiles] = $os_poderes["IDmembros"]; $whiles++; } //se ainda não houver membros registrados do BD no array ele registra e passa para o proximo...
}


//Essa parte é onde recebe os valores dos campos abaixo por POST e envia para o bando de dados
if ($_POST["editando"] == true) {
	$runwhile = count($membros); $whiles = 0; //variavel $membros é alimentada acima com dados dos membros da igreja que tem acessos (administradores)
	while ($whiles < $runwhile) {
		for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) { //n_de_acesso é uma constante que conhece o número de acessos existentes
			$data = mysql_query("SELECT * FROM membros_poderes WHERE IDmembros=".$membros[$whiles]." AND acesso=".$IntFor);
			if ($verifica = mysql_fetch_array($data)) { $ha_poder = true; } //há poder? true = sim, false = não - Verifica a situação atual do acesso do usuário
			else { $ha_poder = false; }
			
			if ($_POST[$membros[$whiles]."_".$IntFor]) { //se tiverem dado o acesso a ele e não tiver no banco de dados
				if ($ha_poder == false) { mysql_query("INSERT INTO membros_poderes (IDmembros, acesso) VALUES (".$membros[$whiles].", ".$IntFor.")"); }
			}
			
			else { //se ele não dever ter o acesso, mas tiver registrado no banco de dados que ele tem
				if ($ha_poder == true) { mysql_query("DELETE FROM membros_poderes WHERE IDmembros=".$membros[$whiles]." AND acesso=".$IntFor); }
			}
		}
		$whiles++;
	}
}
//O usuário que foram encontrados na tabela de poderes de acordo com o código acima serão listados mostrando cada um com o seu poder.
?>


<form method="POST" action="">
	<table> <!-- Tabela feita para dados tabulares, não vai contra a W3C -->
	  <tr>
		<td><b>Membros</b></td>
		<?php
		for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) {
			echo "<td>".$IntFor."</td>";
		}
		?>
	  </tr>
	<?php
	//CHAMANDO TODO MUNDO QUE TEM FUNÇÃO ADMINISTRATIVA E EXIBINDO NA TELA
	$runwhile = count($membros); $whiles = 0;
	while ($whiles < $runwhile)
	{
	  echo "<tr>";
	  //Vendo quem é
	  $data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$membros[$whiles]);
	  $membro_info = mysql_fetch_array($data);
	  echo "<td>".$membro_info["apelido"]."</td>";
	  //Vendo quais são os poderes e se o administrador é administravel
	  for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) { $pod[$IntFor] = ""; } $dis = ""; //zerando as variaveis de campo checkados e disabilitados
	  $data = mysql_query("SELECT * FROM membros_poderes WHERE IDmembros=".$membros[$whiles]);
	  while ($checkados = mysql_fetch_array($data))
	  {
		$pod[$checkados["acesso"]] = "checked";
		if ($checkados["acesso"] == 1 AND $checkados["IDmembros"] != $_SESSION["S_IDmembros"]) //se for inadministravel e não for a pessoa que esta logado
		{
		  $dis = "disabled='disabled'";
		}
	  }
	  //Escrevendo os checkbox com um For
	  for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) {
		echo "<td><input type='checkbox' name='".$membros[$whiles]."_".$IntFor."' ".$pod[$IntFor]." ".$dis." /></td>";
	  }
	  $whiles++;
	}
	?>
	</table>
	<br />
	<input type="hidden" name="editando" value="true" />
	<input type="submit" value="Salvar" />
</form>


<!-- Se o administrador que tem essa função não souber de cabeça o que cada acesso se refere, ele pode ver nessa tabela -->
<h1 style='text-align: center;'>Instruções sobre a área administrativa</h1>

<fieldset> <!-- Conteúdo explicativo do site -->
  <legend>
    <IMG src="../../../plugins/img/aumenta.png" id="js_aumenta" class="fieldbotton" onClick="aumenta();" style="display: none;">
	<IMG src="../../../plugins/img/diminui.png" id="js_diminui" class="fieldbotton" onClick="diminui();">
  </legend>
  <span id="js_explica_span">
	<!-- Informações sobre os acessos -->
	<?
		for ($IntFor = 1; $IntFor <= ACESSOS_QTD; $IntFor++) {
			echo "<b>Acesso $IntFor: ".$ACESSOS[$IntFor][0]." ></b> ".$ACESSOS[$IntFor][1]."<br />";
		}
	?>
  </span>
</fieldset>

<h1 style='text-align: center;'>Pesquisar membro para dar acessos de administração:</h1>
<form id="js_explica_form" method="POST" action="">
	Pesquisar: <input type='text' name='pornome' id='js_input_nome' class='javascript_input' onFocus='myRealStyle("js_input_nome");' onBlur='myEffectStyle("js_input_nome");' value='Por nome' /><input type='text' name='porendereco' id='js_input_endereco' class='javascript_input' onFocus='myRealStyle("js_input_endereco");' onBlur='myEffectStyle("js_input_endereco");' value='Por endereço'><input type='submit' value='Pesquisar' /> <i>(Para facilitar a pesquisa, use apenas letras e digite apenas as palavras necessárias.)</i>
</form>
<?php /* PESQUISA */
  if ($_POST["pornome"] or $_POST["porendereco"])
  {
    //DIVs de titulo da pesquisa
	echo "<br />";
	echo "<div class='pesquisa'>";
	  echo "<div class='titulo'>Login</div>";
	  echo "<div class='titulo'>Nome</div>";
	  echo "<div class='titulo'>Apelido</div>";
	
	  echo "<div class='titulo'>Cidade</div>";
	  echo "<div class='titulo'>Bairro</div>";
	  echo "<div class='titulo'>Endereço</div>";
	
	//Verificando se foi pedido por nome
	if ($_POST["pornome"] == "Por nome") {
		$palavras_nome = NULL;
	}
	
	else {
		$palavras_nome = explode(" ", $_POST["pornome"]);
	}
	
	//Verificando se foi pedido por endereço
	if ($_POST["porendereco"] == "Por endereço") {
		$palavras_endereco = NULL;
	}
	
	else {
		$palavras_endereco = explode(" ", $_POST["porendereco"]);
	}
	
	//criando o select usando as informações que foram pedidas pelos campos
	$query = "SELECT * FROM membros WHERE (";
	$or = false;
	if ($palavras_nome) {
		$runwhile = count($palavras_nome);
		$whiles = 0;
		while ($whiles < $runwhile)
		{
		  if ($or == true) { $query .= " OR "; }
		  $query .= " login LIKE '%".$palavras_nome[$whiles]."%'";
		  $query .= " OR nome LIKE '%".$palavras_nome[$whiles]."%'";
		  $query .= " OR sobrenome LIKE '%".$palavras_nome[$whiles]."%'";
		  $query .= " OR apelido LIKE '%".$palavras_nome[$whiles]."%'";
		  $or = true;
		  $whiles++;
		}
	}
	
	if ($palavras_endereco) {
		$runwhile = count($palavras_endereco);
		$whiles = 0;
		while ($whiles < $runwhile)
		{
		  if ($or == true) { $query .= " OR "; }
		  $query .= " cidade LIKE '%".$palavras_endereco[$whiles]."%'";
		  $query .= " OR bairro LIKE '%".$palavras_endereco[$whiles]."%'";
		  $query .= " OR logradouro LIKE '%".$palavras_endereco[$whiles]."%'";
		  $query .= " OR numero LIKE '%".$palavras_endereco[$whiles]."%'";
		  $query .= " OR complemento LIKE '%".$palavras_endereco[$whiles]."%'";
		  $whiles++;
		  $or = true;
		}
	}
	
	$query .= ") ";
	//TODAS AS PESSOAS QUE JÁ TIVEREM PODERES NÃO IRÃO APARECER
	$data = mysql_query("SELECT * FROM membros_poderes");
	while ($ja_exite = mysql_fetch_array($data)) {
		$query .= " AND IDmembros <> ".$ja_exite["IDmembros"];
	}
	
	//Chamando as informações de pesquisa no banco de dados e as exibindo
	$data = mysql_query($query);
	while($search = mysql_fetch_array($data))
	{
		//Colocando os valores em variaveis mais simples
		$login = $search["login"];
		$nome = $search["nome"]." ".$search["sobrenome"];
		$apelido = $search["apelido"];
		$cidade = $search["cidade"];
		$bairro = $search["bairro"];
		$logradouro = $search["logradouro"];
		$numero = $search["numero"];
		$endereco = $search["logradouro"].", ".$search["numero"];
		if ($search["complemento"]) { $endereco .= " - ".$search["complemento"]; }
		
		$whiles = 0; $runwhile = count($palavras_nome);
		while ($whiles < $runwhile) {
			$login = eregi_replace($palavras_nome[$whiles], "<b>".$palavras_nome[$whiles]."</b>", $login);
			$nome = eregi_replace($palavras_nome[$whiles], "<b>".$palavras_nome[$whiles]."</b>",  $nome);
			$nome .= " ".eregi_replace($palavras_nome[$whiles], "<b>".$palavras_nome[$whiles]."</b>", $sobrenome);
			$apelido = eregi_replace($palavras_nome[$whiles], "<b>".$palavras_nome[$whiles]."</b>", $apelido);
			$whiles++;
		}
		
		
		$whiles = 0; $runwhile = count($palavras_endereco);
		while ($whiles < $runwhile) {
			$cidade = eregi_replace($palavras_endereco[$whiles], "<b>".$palavras_endereco[$whiles]."</b>", $cidade);
			$bairro = eregi_replace($palavras_endereco[$whiles], "<b>".$palavras_endereco[$whiles]."</b>", $bairro);
			$endereco = eregi_replace($palavras_endereco[$whiles], "<b>".$palavras_endereco[$whiles]."</b>", $logradouro);
			$endereco .= ", ".eregi_replace($palavras_endereco[$whiles], "<b>".$palavras_endereco[$whiles]."</b>", $numero);
			$complemento = eregi_replace($palavras_endereco[$whiles], "<b>".$palavras_endereco[$whiles]."</b>", $complemento);
			if ($complemento) { $endereco .= " - ".$complemento; }
			$whiles++;
		}
		
		echo "<div class='resultado'>";
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$login."</div>";
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$nome."</div>";
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$apelido."</div>";
			
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$cidade."</div>";
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$bairro."</div>";
			echo "<div class='conteudo' onClick=\"turn_adm('".$search["IDmembros"]."', '".$search["apelido"]."')\">".$endereco."</div>";
		echo "</div><!-- fechando resultado -->";
	}
	
	echo "</div><!-- fechando pesquisa -->";
  }
  /* FIM DE PESQUISA */
  ?>

<!-- ADICIONANDO UM NOVO ADMINISTRADOR -->
<?php
if ($_POST["idmembros"]) {
	for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) {
		if ($_POST["add_adm_".$IntFor] == "on") {
			mysql_query("INSERT INTO membros_poderes (IDmembros, acesso) VALUES (".addslashes($_POST["idmembros"]).", ".$IntFor.")");
		}
	}
}
?>
<div id="css_back_black">
  <div id="js_add_adm" class='add_adm'>
    <div>
	  <form method="POST" action="">
	    <input type="hidden" id="js_membro_id" name="idmembros" value="" />
		<table> <!-- Tabela feita para dados tabulares, não vai contra a W3C -->
		  <tr>
			<td><b>Membros</b></td>
			<?php
			for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) {
				echo "<td>".$IntFor."</td>";
			}
			?>
		  </tr>
		  <tr>
			<td><span id="js_membro_nome"></span></td>
			<?php
			for ($IntFor = 1; $IntFor < ($n_de_acessos + 1); $IntFor++) {
				echo "<td><input type='checkbox' name='add_adm_".$IntFor."' /></td>";
			}
			?>
		  </tr>
		</table>
		<input type="submit" value="Salvar" />
		<?php
		$hidden = "";
		if ($_GET["hidden"] == true) {
			$hidden = "?hidden=true";
		}
		?>
		<input type="button" value="Cancelar" onClick="window.location.href = 'admadm.php<?php echo $hidden; ?>'" />
	  </form>
    </div>
  </div>
</div>

  
<?php //FOOTER E ETC
  include("../footer.php");
  if ($_GET["hidden"] == true) { //Esse carinha aqui verifica se o administrador deseja que as informações referentes aos acessos mantenham-se diminuidas ;D
	echo "<script> diminui(); </script>"; 
  }
?>
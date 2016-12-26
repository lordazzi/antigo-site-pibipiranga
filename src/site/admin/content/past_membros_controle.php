<?php
  include("../conn.php");
  if (!$_SESSION["S_poderes10"]) { header("../../content"); exit; }
  include("../header.php");
  include("../menu.php");
?>

<!-- Funções em JavaScript -->
<script language="javascript" type="text/javascript">
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
</script>
<script type="text/javascript" src="../../plugins/js/mascara/jquery.maskedinput-1.1.4.pack.js"/></script> <!-- mascara -->
</script><!-- mascara -->

<h1 style='text-align: center;'>Adicionar novo membro</h1>
<?
if ($_POST["novo_membro"]) {
	$erro = "";
	//validando o nome
	if ($_POST["nome"] != "") {
		if (onlyletter($_POST["nome"], " áãâéêíóôõú")) {
			$nome = addslashes($_POST["nome"]);
			$nome = ajeita($nome);
		}
		
		else {
			$erro .= "Você não pode colocar esses caracteres no campo de nome! \\n";
		}
	}
	
	else {
		$erro .= "O campo do nome não pode ser nulo. \\n";
	}
	
	//Validando o sobrenome
	if ($_POST["sobrenome"] != "") {
		if (onlyletter($_POST["sobrenome"], " áãâéêíóôõúç")) {
			$sobrenome = addslashes($_POST["sobrenome"]);
			$sobrenome = ajeita($sobrenome);
		}
		
		else {
			$erro .= "Você não pode colocar esses caracteres no campo de aobrenome! \\n";
		}
	}
	
	else {
		$erro .= "O campo do sobrenome não pode ser nulo. \\n";
	}
	
	//Validando o sexo
	if ($_POST["sexo"] == "F" OR $_POST["sexo"] == "M") {
		$sexo = addslashes($_POST["sexo"]);
	}
	
	else {
		$erro .= "Seu sexo não existe! \\n";
	}
	
	if ($_POST["tipo"] == "NL") {
		$erro .= "Escolha o tipo do membro. \\n";
	}
	
	else {
		if ($_POST["tipo"] == "MB" OR $_POST["tipo"] == "CG" OR $_POST["tipo"] == "HR" OR $_POST["tipo"] == "CR") {
			$tipo = addslashes($_POST["tipo"]);
		}
		
		else {
			$erro .= "Você escolheu um tipo de membro inválido!. \\n";
		}
	}
	
	//Cadastrando as informações se estiverem todas corretas.
	if ($erro == "") {
		//Gerando um login e senha
		$nome_login = explode(" ", $_POST["nome"]);
		$sobrenome_login = explode(" ", $_POST["sobrenome"]);
		$senha = $nome_login[0].MD5($sobrenome_login[0].date("Y-m-d"));
		$senha = substr($senha, 0, 15);//uma senha de 10 digitos
		
		//Verificando se o login que será criado já não esta sendo usado por outra pessoa....
		for ($IntFor = 0; $IntFor < count($nome_login); $IntFor++) {
			for ($IntFor2 = 0; $IntFor2 < count($sobrenome_login); $IntFor++) {
				$login = $nome_login[0].$sobrenome_login[0];
				$login = substr($login, 0, 30);
				$data = mysql_query("SELECT * FROM membros WHERE login='$login'");
				if (@mysql_num_rows($data) == 0) { //achamos o login, pode parar o for
					$IntFor = count($nome_login);
					$IntFor2 = count($sobrenome_login);
				}
				
				else {
					$login = "";
				}
			}
		}
		
		if ($login == "") { //Não acharam um login possivel com esse nome e sobrenome
			$login = $nome_login.date("Hdmy"); //gera um provisório
		}
		
		$login = strtolower($login);
		$senha = strtolower($senha);
		
		mysql_query("INSERT INTO membros (login, senha, nome, sobrenome, apelido, sexo, tipo) VALUES ('$login', '".MD5($senha)."', '$nome', '$sobrenome', '$nome', '$sexo', '$tipo')");
		echo "
			<script type='text/javascript'>
				alert('NOVO MEMBRO CADASTRADO! \\n \\n LOGIN: $login \\n SENHA: $senha \\n \\n Anote essas informações e entregue para o \\n usuário, ou elas serão perdidas! ');
			</script>
		";
	}
	
	else {
		echo "
			<script type='text/javascript'>
				alert('$erro');
			</script>
		";
	}
}
?>
<form method="POST" action="">
	<label for='nome'>		Nome:		<input type='text' name="nome" maxlength='30' />			</label><br />
	<label for='sobrenome'>	Sobrenome:	<input type='text' name="sobrenome" maxlength='75' />		</label><br />
	<label for='sexo'>		Sexo:
		<select name="sexo">
			<option value='M'>Masculino</option>
			<option value='F'>Feminino</option>
		</select>
	</label><br />
	<label for='tipo'>		Tipo de membro:
		<select name="tipo">
			<option value='NL'></option> <!-- Nenhum valor inserido-->
			<option value='MB'>Membro</option> <!-- Membros da PIBI -->
			<option value='CG'>Congregado</option> <!-- Crianças e membros que não foram ainda batizados -->
			<option value='HR'>Honorário</option> <!-- Pessoas que são membros de outras igrejas e que participam do site -->
			<option value='CR'>Curioso</option> <!-- Pessoa que quer participar do site que não é de igreja nem nada -->
		</select>
	</label><br />
	<input type="submit" name="novo_membro" value="Adicionar" />
</form>

<h1 style='text-align: center;'>Adicionar novo país ou estado</h1>
<form method="POST" action="">
	<table border='1'>
	<?
		$data_pais = mysql_query("SELECT * FROM endereco_paises ORDER BY nome");
		while ($pais = mysql_fetch_array($data_pais)) {
			echo "<tr>";
			echo "<td><b>".$pais["nome"]."</b></td>";
			$data_uf = mysql_query("SELECT * FROM endereco_uf WHERE IDpais=".$pais["IDpais"]." ORDER BY nome");
			while ($uf = mysql_fetch_array($data_uf)) {
				echo "<td>".$uf["nome"]."</td>";
			}
			echo "</tr>";
		}
	?>
	</table>
</form>

<h1 style='text-align: center;'>Editar membros já cadastrados</h1>
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

  include("../footer.php");
?>
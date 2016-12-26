<?php
include("../conn.php");
if (!$_SESSION["S_logado"] == true) { header("location: index.php"); exit; } //Essa página só é acessivel se o usuário estiver logado
include("../header.php");
include("../menu.php");
include("../leftbar.php");

if ($_POST["cadastro"]) {
	//PEGANDO OS PARAMETROS
	//Dados do cadastro
	$nome = ajeita($_POST["nome"]);
	$sobrenome = ajeita($_POST["sobrenome"]);
	$nascimento = $_POST["nascimento"]; $nascimento = explode("/", $nascimento);
	$sexo = $_POST["sexo"];
	$tipo = $_POST["tipo"];
	$cep = $_POST["cep"];
	$pais = $_POST["pais"];
	$pais_solicita = $_POST["pais_solicita"];
	$uf = $_POST["uf"];
	$uf_solicita = $_POST["uf_solicita"];
	$cidade = $_POST["cidade"];
	$bairro = $_POST["bairro"];
	$rua = $_POST["rua"];
	$numero = $_POST["numero"];
	$comp = $_POST["comp"];
	
	//Parâmetros de contatos
	for ($IntFor = 0; $IntFor < $_POST["cont_numero"]; $IntFor++)
	{
	  $true_name = $IntFor + 1;
	  $contatos[$IntFor][0] = $_POST["cont".$true_name."_tipo"];
	  $contatos[$IntFor][1] = $_POST["cont".$true_name];
	  if ($contatos[$IntFor][0] == "cel") {
		$contatos[$IntFor][2] = $_POST["cont".$true_name."_op"];
	  }
	}
	
	//Novo login gerado pelo usuário
	if ($_POST["novologin"] == "usenome") {
		$login = strtolower($_SESSION["S_nome"].$_POST["geralogin_nome"]);
	}
	
	elseif ($_POST["novologin"] == "usemail") {
		$login = $_POST["geralogin_mail"];
	}
	$perfil = $_POST["perfil"];
	
	//TRATAMENTO DE VARIAVEIS
	$errado = false; //as funções abaixo são do arquivo "functions.php"
	if (onlyletter($nome, " áãâéêçíóôõú") == false OR $nome == "") { $errado = true; $error_msg = " Você não pode colocar esses caracteres no campo de nome! "; }
	if (onlyletter($sobrenome, " áãâéêíóôõçú") == false OR $sobrenome == "") { $errado = true; $error_msg .= " Você não pode colocar esses caracteres no campo de sobnome! "; }
	if (!dateexists($nascimento[2]."-".$nascimento[1]."-".$nascimento[0]) OR !($nascimento[2] > (date("Y") - 125))) { $errado = true; $error_msg .= " A data de nascimento é inválida!"; }
	$nascimento = $nascimento[2]."-".$nascimento[1]."-".$nascimento[0];
	if ($sexo == "F" OR $sexo == "M") { } else { $errado = true; $error_msg .= " Seu sexo não existe! "; } //sexo M ou F
	if ($tipo == "MB" OR $tipo == "CG" OR $tipo == "HR" OR $tipo == "CR") { } else { $errado = true; $error_msg .= " Esse tipo de classificação para membros não existe! "; }
	//verificando o país selecionado
	$data = mysql_query("SELECT * FROM endereco_paises WHERE IDpais=".$_POST["pais"]);	
	if (@mysql_num_rows($data) != 1) { $errado = true; $error_msg .= " Houve um problema com o país selecionado! "; }
	$data = mysql_query("SELECT * FROM endereco_uf WHERE IDuf=".$_POST["uf"]." AND IDpais=".$_POST["pais"]);
	if (@mysql_num_rows($data) != 1) { $errado = true; $error_msg .= " Houve um problema com o estado selecionado! "; }
	
	if ($errado == false)
	{
	  //verifica se alguma informação foi alterada, se não é uma solicitação sem sentido
	  if ($_SESSION["S_nome"] == $nome AND $_SESSION["S_sobrenome"] == $sobrenome AND $_SESSION["S_sexo"] == $sexo AND $_SESSION["S_pais"] == $pais AND $pais_solicita AND $_SESSION["S_uf"] == $uf AND $uf_solicita AND $_SESSION["S_cidade"] == $cidade AND $_SESSION["S_bairro"] == $bairro AND $_SESSION["S_logradouro"] == $rua AND $_SESSION["S_numero"] == $numero AND $_SESSION["S_complemento"] == $comp AND $_SESSION["S_cep"] == $cep AND $_SESSION["S_nascimento"] == $nascimento AND $_SESSION["S_tipo"] == $tipo)
	  {
	  }
	  else {
		$data = mysql_query("SELECT * FROM membros_solicitacoes WHERE IDmembros=".$_SESSION["S_IDmembros"]);
		if (@mysql_num_rows($data) == 1 AND $_POST["solicita"] == "on")
		{
			mysql_query("UPDATE membros_solicitacoes SET nome='".addslashes($nome)."', sobrenome='".addslashes($sobrenome)."', sexo='".addslashes($sexo)."', cep='".addslashes($cep)."', pais='".addslashes($pais)."', pais_solicita='".addslashes($pais_solicita)."', uf='".addslashes($uf)."', uf_solicita='".addslashes($uf_solicita)."', cidade='".addslashes($cidade)."', bairro='".addslashes($bairro)."', logradouro='".addslashes($rua)."', numero='".addslashes($numero)."', complemento='".addslashes($comp)."', nascimento='".addslashes($nascimento)."', tipo='".addslashes($tipo)."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
			echo "<script>alert('Foi enviada uma solicitação de mudança de cadastro para o Administrador.')</script>";
		}
		elseif (@mysql_num_rows($data) == 0 AND $_POST["solicita"] == "on")
		{
			mysql_query("INSERT INTO membros_solicitacoes (IDmembros, nome, sobrenome, sexo, cep, pais, pais_solicita, uf, uf_solicita, cidade, bairro, logradouro, numero, complemento, nascimento, tipo) VALUES (".$_SESSION["S_IDmembros"].", '".addslashes($nome)."', '".addslashes($sobrenome)."', '".addslashes($sexo)."', '".addslashes($cep)."', '".addslashes($pais)."', '".addslashes($pais_solicita)."', '".addslashes($uf)."', '".addslashes($uf_solicita)."', '".addslashes($cidade)."', '".addslashes($bairro)."', '".addslashes($rua)."', '".addslashes($numero)."', '".addslashes($comp)."', '".addslashes($nascimento)."', '".addslashes($tipo)."')");
			echo "<script>alert('Uma nova solicitação de mudança de cadastro foi enviada para o Administrador.')</script>";
		}
		//Se o usuário tiver mais de uma solicitação de alteração de informações do cadastro, isso é impossivel
		else if ($_POST["solicita"] == "on") { echo "<script> alert('Erro interno! Por favor avise o administrador! A solicitação não enviada!'); </script>"; }
	  }
	}
	//caso alguma coisa esteja errada, ele mostra a mensagem de erro e cansela a solicitação (isso inclusive impede o mysqlInject)
	else { echo "<script> alert('".$error_msg.", solicitação não enviada!'); </script>"; }
	
	//INFORMAÇÕES ALTERAVEIS SEM SOLICITAÇÃO
  if ($_POST["altera"] == "on") {
    //Alterando apelido
	if (onlyletter($_POST["apelido"], "áãâêéíóõôú ") == true) {
	  mysql_query("UPDATE membros SET apelido='".$_POST["apelido"]."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	  $_SESSION["S_apelido"] = $_POST["apelido"];
	}
	
	else {
	  echo "<script>alert('Há caracteres inválidos no campo de Apelido e esse não pode ser alterado.');</script>";
	}
	
    //Deletando contatos
    $deleters = explode(".", $_POST["cont_count"]); //explodindo as vírgulas do valor do contador de contatos
	$some_delete = false;
	for ($IntFor = 0; $IntFor < count($deleters); $IntFor++)
	{
	  if ($_POST["delete".$deleters[$IntFor]] == "on")
	  {
	    mysql_query("DELETE FROM membros_contatos WHERE IDcontatos=".addslashes($deleters[$IntFor])." AND IDmembros=".$_SESSION["S_IDmembros"]);
		$some_delete = true;
	  }
	}
	
	if ($some_delete == true) { echo "<script>alert('Contato deletado com sucesso!')</script>"; }
	
    //Cadastrando contatos
	$whiles = 0;
	while ($whiles < $_POST["cont_numero"])
	{
	  $myname = $whiles + 1;
	  if ($_POST["cont".$myname] AND ($_POST["cont".$myname."_tipo"] == "cel" OR $_POST["cont".$myname."_tipo"] == "tel" OR $_POST["cont".$myname."_tipo"] == "mail"))
	  {
		//tratando o telefone
		if ($_POST["cont".$myname."_tipo"] == "cel" OR $_POST["cont".$myname."_tipo"] == "tel")
		{
	      //Tratando o prefixo para pessoas que moram no exterior
	      if ($_POST["cont".$myname."_prefix"]) { $prefix = addslashes($_POST["cont".$myname."_prefix"]); }
		  else { $prefix = "55"; }
		  
		  $telarray = explode(" ", $_POST["cont".$myname]);
		  $telarray[0] = str_replace("(", "", $telarray[0]);
		  $telarray[0] = str_replace(")", "", $telarray[0]);
		  $telarray[0] = addslashes($telarray[0]);
		  $telarray[1] = addslashes($telarray[1]);
		  
		  //Tratando o campo de operadora
		  if ($_POST["cont".$myname."_op"] == "claro" OR $_POST["cont".$myname."_op"] == "nextel" OR $_POST["cont".$myname."_op"] == "oi" OR $_POST["cont".$myname."_op"] == "tim" OR $_POST["cont".$myname."_op"] == "vivo" OR $_POST["cont".$myname."_op"] == "outra")
		  {
		    $op = $_POST["cont".$myname."_op"];
		  }
		  
		  else
		  {
		    if ($_POST["cont".$myname."_tipo"] == "cel") { $op = "outra"; } else { $op = ""; }
		  }
		  
	      mysql_query("INSERT INTO membros_contatos (IDmembros, prefix_pais, prefix_uf, contato, op, tipo) VALUES (".$_SESSION["S_IDmembros"].", '".$prefix."', '".$telarray[0]."', '".$telarray[1]."', '".$op."', '".addslashes($_POST["cont".$myname."_tipo"])."')");
		}
		
		elseif ($_POST["cont".$myname."_tipo"] == "mail")
		{
		  if (mail_valid($_POST["cont".$myname]) == true)
		  {
		    mysql_query("INSERT INTO membros_contatos (IDmembros, prefix_pais, prefix_uf, contato, op, tipo) VALUES (".$_SESSION["S_IDmembros"].", '', '', '".strtolower($_POST["cont".$myname])."', '', 'mail')");
		  }
		  else
		  {
		    echo "<script>O email que você digitou não é válido e foi ignorado.</script>";
		  }
		}
		
	  }
	  $whiles++;
	}
	
	//se a pessoa pediu para gerar um novo login
	if ($_POST["use_novologin"] == "on") 
	{
	  if ($_POST["novologin"] == "usenome")
	  {
	    $surnames = explode(" ", strtolower($_SESSION["S_sobrenome"]));//pega todos os sobrenomes do usuário para validar o novo login desejado
		$runwhile = count($surnames);
		$whiles = 0; $hack_try = true; //hack try quer dizer: sera que o que enviou a POST quer alterar o site por firebug ou outra ferramente adicionando campos para alterar os logins possivel
		while ($whiles < $runwhile)
		{
		  if ($_POST["geralogin_nome"] == $surnames[$whiles]) { $hack_try = false; } //falsifica a tentativa de Hack quando descobre que o login desejado realmente existe
		  $whiles++;
		}
		
		if ($hack_try == false) { mysql_query("UPDATE membros SET login='".strtolower($_SESSION["S_nome"].$_POST["geralogin_nome"])."' WHERE IDmembros=".$_SESSION["S_IDmembros"]); $_SESSION["S_login"] = strtolower($_SESSION["S_nome"].$_POST["geralogin_nome"]); } //não há necessidade de addslashes mais a variavel com a função addslashes() ou onlyletters()
		else { echo "<script>alert('Por favor, selecione apenas um dos nomes que você tem!');</script>"; }
	  }
	  
	  elseif ($_POST["novologin"] == "usemail")
	  {
	    $hack_try = true; //verifica se o usuário colocou alguma coisa além dos emails que ele tem como login
	    $data = mysql_query("SELECT * FROM membros_contatos WHERE IDmembros=".$_SESSION["S_IDmembros"]." AND tipo='mail'");
		while (@$checkmail = mysql_fetch_array($data))
		{
		  if ($checkmail["contato"] == $_POST["geralogin_mail"])
		  {
		    $hack_try = false; //é, de fato, ele colocou um email dele.
		  }
		}
		
		if ($hack_try == false) { mysql_query("UPDATE membros SET login='".strtolower($_POST["geralogin_mail"])."' WHERE IDmembros=".$_SESSION["S_IDmembros"]); $_SESSION["S_login"] = $_POST["geralogin_mail"]; } //da update no bd e nos session
		else { echo "<script>alert('Por favor, selecione apenas um email que você tem!');</script>"; }
	  }
	  
	  mysql_query("UPDATE membros SET perfil='".addslashes($_POST["perfil"])."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	}
	
	//gerar nova senha
	if ($_POST["use_changepass"] == "on")
	{
	  if ($_SESSION["S_senha"] == MD5($_POST["older"]) AND $_POST["senha1"] == $_POST["senha2"])
	  {
	    mysql_query("UPDATE membros SET senha='".MD5($_POST["senha1"])."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	  }
	  else
	  {
	    echo "<script>alert('Sua senha não pode ser alterada por um dos campos terem sido preenchidos de forma incorreta.')</script>";
	  }
	}
	
	//editando o perfil
	mysql_query("UPDATE membros SET perfil='".addslashes($_POST["perfil"])."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	$_SESSION["S_perfil"] = addslashes($_POST["perfil"]);
  }
}
?>

<!-- JavaScript da mascara -->
<script type="text/javascript" src="../../plugins/js/mascara/jquery.maskedinput-1.1.4.pack.js"/></script> <!-- mascara -->
<script type="text/javascript">
function loadmasks() {
	$("#cep").mask("99999-999");
	$("#data").mask("99/99/9999");
	$("#prefix").mask("99");
}
</script><!-- mascara -->

<!-- JavaScript da página de cadastro -->
<script type="text/javascript" src="../../plugins/js/cadastro.js"></script> 

<h1>Informações de <?php echo $_SESSION["S_nome"]." ".$_SESSION["S_sobrenome"];?></h1><br />
<?php
$data = mysql_query("SELECT * FROM membros_solicitacoes WHERE IDmembros=".$_SESSION["S_IDmembros"]);
if (@mysql_num_rows($data) == 1) { echo "<div id='alert2'>Sua última solicitação de alteração de informações<br />ainda não foi vista pelos administradores do site.</div>"; }
?>
<div id="alert">As informações do cadastro só serão<br />salvas/solicitadas se você clicar em cadastrar!</div>
<form method='POST' action=''>
	<div id="unchange_info">
		<fieldset>
		<legend><input type='checkbox' name='solicita' id='solicita'> Solicitar alteração dos campos abaixo?</legend>
			<span onClick='document.getElementById("solicita").checked=true;'>
				<i>Essas informações para serem alteradas precisam de confirmação da administração do site:</i><br />
				<label for='nome'>		Nome:		</label> <input type='text' name="nome" maxlength='30' value="<?php echo $_SESSION["S_nome"];?>"><br />
				<label for='sobrenome'>	Sobrenome:	</label> <input type='text' name="sobrenome" maxlength='75' value="<?php echo $_SESSION["S_sobrenome"];?>"><br />
				<?php $nasc = explode("-", $_SESSION["S_nascimento"]); ?>
				<label for='nascimento'> Nascimento:</label> <input type='text' name="nascimento" id="data" value="<?php echo  $nasc[2]."/".$nasc[1]."/".$nasc[0]; ?>"><br />
				<?php
					$male = ""; $female = "";
					  if ($_SESSION["S_sexo"] == "M") { $male = " selected='selected'"; }
					elseif ($_SESSION["S_sexo"] == "F") { $female = " selected='selected'"; }
				?>
				<label for='sexo'>		Sexo:		</label> 
				<select name="sexo">
					<option value='M' <?php echo $male; ?>>Masculino</option>
					<option value='F' <?php echo $female; ?>>Feminino</option>
				</select><br />
				<br />
				<?php
					$MB = ""; $CG = ""; $HR = ""; $CR = ""; $NULL = "";
					if ($_SESSION["S_tipo"] == "MB") { $MB = " selected='selected'"; }
					elseif ($_SESSION["S_tipo"] == "CG") { $CG = " selected='selected'"; }
					elseif ($_SESSION["S_tipo"] == "HR") { $HR = " selected='selected'"; }
					elseif ($_SESSION["S_tipo"] == "CR") { $CR = " selected='selected'"; }
					else { $NL = " selected='selected' "; }
				?>
				<label for='tipo'>		Tipo de membro:</label>
				<select name="tipo">
					<option value='NL' <?php echo $NL; ?>></option> <!-- Nenhum valor inserido-->
					<option value='MB' <?php echo $MB; ?>>Membro</option> <!-- Membros da PIBI -->
					<option value='CG' <?php echo $CG; ?>>Congregado</option> <!-- Crianças e membros que não foram ainda batizados -->
					<option value='HR' <?php echo $HR; ?>>Honorário</option> <!-- Pessoas que são membros de outras igrejas e que participam do site -->
					<option value='CR' <?php echo $CR; ?>>Curioso</option> <!-- Pessoa que quer participar do site que não é de igreja nem nada -->
				</select><br />
				<br />
				<label for='cep'>		CEP: 		</label> <input type='text' name="cep" id="cep" style="width: 50px;" value="<?php echo $_SESSION["S_cep"] ?>" maxlength='9'><br />
				<label for='pais'>		País:		</label> 
				<select name="pais">
					<option value='pais0' selected="selected"></option>
					<?php
						$data = mysql_query("SELECT * FROM endereco_paises ORDER BY IDpais");
						while ($pais = mysql_fetch_array($data)) {
							$selected = "";
							if ($pais["IDpais"] == $_SESSION["S_pais"]) { $selected = " selected='selected'"; }
							echo "<option id='pais".$pais["IDpais"]."' value='".$pais["IDpais"]."' ".$selected.">".$pais["nome"]."</option>";
						}
						$selected = "";
					?>
				</select> <i id="js_pais_solicita" onClick="paissolicita()" style="cursor: pointer;">Clique aqui para solicitar um novo país.</i><br />
				<label for='uf'>		Estado:		</label>
				<select name="uf">
				  <option value='ufid0' selected='selected'></option>
				  <?php
					$data = mysql_query("SELECT * FROM endereco_uf ORDER BY IDuf");
					while ($uf = mysql_fetch_array($data)) {
						$selected = ""; echo $uf["IDuf"]."=".$_SESSION["S_uf"]."<br />";
						if ($uf["IDuf"] == $_SESSION["S_uf"]) { $selected = " selected='selected'"; }
						echo "<option id='ufid".$uf["IDuf"]."' value='".$uf["IDuf"]."' ".$selected.">".$uf["nome"]."</option>";
					}
				  ?>
				</select> <i id="js_uf_solicita" onClick="ufsolicita()" style="cursor: pointer;">Clique aqui para solicitar um novo estado.</i><br />
				<label for='cidade'>	Cidade: 	</label> <input type='text' name="cidade" maxlength='128' value="<?php echo $_SESSION["S_cidade"]; ?>"><br />
				<label for='bairro'>	Bairro: 	</label> <input type='text' name="bairro" maxlength='128' value="<?php echo $_SESSION["S_bairro"]; ?>"><br />
				<label for='rua'>		Logradouro: </label> <input type='text' name="rua" maxlength='128' value="<?php echo $_SESSION["S_logradouro"]; ?>"><br />
				
				<label for='numero'>	Número: 	</label> <input type='text' name="numero" maxlength='24' value="<?php echo $_SESSION["S_numero"]; ?>"><br />
				<label for='comp'>	Complemento:	</label> <input type='text' name="comp" maxlength='64' value="<?php echo $_SESSION["S_complemento"]; ?>"><br />
			</span>
		</fieldset>
	</div>
  
  <br />
	<div id="canchange_info">
		<fieldset>
			<legend><input type="checkbox" name="altera" id="altera"> Alterar os campos abaixo?</legend>
			<span onClick='document.getElementById("altera").checked=true;'>
			<i>Essas informações você pode mudar como desejar, quando quiser:</i><br />
			<label for='apelido'>	Apelido:	</label> <input type='text' name="apelido" maxlength='15' value="<?php echo $_SESSION["S_apelido"] ?>"><br />
			<br />
			<?php
				$data = mysql_query("SELECT * FROM membros_contatos WHERE IDmembros=".$_SESSION["S_IDmembros"]);
				while ($contats = mysql_fetch_array($data)) {
						if ($contats["tipo"] == "mail") {
						echo "<i>Deletar?</i> <input type='checkbox' name='delete".$contats["IDcontatos"]."'> <label style='float: none; font-weight: bold;'>".$contats["contato"]."</label><br />";
					}

					elseif ($contats["tipo"] == "tel") {
						echo "<i>Deletar?</i> <input type='checkbox' name='delete".$contats["IDcontatos"]."'> <label style='float: none; font-weight: bold;'>(".$contats["prefix_pais"].$contats["prefix_uf"].") ".$contats["contato"]."</label><br />";
					}

					elseif ($contats["tipo"] == "cel") {
						echo "<i>Deletar?</i> <input type='checkbox' name='delete".$contats["IDcontatos"]."'> <label style='float: none; font-weight: bold;'>(".$contats["prefix_pais"].$contats["prefix_uf"].") ".$contats["contato"]." (".$contats["op"].")</label><br />";
					}
					$allid .= $contats["IDcontatos"].".";
				}
			?>
			<input type="hidden" name="cont_count" value="<?php echo substr($allid, 0, strlen($allid) - 1); ?>">
			<span id="js_contato">
			<!-- Aqui dentro existe a manipulação de telefones feita apenas por JavaScript e JQuery -->
			</span>
			<input type="hidden" name="cont_numero" id="cont_numero">
			<span class='botao' onClick="addcontato(<?php echo $_SESSION["S_pais"]; ?>);" title="Clique aqui para inserir mais telefones, celulares ou emails">+ Contato</span><br /> <br />
			<br />
			<input type="checkbox" name="use_novologin" id="use_novologin" style='float: left; margin: 0 0 0 50px; width: 5px;'>
			<div OnClick="document.getElementById('use_novologin').checked=true">
			Gerar novo login:<br />
			<label for="novologin" class="nofloat"> <input type="radio" name="novologin" id="usenome" value="usenome" checked> Usar meu nome: </label>
			<?php 
				$login_found = false; //procura o login
				//pegando o primeiro nome, caso a pessoa tenha dois
				$nome1 = explode(" ", $_SESSION["S_nome"]);
				echo "<b>".strtolower($nome1[0])."</b>";
				$surname_array = explode(" ", $_SESSION["S_sobrenome"]);
				echo "<select name='geralogin_nome' onClick='document.getElementById(\"usenome\").checked=true'>";
				$runtimes = count($surname_array); $whiles = 0;
				while ($whiles < $runtimes) {
					$selected = "";
					if (strtolower($nome1[0].$surname_array[$whiles]) == $_SESSION["S_login"]) { $login_found = true; $selected = " selected='selected'"; }
					echo "<option value='".strtolower($surname_array[$whiles])."' $selected>".strtolower($surname_array[$whiles])."</option>";
					$whiles++;
				}
				echo "</select>
				<br />";
			?>
			<label for="novologin" class="nofloat"> <input type="radio" name="novologin" id="usemail" value="usemail"> Use meu email: </label>
			<?php 
				echo "<select name='geralogin_mail' style='width: 170px;' onClick='document.getElementById(\"usemail\").checked=true'>";
				$data = mysql_query("SELECT * FROM membros_contatos WHERE IDmembros='".$_SESSION["S_IDmembros"]."' AND tipo='mail'");
				while (@$emails = mysql_fetch_array($data)) {
					echo "<option value='".$emails["contato"]."'>".$emails["contato"]."</option>";
				}
				echo "</select>";
			?>
			</div>
			<br />
			<input type="checkbox" name="use_changepass" id="use_changepass" style='float: left; margin: 0 0 0 50px; width: 5px;'>
			<div OnClick="document.getElementById('use_changepass').checked=true">
			Gerar nova senha:<br />
			<i>Digite a senha antiga:</i><br />
			<input type='password' name="older" style='margin: 0 0 0 30px;'><br />
			<i>Digite a confirme nova senha:</i><br />
			<input type='password' name="senha1" style='margin: 0 0 0 30px;'><br />
			<input type='password' name="senha2" style='margin: 0 0 0 30px;'>
			</div>
			<br />
			Escreve alguma coisa sobre você:<br />
			<textarea name="perfil"><?php echo $_SESSION["S_perfil"]; ?></textarea><br />
			</span>
		</fieldset>
	</div>
	<br />
	<input type='submit' name="cadastro" id="cadastro_btn" value='Cadastrar'>
</form>

<h1>Trocar minha foto</h1>
	<center>
		<form method="POST" name="photo" action="cadastro_imagem.php" enctype="multipart/form-data" target="_blank">
			<input type="file" name="image" size='1' /> <input type="submit" name="upload" value="Alterar imagem" style="border: 1px solid #000000; background-color: #FFFFFF;" />
		</form>
	</center>

<!-- Da inicio às funções assim que a página é carregada-->
<script type="text/javascript">
	loadmasks();
	addcontato(<?php echo $_SESSION["S_pais"]; ?>);
</script>
<?php
include("../rightbar.php");
include("../footer.php");
?>

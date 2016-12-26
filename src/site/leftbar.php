<?php

//POSSIBILIDADES DA TELA DE LOGIN
//Primeiro acesso: criando uma nova senha
if ($_SESSION["S_ultimaentrada"] == "0000-00-00 00:00:00") {
  $login_screen = "
		<form method='POST' action='../actions/changepass.php'>
			<h1>Primeiro acesso,<br />crie nova senha:</h1>
			Login: <input name='login' value='".$_SESSION["S_login"]."' type='text' onlyread='onlyread' disabled='disabled'><br />
			Nova senha: <input name='senha1' type='password'><br />
			Confirmar: <input name='senha2' type='password'><br />
			<input value='Alterar' type='submit' style='margin: 10px 0 0 8px;'>
			<input type='hidden' name='novasenha' value='1'>
			<input value='Sair' type='button'  style='margin: 10px 0 0 8px;' OnClick='window.location.href=\"../actions/logoff.php\"'>
		</form>";
}

//Logado
elseif ($_SESSION["S_logado"] == true) {
  if 	 ($_SESSION["S_sexo"] == "M") { $gender = "o"; }
  elseif ($_SESSION["S_sexo"] == "F") { $gender = "a"; }
  $data = mysql_query("SELECT * FROM membros WHERE IDmembros=".$_SESSION["S_IDmembros"]);
  $membro = mysql_fetch_array($data);
  $login_screen = "
  		<form>
			<IMG src='../../arquivo/fotos_membros/".$membro["foto"]."' width='175' style='cursor:pointer' onClick=\" window.location.href = 'membro.php'; \" />
			<h1>Bem vind$gender <br />".$_SESSION["S_apelido"]."!</h1>
			<input value='Sair' type='button' style='margin: -40px 0 45px 125px; float: right;' OnClick='window.location.href=\"../actions/logoff.php\"'>
		</form>";
}

//Log off
else {
  $login_screen = "
		<form method='POST' action='../actions/login.php'>
			<h1>Faça seu login:</h1>
			Login: <input name='login' type='text'><br />
			Senha: <input name='senha' type='password'><br />
			<input type='hidden' name='dologin' value='1'>
			<span class='error' ".$error[0]."><br />Login ou senha incorreto!</span>
			<input value='Entrar' type='submit'>
		</form>";
}

?>
  <div id="leftbar">
  <!-- LOGIN -->
	<div id="login">
		<?php echo $login_screen; ?>
	</div>
	
  <!-- ANIVERSARIANTES DO MÊS -->
	<div id="nivers">
	<h1>Aniversariantes:</h1>
	<?php
	  $hojeD = date("d");
	  $hojeM = date("m");
	  $hojeY = date("Y");
	  $data = mysql_query("SELECT apelido, nascimento FROM membros WHERE tipo='MB' OR tipo='CG'");

	  $whileint = 0;
	  while ($niversdb = mysql_fetch_array($data))
	  {
		//não alterar essa forma, se nao mexe na ordem alfabética, sequencia: MES DIA NOME
		if (substr($niversdb["nascimento"], 5, 2) == "01" AND $hojeM == 12) { $mes = "13"; } //para evitar erros no mês de dezembro, o mês de  janeiro é transformado em 13º mês
		elseif (substr($niversdb["nascimento"], 5, 2) == "02" AND $hojeM == 12) { $mes = "14"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "03" AND $hojeM == 12) { $mes = "15"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "04" AND $hojeM == 12) { $mes = "16"; }
		elseif (substr($niversdb["nascimento"], 5, 2) == "05" AND $hojeM == 12) { $mes = "17"; }
		else { $mes = substr($niversdb["nascimento"], 5, 2); }
		$niversarray[$whileint] = $mes . "/" . substr($niversdb["nascimento"], 8, 2) . "; apelido: " . $niversdb["apelido"]; //Ordem: mm/dd; apelido: xxx
		$whileint++;
	  }
	  sort($niversarray);
	  
	  $runarray = 0; $finishwhile = 0;
	  while ($finishwhile != 10) //mostra 10 aniversariantes
	  {
		$dia = substr($niversarray[$runarray], 3, 2);
		$mes = substr($niversarray[$runarray], 0, 2);
		$wherenome = strpos($niversarray[$runarray], "apelido: ");
		$wherenome = $comeca_nome + 15;
		$o_nome = substr($niversarray[$runarray], $wherenome);

		
		if (($hojeM < $mes) OR ($hojeM == $mes AND $hojeD <= $dia))
		{
		  if ($mes == "13") { $mes = "01"; }
		  if ($hojeM == $mes AND $hojeD == $dia) { echo "<p class='red'>"; }
		  else                                   { echo "<p>"; }
		  echo "<b>" . $o_nome . "</b> [" . $dia . "/" . $mes . "]<br /></p>";
		  $finishwhile++;
		}
		$runarray++;
	  }
	?>
		</div>
	
  </div><!-- fim do leftbar -->
  <div id="content"> <!-- Abre a ID content fora da página CONTENT, por serem várias páginas -->
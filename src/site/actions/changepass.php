<?php
include("../conn.php");
global $error;
if ($_SESSION["S_logado"] AND $_POST["novasenha"] == 1) { //criando nova senha para primeiro acesso
	if ($_POST["senha1"] == $_POST["senha2"]) {
		if (strlen($_POST["senha1"]) > 5)	{
			mysql_query("UPDATE membros SET senha='".MD5($_POST["senha1"])."', ultimaentrada='".date("Y-m-d h:i:s")."' WHERE IDmembros=".$_SESSION["S_IDmembros"]);
			$_SESSION["S_ultimaentrada"] = date("Y-m-d h:i:s");
		}

		else {
			echo "
				<script type='text/javascript'>
					alert('A senha escolhida é muito curta, ele deve ter mais de 6 digitos.');
					window.location.href = '../content/index.php';
				</script>
			";
			exit;
		}
	}

	else {
		echo "
				<script type='text/javascript'>
					alert('As senhas não coincidem!');
					window.location.href = '../content/index.php';
				</script>
			";
			exit;
	}
}

header("location: ../content/cadastro.php");

?>
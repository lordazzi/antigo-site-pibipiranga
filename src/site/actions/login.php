<?php
include("../conn.php");
global $error;
if ($_POST["dologin"] == 1) //fazendo login
{
  $login = addslashes($_POST["login"]);
  $data = mysql_query("SELECT * FROM membros WHERE login='".$login."' AND senha='".MD5($_POST["senha"])."'");
  
  if (@mysql_num_rows($data) != 0)
  {
    //Considerando logado
    $_SESSION["S_logado"] = true;
	
	//Chamando dados pessoais
    $user = mysql_fetch_array($data);
	//associando a pessoa que está se logando com o IP do visitante
	mysql_query("UPDATE visitas SET idmembros=".$user["IDmembros"]." WHERE ipadress='".getip()."' AND data='".date("Y-m-d")."'");
	
	//transferindo as informações do usuário para variaveis globais
	$_SESSION["S_IDmembros"] = $user["IDmembros"];
	$_SESSION["S_ultimaentrada"] = $user["ultimaentrada"];
	$_SESSION["S_login"] = $user["login"];
	$_SESSION["S_senha"] = $user["senha"];
	$_SESSION["S_nome"] = $user["nome"];
	$_SESSION["S_sobrenome"] = $user["sobrenome"];
	$_SESSION["S_apelido"] = $user["apelido"];
	$_SESSION["S_sexo"] = $user["sexo"];
	$_SESSION["S_pais"] = $user["pais"];
	$_SESSION["S_uf"] = $user["uf"];
	$_SESSION["S_cidade"] = $user["cidade"];
	$_SESSION["S_bairro"] = $user["bairro"];
	$_SESSION["S_logradouro"] = $user["logradouro"];
	$_SESSION["S_numero"] = $user["numero"];
	$_SESSION["S_complemento"] = $user["complemento"];
	$_SESSION["S_cep"] = $user["cep"];
	$_SESSION["S_nascimento"] = $user["nascimento"];
	$_SESSION["S_tipo"] = $user["tipo"];
	
	//chamando os contatos
	$data = mysql_query("SELECT * FROM membros_contatos WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	$whiles = 0;
	while($contatos = mysql_fetch_array($data))
	{
	  $tel_array[$whiles][0] = $contatos["IDcontatos"];
	  $tel_array[$whiles][1] = $contatos["prefix"];
	  $tel_array[$whiles][2] = $contatos["contato"];
	  $tel_array[$whiles][3] = $contatos["tipo"];
	  $whiles++;
	}
	$_SESSION["S_contatos"] = $tel_array;
	
	for ($IntFor = 1; $IntFor <= ACESSOS_QTD; $IntFor++) {
		$_SESSION["S_poderes$IntFor"] = false;
	}
	
	$data = mysql_query("SELECT * FROM membros_poderes WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	while($acessos = mysql_fetch_array($data))
	{
		for ($IntFor = 1; $IntFor <= ACESSOS_QTD; $IntFor++) {
			if ($acessos["acesso"] == $IntFor) { $_SESSION["S_poderes$IntFor"] = true; }
		}
	}
	
	//cadastrando a hora em que o usuário fez o login
	if ($_SESSION["S_ultimaentrada"] != "0000-00-00 00:00:00")
	{
	  mysql_query("INSERT INTO membros (ultimaentrada) VALUES ('".date("Y-m-d h:i:s")."') WHERE IDmembros=".$_SESSION["S_IDmembros"]);
	}
	$error[0] = "";
  }
  
  else
  {
	$error[0] = "style='display: block;'";
  }
}
header("location: ../content/index.php");
?>
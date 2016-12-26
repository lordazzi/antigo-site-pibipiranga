<?php
//ARQUIVO DE LOGOFF
session_start();
unset($_SESSION["S_logado"]);
unset($_SESSION["S_IDmembros"]);
unset($_SESSION["S_ultimaentrada"]);
unset($_SESSION["S_login"]);
unset($_SESSION["S_senha"]);
unset($_SESSION["S_nome"]);
unset($_SESSION["S_sobrenome"]);
unset($_SESSION["S_apelido"]);
unset($_SESSION["S_sexo"]);
unset($_SESSION["S_pais"]);
unset($_SESSION["S_uf"]);
unset($_SESSION["S_cidade"]);
unset($_SESSION["S_bairro"]);
unset($_SESSION["S_logradouro"]);
unset($_SESSION["S_numero"]);
unset($_SESSION["S_complemento"]);
unset($_SESSION["S_cep"]);
unset($_SESSION["S_nascimento"]);
unset($_SESSION["S_tipo"]);
unset($_SESSION["S_contatos"]);
unset($_SESSION["S_poderes"]);

for ($IntFor = 1; $IntFor <= ACESSOS_QTD; $IntFor++) {
	unset($_SESSION["S_poderes".$IntFor]);
}
session_destroy();
echo "<script language='javascript'>window.location.href='../content/index.php'</script>";
?>